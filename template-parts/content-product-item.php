<?php
/**
 * Шаблон карточки вариации товара (Универсальный)
 */

$variation = get_query_var('variation');
$parent_product = get_query_var('parent_product');
$term_name = get_query_var('term_name', '');

if (!isset($variation) || !$variation instanceof WC_Product_Variation) {
    return;
}

$variation_id = $variation->get_id();
$variation_link = esc_url($variation->get_permalink()) . '#variation-' . $variation_id;
$image_id = $variation->get_image_id();

// Собираем мета-данные
$ingredients = get_post_meta($variation_id, '_variation_ingredients', true);
$energy_kj   = get_post_meta($variation_id, '_variation_energy_kj', true);
$energy_kcal = get_post_meta($variation_id, '_variation_energy_kcal', true);
$fats_total  = get_post_meta($variation_id, '_variation_fats_total', true);
$fats_sat    = get_post_meta($variation_id, '_variation_fats_saturated', true);
$fats_mono   = get_post_meta($variation_id, '_variation_fats_mono', true);
$fats_poly   = get_post_meta($variation_id, '_variation_fats_poly', true);
$carbs_total = get_post_meta($variation_id, '_variation_carbs_total', true);
$carbs_sugar = get_post_meta($variation_id, '_variation_carbs_sugars', true);
$proteins    = get_post_meta($variation_id, '_variation_proteins', true);
$salt        = get_post_meta($variation_id, '_variation_salt', true);
$fiber       = get_post_meta($variation_id, '_variation_fiber', true);
$extra       = get_post_meta($variation_id, '_variation_extra', true);

// Проверка: нужно ли вообще выводить таблицу БЖУ?
$has_nutrition = ($energy_kj || $energy_kcal || $fats_total || $carbs_total || $proteins || $salt || $fiber);
?>

<div class="product-item" id="variation-<?php echo $variation_id; ?>">
    <div class="product-left">
        <?php
        if ($image_id) {
            $image_html = wp_get_attachment_image($image_id, 'medium');
        } elseif (isset($parent_product) && $parent_product) {
            $image_html = wp_get_attachment_image($parent_product->get_image_id(), 'medium');
        } else {
            $image_html = '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="' . esc_attr($variation->get_name()) . '">';
        }
        echo '<a href="' . $variation_link . '">' . $image_html . '</a>';
        ?>
    </div>

    <div class="product-right">
        <h3>
            <a href="<?php echo $variation_link; ?>">
                <?php 
                // Вместо "Баба Шура" берем название сайта из настроек
                echo esc_html(get_bloginfo('name')); 
                ?>

                <?php
                $lineika = !empty($term_name) ? $term_name : $variation->get_attribute('pa_lineika');
                if ($lineika) echo ' ' . esc_html($lineika) . ' — ';

                $description = get_post_meta($variation_id, '_variation_description', true);
                echo esc_html($description ?: $variation->get_name());
                ?>
            </a>
        </h3>

        <div class="product-meta">
            <?php if ($ingredients) : ?>
                <p><strong><?php pll_e('Склад'); ?>:</strong> <?php echo esc_html($ingredients); ?></p>
            <?php endif; ?>

            <?php if ($has_nutrition) : ?>
                <table class="nutrition-table">
                    <?php if ($energy_kj || $energy_kcal) : ?>
                        <tr>
                            <td><strong><?php pll_e('Енергетична цінність'); ?>:</strong></td>
                            <td>
                                <?php 
                                if ($energy_kj) echo esc_html($energy_kj) . ' ' . pll__('кДж');
                                if ($energy_kj && $energy_kcal) echo ' / ';
                                if ($energy_kcal) echo esc_html($energy_kcal) . ' ' . pll__('ккал');
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($fats_total) : ?>
                        <tr><td><strong><?php pll_e('Жири'); ?></strong></td><td><?php echo esc_html($fats_total) . ' ' . pll__('г'); ?></td></tr>
                        <?php if ($fats_sat || $fats_mono || $fats_poly) : ?>
                            <tr><td class="subcategory"><?php pll_e('з них'); ?></td><td></td></tr>
                            <?php if ($fats_sat) : ?><tr><td class="subcategory-item"><?php pll_e('насичені'); ?></td><td><?php echo esc_html($fats_sat) . ' ' . pll__('г'); ?></td></tr><?php endif; ?>
                            <?php if ($fats_mono) : ?><tr><td class="subcategory-item"><?php pll_e('мононенасичені'); ?></td><td><?php echo esc_html($fats_mono) . ' ' . pll__('г'); ?></td></tr><?php endif; ?>
                            <?php if ($fats_poly) : ?><tr><td class="subcategory-item"><?php pll_e('поліненасичені'); ?></td><td><?php echo esc_html($fats_poly) . ' ' . pll__('г'); ?></td></tr><?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($carbs_total) : ?>
                        <tr><td><strong><?php pll_e('Вуглеводи'); ?></strong></td><td><?php echo esc_html($carbs_total) . ' ' . pll__('г'); ?></td></tr>
                        <?php if ($carbs_sugar) : ?>
                            <tr><td class="subcategory"><?php pll_e('з них'); ?></td><td></td></tr>
                            <tr><td class="subcategory-item"><?php pll_e('цукри'); ?></td><td><?php echo esc_html($carbs_sugar) . ' ' . pll__('г'); ?></td></tr>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($proteins) : ?>
                        <tr><td><strong><?php pll_e('Білки'); ?></strong></td><td><?php echo esc_html($proteins) . ' ' . pll__('г'); ?></td></tr>
                    <?php endif; ?>

                    <?php if ($salt) : ?>
                        <tr><td><strong><?php pll_e('Сіль'); ?></strong></td><td><?php echo esc_html($salt) . ' ' . pll__('г'); ?></td></tr>
                    <?php endif; ?>

                    <?php if ($fiber) : ?>
                        <tr><td><strong><?php pll_e('Клітковина'); ?></strong></td><td><?php echo esc_html($fiber) . ' ' . pll__('г'); ?></td></tr>
                    <?php endif; ?>
                </table>
            <?php endif; ?>

            <?php if ($extra) : ?>
                <p class="product-extra"><?php echo esc_html($extra); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>