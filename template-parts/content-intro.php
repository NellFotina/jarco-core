<?php 
/**
 * Блок под баннером (Заголовок + Текст)
 * Универсальная версия для Jarco Core
 * * @param array $args {
 * @type string $intro_text - основной текст блока
 * }
 */

$intro_text = $args['intro_text'] ?? '';

// Формируем заголовок
$title_output = '';

if (is_page() || is_singular()) {
    $title_output = get_the_title();
} elseif (is_tax()) {
    // Для таксономий (линейки продуктов и т.д.)
    $term = get_queried_object();
    // Берем название сайта + название категории/атрибута
    $title_output = get_bloginfo('name') . ' ' . $term->name;
} else {
    // Для архивов (удаляем системные приставки вроде "Category: ")
    $title_output = get_the_archive_title();
    $title_output = wp_strip_all_tags($title_output);
    $title_output = preg_replace('/^[^:]+:\s*/', '', $title_output);
}

// Если нет ни текста, ни заголовка — ничего не выводим
if (empty($title_output) && empty($intro_text)) {
    return;
}

$is_front_page = is_front_page();
?>

<section class="intro-wrap" <?php echo $is_front_page ? 'id="about"' : ''; ?>>
    
    <?php if (!empty($title_output)) : ?>
        <h2 class="title"><?php echo esc_html($title_output); ?></h2>
    <?php endif; ?>

    <?php if (!empty($intro_text)) : ?>
        <div class="intro-row">
            <div class="intro-content">
                <?php echo wpautop(wp_kses_post($intro_text)); ?>
            </div>
        </div>
    <?php endif; ?>

</section>