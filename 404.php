<?php
/**
 * Universal 404 Page for Jarco Core
 */
get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found container" style="text-align: center; padding: 100px 0;">
        <header class="page-header">
            <h1 class="page-title" style="font-size: 80px; margin-bottom: 20px;">404</h1>
            <h2 class="footer-menu-title">
                <?php pll_e( 'Помилка 404' ); ?>
            </h2>
        </header>

        <div class="page-content" style="max-width: 600px; margin: 0 auto;">
            <p style="margin-bottom: 30px;">
                <?php pll_e( 'На жаль, таку сторінку не знайдено. Можливо, вона була видалена або переїхала.' ); ?>
            </p>
            
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn">
                <?php pll_e( 'На головну' ); ?>
            </a>
        </div>
    </section>
</main>

<?php
get_footer();