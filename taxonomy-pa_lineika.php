<?php
/**
 * Шаблон таксономии типа 'pa_lineika' (Линейки товаров)
 * @package Jarco_Core
 */

if (!defined('ABSPATH')) exit;

get_header();

$term = get_queried_object();
$term_id = $term->term_id;
$term_slug = $term->slug;
$term_name = $term->name;

// 1. Подготовка данных для баннера (через универсальную функцию)
$banner_data = [
    'banner_desktop' => jarco_get_lang_opt('banner_desktop'),
    'banner_tablet'  => jarco_get_lang_opt('banner_tablet'),
    'banner_mobile'  => jarco_get_lang_opt('banner_mobile'),
];

// 2. Данные для интро (описание категории)
$intro_data = [
    'intro_text' => term_description($term_id, 'pa_lineika') ?: ''
];
?>

<main id="primary" class="site-main">
    
    <?php get_template_part('template-parts/content', 'banner', $banner_data); ?>
    <?php get_template_part('template-parts/content', 'intro', $intro_data); ?>
    
    <section class="products-list">
        <div class="container">
            <div class="products-container">
                <?php
                $args = array(
                    'post_type'   => 'product',
                    'post_status' => 'publish',
                    'tax_query'   => array(
                        array(
                            'taxonomy' => 'pa_lineika',
                            'field'    => 'slug',
                            'terms'    => $term_slug,
                        )
                    ),
                    'numberposts' => -1
                );
                
                $products = get_posts($args);
                $found_variations = false;
                
                if ($products) :
                    foreach ($products as $product_post) :
                        $parent_product = wc_get_product($product_post->ID);
                        
                        if ($parent_product && $parent_product->is_type('variable')) :
                            $variation_ids = $parent_product->get_children();
                            
                            if (!empty($variation_ids)) :
                                foreach ($variation_ids as $variation_id) :
                                    $variation = wc_get_product($variation_id);
                                    
                                    if ($variation && $variation->is_type('variation')) :
                                        $variation_lineika = $variation->get_attribute('pa_lineika');
                                        
                                        if ($variation_lineika === $term_name) :
                                            $found_variations = true;
                                            
                                            set_query_var('variation', $variation);
                                            set_query_var('parent_product', $parent_product);
                                            set_query_var('term_name', $term_name);
                                            
                                            get_template_part('template-parts/content', 'product-item');
                                            
                                        endif; 
                                    endif; 
                                endforeach;
                            endif; 
                        endif; 
                    endforeach;
                    
                    if (!$found_variations) :
                        echo '<p>' . esc_html__('Variations not found', 'jarco-core') . ': ' . esc_html($term_name) . '</p>';
                    endif;
                    
                    wp_reset_postdata();
                else :
                    echo '<p>' . esc_html__('Products in this line not found', 'jarco-core') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </section>

    <section class="products-text mb-60">
        <div class="container"> <?php
                $custom_h2 = get_term_meta($term_id, 'pa_lineika_custom_h2', true);
                if ($custom_h2) {
                    echo '<h2 class="title">' . esc_html($custom_h2) . '</h2>';
                }
            ?>
            <div class="intro-row">
                <div class="intro-content">
                    <?php 
                        $extra_text = get_term_meta($term_id, 'pa_lineika_extra_text', true); 
                        if ($extra_text) {
                            echo wp_kses_post($extra_text);
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>