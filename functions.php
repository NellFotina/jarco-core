<?php
/**
 * Jarco Core - Универсальное ядро для сайтов группы Jarco
 * Оптимизировано под WP 6.7+
 * @package jarco-core
 */
use PHPMailer\PHPMailer\PHPMailer;

defined( 'ABSPATH' ) || exit;

// 1. КОНСТАНТЫ И ВЕРСИЯ
if ( ! defined( 'JARCO_VERSION' ) ) {
    define( 'JARCO_VERSION', wp_get_theme()->get( 'Version' ) );
}

/**
 * 2. ИНИЦИАЛИЗАЦИЯ (для WP 6.7)
 */
add_action('after_setup_theme', function() {
    // А) Сначала загружаем текстовый домен (статические переводы)
    load_theme_textdomain('jarco-core', get_template_directory() . '/languages');

    // Б) Затем подключаем ГЛОБАЛЬНЫЕ ОПЦИИ (Redux) (чтобы его переводы не вызывали ошибку)
    $jarco_redux = get_template_directory() . '/inc/redux-config.php';
    if ( file_exists( $jarco_redux ) ) {
        require_once $jarco_redux;
    }

    // В) Подключаем динамические переводы Polylang
    $translation_files = [
        'polylang-general.php'
    ];
    foreach ($translation_files as $file) {
        $file_path = get_template_directory() . '/inc/translations/' . $file;
        if (file_exists($file_path)) {
            require $file_path;
        }
    }
}, 5); // Приоритет 5 - самое начало

/**
 * 3. ГЛОБАЛЬНЫЕ ФУНКЦИИ ОПЦИЙ
 */
if ( ! function_exists( 'get_jarco_options' ) ) {
    function get_jarco_options() {
        static $options = null;
        if ( $options === null ) {
            $options = get_option( 'global_options', [] );
            if ( empty( $options ) && class_exists( 'Redux' ) ) {
                $redux = Redux::instance( 'global_options' );
                if ( $redux ) { $options = $redux->get_options(); }
            }
        }
        return is_array( $options ) ? $options : [];
    }
}

function jarco_get_lang_opt($id) {
    $options = get_jarco_options();
    if (empty($options)) return '';
    if ( function_exists('pll_current_language') ) {
        $current_lang = pll_current_language('slug');
        $full_id = $id . '_' . $current_lang;
        if ( !empty($options[$full_id]) ) return $options[$full_id];
    }
    return $options[$id] ?? '';
}

// 3. НАСТРОЙКИ ТЕМЫ (Общие для всех брендов)
add_action( 'after_setup_theme', function() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'] );
    
    // WooCommerce галерея (общая для всех брендов)
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox'); 
    add_theme_support('wc-product-gallery-slider');

    // Универсальные области меню
	register_nav_menus(
		array(
			'menu-header' => esc_html__( 'Menu Header', 'jarco-core' ),
			'menu-footer1' => esc_html__( 'Menu Footer1', 'jarco-core' ),
			'menu-footer2' => esc_html__( 'Menu Footer2', 'jarco-core' ),
		)
	);

});

// 4. СКРИПТЫ (Базовые)
add_action( 'wp_enqueue_scripts', function() {
    // 1. Цвета и шрифты дочерней темы: get_stylesheet_uri() берет style.css из папки активного бренда
    wp_enqueue_style('jarco-brand', get_stylesheet_uri(), [], JARCO_VERSION);
    // 2. Для баннера - SWIPER CSS
    wp_enqueue_style('jarco-swiper-css', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', [], '12.1.0');
    // 3. ОСНОВНАЯ ВЕРСТКА (main.css из ядра) зависит от бренда (цвета) и свипера (структура слайдов)
    wp_enqueue_style('jarco-main', get_template_directory_uri() . '/assets/css/main.css', ['jarco-brand', 'jarco-swiper-css'], JARCO_VERSION);
    wp_enqueue_script('jquery');

    // 5. Для баннера - SWIPER JS
    wp_enqueue_script('jarco-swiper-js', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', [], '12.1.0', true);
    // Логика баннера и меню: обязательно в массив [] добавляем 'jarco-swiper-js', чтобы script.js не сработал раньше свипера
    wp_enqueue_script('jarco-script', get_template_directory_uri() . '/assets/js/script.js', ['jquery', 'jarco-swiper-js'], JARCO_VERSION, true);
});

// 5. АДМИНКА (Копирование, SMTP, скрытие редактора)

/* Копирование */
add_filter('post_row_actions', 'jarco_add_duplicate_link', 10, 2);
add_filter('page_row_actions', 'jarco_add_duplicate_link', 10, 2);
function jarco_add_duplicate_link($actions, $post) {
    if (!current_user_can('edit_posts')) return $actions;
    $url = wp_nonce_url(admin_url('admin.php?action=jarco_duplicate&post=' . $post->ID), 'jarco_nonce');
    $actions['duplicate'] = '<a href="' . esc_url($url) . '">Копировать</a>';
    return $actions;
}

add_action('admin_action_jarco_duplicate', function() {
    if (!isset($_GET['post'], $_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'jarco_nonce')) wp_die('Security Error');
    $id = (int)$_GET['post'];
    $post = get_post($id);
    $new_id = wp_insert_post([
        'post_title' => $post->post_title . ' (Копия)',
        'post_content' => $post->post_content,
        'post_status' => 'draft',
        'post_type' => $post->post_type,
        'post_author' => get_current_user_id(),
    ]);
    $meta = get_post_meta($id);
    foreach ($meta as $key => $values) {
        foreach ($values as $value) update_post_meta($new_id, $key, maybe_unserialize($value));
    }
    wp_redirect(admin_url('post.php?action=edit&post=' . $new_id));
    exit;
});

/**
 * Настройка SMTP START
 * @param PHPMailer $phpmailer объект мэилера
 */
function jarco_send_smtp_email( PHPMailer $phpmailer ) {
  $phpmailer->isSMTP();
  $phpmailer->Host       = SMTP_HOST;
  $phpmailer->SMTPAuth   = SMTP_AUTH;
  $phpmailer->Port       = SMTP_PORT;
  $phpmailer->Username   = SMTP_USER;
  $phpmailer->Password   = SMTP_PASS;
  $phpmailer->SMTPSecure = SMTP_SECURE;
  $phpmailer->Sender     = SMTP_FROM;
  $phpmailer->From       = SMTP_FROM;
  $phpmailer->FromName   = SMTP_NAME; 

  if ( SMTP_DEBUG > 0 ) {
    $phpmailer->SMTPDebug = SMTP_DEBUG;
  }
}
add_action( 'phpmailer_init', 'jarco_send_smtp_email' );
/* Настройка SMTP END */

/* Полное отключение всех RSS фидов */
// a. Возвращаем 404 при попытке зайти на фид
function jarco_disable_feeds_gracefully() {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404); 
    exit();
}
add_action('do_feed',      'jarco_disable_feeds_gracefully', 1);
add_action('do_feed_rdf',  'jarco_disable_feeds_gracefully', 1);
add_action('do_feed_rss',  'jarco_disable_feeds_gracefully', 1);
add_action('do_feed_rss2', 'jarco_disable_feeds_gracefully', 1);
add_action('do_feed_atom', 'jarco_disable_feeds_gracefully', 1);

// b. Добавляем noindex заголовки (на всякий случай)
function jarco_add_noindex_to_feeds() {
    header("X-Robots-Tag: noindex, nofollow, noarchive");
}
add_action('rss_tag_pre',  'jarco_add_noindex_to_feeds');
add_action('rss2_tag_pre', 'jarco_add_noindex_to_feeds');
add_action('atom_tag_pre', 'jarco_add_noindex_to_feeds');

// c. Чистим <head> от ссылок на фиды
remove_action('wp_head', 'feed_links', 2);       // Основные ленты
remove_action('wp_head', 'feed_links_extra', 3); // Ленты комментариев и категорий

/* Универсальное скрытие редактора по массиву ID */
add_action('admin_init', function() {
    $post_id = $_GET['post'] ?? $_POST['post_ID'] ?? 0;
    if (!$post_id) return;
    
    $options = get_jarco_options();
    $disabled_ids = $options['disabled_editor_ids'] ?? [];
    
    // Приводим к массиву, чтобы избежать ошибок PHP
    if ( !is_array($disabled_ids) ) $disabled_ids = [];

    if (in_array((string)$post_id, $disabled_ids)) {
        remove_post_type_support('page', 'editor');
    }
});

/**
 * Отключаем Корзину и Кассу WooCommerce, пока магазин не работает
 */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');  
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

// 6. Автоматическое обновление темы с GitHub
if ( file_exists( get_template_directory() . '/inc/theme-update-checker.php' ) ) {
    require_once get_template_directory() . '/inc/theme-update-checker.php';
}