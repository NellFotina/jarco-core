<?php
/**
 * Конфигурация Redux Framework для темы Jarco Core
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Redux' ) ) {
    return;
}

// Имя опции в базе данных и название глобальной переменной
$opt_name = 'global_options'; 

// Настройка текстового домена для перевода интерфейса самой панели
add_filter('redux/textdomain', function() {
    return 'jarco-core';
});

$theme = wp_get_theme();

/*
 * ---> НАСТРОЙКИ ПАНЕЛИ (АРГУМЕНТЫ)
 */
$args = array(
    'opt_name'           => $opt_name,
    'display_name'       => 'Jarco Theme Settings',
    'display_version'    => $theme->get( 'Version' ),
    'menu_type'          => 'menu',
    'allow_sub_menu'     => true,
    'menu_title'         => esc_html__( 'Настройки темы', 'jarco-core' ),
    'page_title'         => esc_html__( 'Глобальные настройки Jarco', 'jarco-core' ),
    'admin_bar'          => true,
    'admin_bar_icon'     => 'dashicons-admin-generic',
    'global_variable'    => $opt_name,
    'dev_mode'           => false, // Поставь true, если нужно видеть отладочную инфо Redux
    'customizer'         => true,
    'page_priority'      => 60,
    'page_parent'        => 'themes.php',
    'save_defaults'      => true,
    'show_import_export' => true,
    'footer_credit'      => 'Jarco Core Framework Settings',
);

Redux::set_args( $opt_name, $args );

/*
 * ---> СЕКЦИИ НАСТРОЕК
 */

// --- ШАПКА (HEADER) ---
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Шапка', 'jarco-core' ),
    'id'     => 'header',
    'desc'   => esc_html__( 'Логотип и мультиязычные тексты кнопок', 'jarco-core' ),
    'icon'   => 'el el-arrow-up',
    'fields' => array(
        array(
            'id'       => 'header-logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Логотип', 'jarco-core' ),
        ),
        array(
            'id'       => 'header-button_uk',
            'type'     => 'text',
            'title'    => esc_html__( '(UK) Текст кнопки', 'jarco-core' ),
        ),
        array(
            'id'       => 'header-button_ru',
            'type'     => 'text',
            'title'    => esc_html__( '(RU) Текст кнопки', 'jarco-core' ),
        ),
        array(
            'id'       => 'header-button_de',
            'type'     => 'text',
            'title'    => esc_html__( '(DE) Текст кнопки', 'jarco-core' ),
        ),
        array(
            'id'       => 'header-button_en',
            'type'     => 'text',
            'title'    => esc_html__( '(EN) Текст кнопки', 'jarco-core' ),
        ),
    ),
));

// --- БАННЕР (BANNER) ---
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Баннер', 'jarco-core' ),
    'id'     => 'banner',
    'desc'   => esc_html__( 'Адаптивные изображения баннера', 'jarco-core' ),
    'icon'   => 'el el-photo',
    'fields' => array(
        array(
            'id'       => 'banner_desktop',
            'type'     => 'media',
            'title'    => esc_html__( 'Изображение для баннера (десктоп)', 'jarco-core' ),
            'desc'     => esc_html__('Загрузите изображение', 'jarco-core' ),
        ),
        array(
            'id'       => 'banner_tablet',
            'type'     => 'media',
            'title'    => esc_html__( 'Изображение для баннера (планшет)', 'jarco-core' ),
            'desc'     => esc_html__('Загрузите изображение', 'jarco-core' ),
        ),
        array(
            'id'       => 'banner_mobile',
            'type'     => 'media',
            'title'    => esc_html__( 'Изображение для баннера (mobil)', 'jarco-core' ),
            'desc'     => esc_html__('Загрузите изображение', 'jarco-core' ),
        ),
    ),
));

// --- Настройки сайта ---
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Система', 'jarco-core' ),
    'id'     => 'system',
    'desc'   => esc_html__( 'Технические настройки сайта', 'jarco-core' ),
    'icon'   => 'el el-cogs',
    'fields' => array(
        array(
            'id'       => 'disabled_editor_ids',
            'type'     => 'select',
            'multi'    => true,
            'title'    => esc_html__( 'Отключить редактор для страниц', 'jarco-core' ),
            'subtitle' => esc_html__( 'Выберите страницы, на которых будет скрыт стандартный редактор (для лендингов на ACF)', 'jarco-core' ),
            'data'     => 'pages', // Redux сам подтянет список всех страниц сайта
        ),
    ),
));

// --- КОНТАКТЫ ---
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Контакты', 'jarco-core' ),
    'id'     => 'contacts',
    'desc'   => esc_html__( 'Контактная информация и заголовки по языкам', 'jarco-core' ),
    'icon'   => 'el el-address-book',
    'fields' => array(
        // Заголовки
        array('id' => 'contacts-title_uk', 'type' => 'text', 'title' => esc_html__('(UK) Заголовок для блока контактов', 'jarco-core')),
        array('id' => 'contacts-title_ru', 'type' => 'text', 'title' => esc_html__('(RU) Заголовок для блока контактов', 'jarco-core')),
        array('id' => 'contacts-title_de', 'type' => 'text', 'title' => esc_html__('(DE) Заголовок для блока контактов', 'jarco-core')),
        array('id' => 'contacts-title_en', 'type' => 'text', 'title' => esc_html__('(EN) Заголовок для блока контактов', 'jarco-core')),
        
        // Описания
        array('id' => 'contacts-description_uk', 'type' => 'textarea', 'title' => esc_html__('(UK) Описание для блока контактов', 'jarco-core')),
        array('id' => 'contacts-description_ru', 'type' => 'textarea', 'title' => esc_html__('(RU) Описание для блока контактов', 'jarco-core')),
        array('id' => 'contacts-description_de', 'type' => 'textarea', 'title' => esc_html__('(DE) Описание для блока контактов', 'jarco-core')),
        array('id' => 'contacts-description_en', 'type' => 'textarea', 'title' => esc_html__('(EN) Описание для блока контактов', 'jarco-core')),
        
        // Ссылки (единые для всех языков)
        array('id' => 'phone', 'type' => 'text', 'title' => esc_html__('Номер телефона', 'jarco-core')),
        array('id' => 'email', 'type' => 'text', 'title' => esc_html__('Email', 'jarco-core')),
        array('id' => 'social-whatsapp', 'type' => 'text', 'title' => esc_html__('WhatsApp Link', 'jarco-core')),
        array('id' => 'social-facebook', 'type' => 'text', 'title' => esc_html__('Facebook Link', 'jarco-core')),
        array('id' => 'social-instagram', 'type' => 'text', 'title' => esc_html__('Instagram Link', 'jarco-core')),
        
        // График работы
        array('id' => 'schedual_uk', 'type' => 'text', 'title' => esc_html__('(UK) График работы', 'jarco-core')),
        array('id' => 'schedual_ru', 'type' => 'text', 'title' => esc_html__('(RU) График работы', 'jarco-core')),
        array('id' => 'schedual_de', 'type' => 'text', 'title' => esc_html__('(DE) График работы', 'jarco-core')),
        array('id' => 'schedual_en', 'type' => 'text', 'title' => esc_html__('(EN) График работы', 'jarco-core')),
        
        // Адрес сокращенный
        array('id' => 'location_uk', 'type' => 'text', 'title' => esc_html__('(UK) Сокращенный адрес', 'jarco-core')),
        array('id' => 'location_ru', 'type' => 'text', 'title' => esc_html__('(RU) Сокращенный адрес', 'jarco-core')),
        array('id' => 'location_de', 'type' => 'text', 'title' => esc_html__('(DE) Сокращенный адрес', 'jarco-core')),
        array('id' => 'location_en', 'type' => 'text', 'title' => esc_html__('(EN) Сокращенный адрес', 'jarco-core')),
        
        // Адрес расширенный        
        array('id' => 'footer-location_uk', 'type' => 'textarea', 'title' => esc_html__('(UK) Адрес (возможность более расширенных данных, чем в сокращенном адресе)', 'jarco-core')),
		array('id' => 'footer-location_ru', 'type' => 'textarea', 'title' => esc_html__('(RU) Адрес (возможность более расширенных данных, чем в сокращенном адресе)', 'jarco-core')),
		array('id' => 'footer-location_de', 'type' => 'textarea', 'title' => esc_html__('(DE) Адрес (возможность более расширенных данных, чем в сокращенном адресе)', 'jarco-core')),
		array('id' => 'footer-location_en', 'type' => 'textarea', 'title' => esc_html__('(EN) Адрес (возможность более расширенных данных, чем в сокращенном адресе)', 'jarco-core')),
    ),
));

// --- МАГАЗИН / ТОВАРЫ ---
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Магазин', 'jarco-core' ),
    'id'     => 'shop',
    'desc'   => esc_html__( 'Настройки отображения товаров', 'jarco-core' ),
    'icon'   => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id'       => 'parent-product-id_uk',
            'type'     => 'text',
            'title'    => esc_html__( '(UK) ID родительского товара', 'jarco-core' ),
            'subtitle' => esc_html__( 'ID товара, вариации которого пошли в сетку на главной', 'jarco-core' ),
        ),
        array(
            'id'       => 'parent-product-id_ru',
            'type'     => 'text',
            'title'    => esc_html__( '(RU) ID родительского товара', 'jarco-core' ),
        ),
        array(
            'id'       => 'parent-product-id_de',
            'type'     => 'text',
            'title'    => esc_html__( '(DE) ID родительского товара', 'jarco-core' ),
        ),
        array(
            'id'       => 'parent-product-id_en',
            'type'     => 'text',
            'title'    => esc_html__( '(EN) ID родительского товара', 'jarco-core' ),
        ),
    ),
));

// --- ПОДВАЛ (FOOTER) ---
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Подвал', 'jarco-core' ),
    'id'     => 'footer',
    'icon'   => 'el el-arrow-down',
    'fields' => array(
        array('id' => 'footer-logo', 'type' => 'media', 'title' => esc_html__('Логотип подвала', 'jarco-core')),
        // Описание в подвале
        array('id' => 'footer-desk_uk', 'type' => 'text', 'title' => esc_html__('(UK) Описание подвала', 'jarco-core')),
        array('id' => 'footer-desk_ru', 'type' => 'text', 'title' => esc_html__('(RU) Описание подвала', 'jarco-core')),
        array('id' => 'footer-desk_de', 'type' => 'text', 'title' => esc_html__('(DE) Описание подвала', 'jarco-core')),
        array('id' => 'footer-desk_en', 'type' => 'text', 'title' => esc_html__('(EN) Описание подвала', 'jarco-core')),
        // Copyright
        array('id' => 'footer-copyright_uk', 'type' => 'text', 'title' => esc_html__('(UK) Copyright', 'jarco-core')),
        array('id' => 'footer-copyright_ru', 'type' => 'text', 'title' => esc_html__('(RU) Copyright', 'jarco-core')),
        array('id' => 'footer-copyright_de', 'type' => 'text', 'title' => esc_html__('(DE) Copyright', 'jarco-core')),
        array('id' => 'footer-copyright_en', 'type' => 'text', 'title' => esc_html__('(EN) Copyright', 'jarco-core')),
    ),
));