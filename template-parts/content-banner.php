<?php
/**
 * Баннер и меню под ним (динамическая версия)
 * 
 * @param array $args {
 *     @type array  $banner_desktop  - данные десктопного баннера (url, width, height)
 *     @type array  $banner_tablet   - данные планшетного баннера
 *     @type array  $banner_mobile   - данные мобильного баннера
 *     @type string $banner_alt      - alt текст изображения
 * }
 */
// Генерируем универсальный ALT на основе названия и описания сайта
$site_name = get_bloginfo('name');
$site_description = get_bloginfo('description');
$default_alt = $site_name . ($site_description ? ' — ' . $site_description : '');

$args = wp_parse_args($args, [
    'banner_desktop' => [],
    'banner_tablet'  => [],
    'banner_mobile'  => [],
    'banner_alt'     => $default_alt,
]);
?>

<section class="banner-wrap">
    <div class="banner-wrapper">
        <div class="banner-item">
            <picture>
                <source 
                    media="(max-width: 575px)"
                    srcset="<?php echo esc_url($args['banner_mobile']['url'] ?? ''); ?>"
                    type="image/webp"
                    width="800"
                    height="450"
                >
                <source 
                    media="(max-width: 1024px)"
                    srcset="<?php echo esc_url($args['banner_tablet']['url'] ?? ''); ?>"
                    type="image/webp"
                    width="1200"
                    height="675"
                >
                <source 
                    srcset="<?php echo esc_url($args['banner_desktop']['url'] ?? ''); ?>"
                    type="image/webp"
                    width="1920"
                    height="1080"
                >
                <img 
                    src="<?php echo esc_url($args['banner_desktop']['url'] ?? ''); ?>"
                    fetchpriority="high"
                    alt="<?php echo esc_attr($args['banner_alt']); ?>"
                    class="banner-img"
                    width="1920"
                    height="1080"
                    decoding="async"
                >
            </picture>
        </div>
    </div>
</section>

<section class="brand-wrap">
    <div class="container-brand-row">
        <?php
        if (has_nav_menu('menu-line')) {
            wp_nav_menu([
                'theme_location' => 'menu-line',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new Simple_Nav_Menu_Walker(),
            ]);
        }
        ?>
    </div> 
</section>