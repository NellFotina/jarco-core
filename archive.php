<?php
/**
 * Страница архивов archive.php
 */
get_header();

$global_options = get_jarco_options();

$banner_data = [
    'banner_desktop' => $global_options['banner_desktop'] ?? [],
    'banner_tablet'  => $global_options['banner_tablet'] ?? [],
    'banner_mobile'  => $global_options['banner_mobile'] ?? [],
];
?>

<main id="primary" class="site-main">
    
    <?php get_template_part('template-parts/content', 'banner', $banner_data);?>
    
    
</main>

<?php get_footer(); ?>