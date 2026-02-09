<?php
/**
 * The template for displaying all pages
 * Template name: Главная
 */
defined( 'ABSPATH' ) || exit;

get_header();

$global_options = get_jarco_options();

$banner_data = [
    'banner_desktop' => $global_options['banner_desktop'] ?? [],
    'banner_tablet'  => $global_options['banner_tablet'] ?? [],
    'banner_mobile'  => $global_options['banner_mobile'] ?? [],
];

$intro_data = [
    'intro_text' => rwmb_meta('_home_intro_text'),
];

// Получаем ID из Redux через универсальную функцию
$parent_id = jarco_get_lang_opt('parent-product-id');

// Если ID не задан в админке, можно поставить какой-то дефолтный (необязательно)
if (empty($parent_id)) {
    $parent_id = 0; 
}

$contacts_title       = jarco_get_lang_opt('contacts-title');
$contacts_description = jarco_get_lang_opt('contacts-description');
$footer_location      = jarco_get_lang_opt('footer-location');
?>

<main id="primary" class="site-main">
    <?php get_template_part('template-parts/content', 'banner', $banner_data); ?>
    <?php get_template_part('template-parts/content', 'intro', $intro_data); ?>

    <section class="all-products-grid">
        <div id="gallery" class="products-wrapper">
            <?php
            // Получаем вариации для текущего языка
            $args = array(
                'post_parent' => $parent_id, // ID вариативного товара для текущего языка
                'post_type'   => 'product_variation',
                'orderby'     => 'menu_order',
                'order'       => 'ASC',
                'post_status' => 'publish',
                'numberposts' => -1
            );
            $variation_posts = get_posts($args);
            
            if ($variation_posts) {
                foreach ($variation_posts as $variation_post) {
                    $variation_id = $variation_post->ID;
                    $variation = wc_get_product($variation_id);
                    
                    if (!$variation) {
                        continue;
                    }
                    
                    // Получаем изображение вариации
                    $image_id = $variation->get_image_id();
                    $image_html = $image_id ? wp_get_attachment_image($image_id, 'medium') : '';
                    
                    // Если у вариации нет изображения, используем изображение родительского товара
                    if (!$image_html) {
                        $parent_product = wc_get_product($parent_id);
                        $image_id = $parent_product->get_image_id();
                        $image_html = $image_id ? wp_get_attachment_image($image_id, 'medium') : '';
                    }
                    
                    // Получаем атрибут "Линейка"
                    $lineika = $variation->get_attribute('pa_lineika');
                    
                    // Получаем описание из метаполя вариации
                    $description = get_post_meta($variation_id, '_variation_description', true);
                    ?>
                    <div class="product-item-main">
                        <a href="<?php echo esc_url($variation->get_permalink()) . '#variation-' . $variation_id; ?>">
                            <div class="product-thumb">
                                <?php echo $image_html; ?>
                            </div>
                            <h3 class="product-title">
                                <?php bloginfo('name'); ?>
                                <?php 
                                if ($lineika) {
                                    echo esc_html($lineika) . ' - ';
                                }
                                
                                if ($description) {
                                    echo esc_html($description);
                                } else {
                                    echo esc_html($variation->get_name());
                                }
                                ?>
                            </h3>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo '<p>' . pll__('Варіації не знайдені') . '</p>';
            }
            ?>
        </div>
    </section>

    <!-- Контактный блок -->
    <section class="contacts-section">
        <div id="contacts" class="contacts-wrapper">
            <h2 class="title"><?php echo $contacts_title; ?></h2>
            <p class="contacts-description">
                <?php echo $contacts_description; ?>
            </p>
            
            <div class="contacts-info">
                <?php if($global_options['phone']):?>
                    <div class="contact-item">
                        <a href="tel:<?php echo $global_options['phone'];?>">                            
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/info-phone.svg" alt="<?php echo pll__('Телефон'); ?>">
                            <h3><?php echo pll__('Телефон'); ?></h3>                            
                            <?php echo $global_options['phone'];?>                            
                        </a>          
                    </div>
                <?php endif;?>                
                
                <div class="contact-item">                 
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/info-location.svg" alt="<?php echo pll__('Адреса'); ?>">
                    <h3><?php echo pll__('Адреса'); ?></h3>
                    <span class="header-info-text">
                        <?php echo wp_kses_post( nl2br($footer_location) );?>
                    </span>
                </div>                

                <?php if($global_options['email']):?>
                    <div class="contact-item">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/info-envelope.svg" alt="<?php echo pll__('E-Mail'); ?>">
                        <h3>E-Mail</h3>
                        <span class="header-info-text">
                            <?php echo $global_options['email'];?>
                        </span> 
                    </div>
                <?php endif;?>
                
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>