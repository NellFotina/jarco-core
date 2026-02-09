<?php
/**
 * Общие переводы для Polylang
 */

defined( 'ABSPATH' ) || exit;

function jarco_core_polylang_general_strings() {
    if (!function_exists('pll_register_string')) return;

    // Строки главной страницы
    pll_register_string('jarco_core_no_variations', 'Варіації не знайдені', 'Home Page', false);
    // Для 404.php
    pll_register_string('jarco_core_404_title', 'Помилка 404', '404 Page', false);
    pll_register_string('jarco_core_404_text', 'На жаль, таку сторінку не знайдено. Можливо, вона була видалена або переїхала.', '404 Page', false);
    pll_register_string('jarco_core_404_button', 'На головну', '404 Page', false);
    // Для search.php
    pll_register_string('jarco_core_search_results', 'Результати пошуку для: %s', 'Search Page', false);
    // Для content-none.php (Заглушки)
    pll_register_string('jarco_core_none_title', 'Нічого не знайдено', 'Not Found', false);
    pll_register_string('jarco_core_none_search', 'Вибачте, але за вашим запитом нічого не знайдено. Спробуйте ще раз з іншими ключовими словами.', 'Not Found', false);
    pll_register_string('jarco_core_none_generic', 'Здається, ми не можемо знайти те, що ви шукаєте. Можливо, пошук допоможе.', 'Not Found', false);
    pll_register_string('jarco_core_none_first_post', 'Готові опублікувати свій перший пост? <a href="%1$s">Почніть тут</a>.', 'Not Found', false);
    // Контактная информация и Меню
    pll_register_string('jarco_core_phone_alt', 'Телефон', 'Contacts', false);
    pll_register_string('jarco_core_address_alt', 'Адреса', 'Contacts', false);
    pll_register_string('jarco_core_grafik', 'Графік роботи', 'Contacts', false);
    pll_register_string('jarco_core_menu', 'Меню', 'Contacts', false);
    pll_register_string('jarco_core_close', 'Закрыть', 'Contacts', false);
    pll_register_string('jarco_core_navigation', 'Навігація', 'Contacts', false);
    pll_register_string('jarco_core_contacts', 'Контакти', 'Contacts', false);
    // Для single-product.php
    pll_register_string('jarco_core_composition', 'Склад', 'Single Product', false);
    pll_register_string('jarco_core_kJ', 'кДж', 'Single Product', false);
    pll_register_string('jarco_core_kcal', 'ккал', 'Single Product', false);
    pll_register_string('jarco_core_g', 'г', 'Single Product', false);
    pll_register_string('jarco_core_of_which', 'з них', 'Single Product', false);
    pll_register_string('jarco_core_energy', 'Енергетична цінність', 'Single Product', false);
    pll_register_string('jarco_core_saturated', 'насичені', 'Single Product', false);
    pll_register_string('jarco_core_monounsaturated', 'мононенасичені', 'Single Product', false);
    pll_register_string('jarco_core_polyunsaturated', 'поліненасичені', 'Single Product', false);
    pll_register_string('jarco_core_sugars', 'цукри', 'Single Product', false);
    pll_register_string('jarco_core_fats', 'Жири', 'Single Product', false);
    pll_register_string('jarco_core_carbs', 'Вуглеводи', 'Single Product', false);
    pll_register_string('jarco_core_proteins', 'Білки', 'Single Product', false);
    pll_register_string('jarco_core_salt', 'Сіль', 'Single Product', false);
    pll_register_string('jarco_core_fiber', 'Клітковина', 'Single Product', false);
}
add_action('init', 'jarco_core_polylang_general_strings');