<?php
/**
 * Автоматическое обновление темы с GitHub
 */

// Проверяем наличие основного файла библиотеки
$puc_path = get_template_directory() . '/inc/plugin-update-checker/plugin-update-checker.php';

if ( file_exists( $puc_path ) ) {
    require_once $puc_path;
} else {
    return; // Если папка не загружена, просто выходим, чтобы не вешать сайт
}

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// Инициализация загрузчика обновлений
$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/NellFotina/jarco-core/',
    get_template_directory() . '/style.css', // Для тем лучше указывать путь к style.css
    'jarco-core'
);

// Указываем ветку
$updateChecker->setBranch('main');