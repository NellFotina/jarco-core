<?php
/**
 * Шаблон одиночной записи типа 'product'
 */

get_header();
the_post();

global $product;
if ( ! is_a( $product, 'WC_Product' ) ) {
    $product = wc_get_product( get_the_ID() );
}

// Вводные данные для блока intro
$intro_data = [
    'intro_text' => $post->post_excerpt
];

// Глобальные опции темы
$global_options = get_jarco_options();

// Баннеры
$banner_data = [
    'banner_desktop' => jarco_get_lang_opt('banner_desktop'),
    'banner_tablet'  => jarco_get_lang_opt('banner_tablet'),
    'banner_mobile'  => jarco_get_lang_opt('banner_mobile'),
];
?>

<main id="primary" class="site-main">
    <?php get_template_part( 'template-parts/content', 'banner', $banner_data ); ?>
    <?php get_template_part( 'template-parts/content', 'intro', $intro_data ); ?>

    <section class="products-list">
        <div class="container">
            <div class="products-container">
                <?php
                // --- Определяем родительский товар ---
                $parent_product = $product;

                // Если открыта вариация, получаем её родителя
                if ( $product->is_type( 'variation' ) ) {
                    $parent_id = $product->get_parent_id();
                    if ( $parent_id ) {
                        $parent_product = wc_get_product( $parent_id );
                    }
                }

                // Проверяем, есть ли родительский variable товар
                if ( $parent_product && $parent_product->is_type( 'variable' ) ) {

                    // Получаем все вариации
                    $variation_ids = $parent_product->get_children();

                    if ( ! empty( $variation_ids ) ) {
                        foreach ( $variation_ids as $variation_id ) {
                            $variation = wc_get_product( $variation_id );
                            if ( ! $variation ) continue;

                            // Устанавливаем переменные для шаблона
                            set_query_var( 'variation', $variation );
                            set_query_var( 'parent_product', $parent_product );
                            
                            // Загружаем шаблон
                            get_template_part( 'template-parts/content', 'product-item' );
                        }
                    } else {
                        echo '<p>' . esc_html__('Variations not found', 'jarco-core') . '</p>';
                    }
                } else {
                    echo '<p>' . esc_html__('Variations not found', 'jarco-core') . '</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <section class="products-text mb-60">
        <?php 
        // --- SEO-заголовок из Yoast ---
        if ( defined( 'WPSEO_VERSION' ) ) {
            $seo_title = get_post_meta( get_the_ID(), '_yoast_wpseo_title', true );
            if ( $seo_title ) {
                echo '<h2 class="title">' . esc_html( $seo_title ) . '</h2>';
            }
        }
        ?>      

        <div class="intro-row">            
            <div class="intro-content">
                <?php
                // Основное описание
                $extra_text = $post->post_content;
                if ( $extra_text ) {
                    echo wp_kses_post( $extra_text );
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>