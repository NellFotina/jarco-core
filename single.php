<?php
/**
 * The template for displaying all single posts
 * @package Jarco_Core
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-30">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    
                    <div class="entry-meta text-muted">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                        <span class="cat-links"><?php the_category( ', ' ); ?></span>
                    </div>
                </header>

                <div class="entry-content">
                    <?php
                    if ( has_post_thumbnail() ) {
                        echo '<div class="post-thumbnail mb-30">';
                        the_post_thumbnail( 'large' );
                        echo '</div>';
                    }
                    
                    the_content();
                    
                    // Для разбивки длинных постов на страницы
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jarco-core' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

                <footer class="entry-footer mt-40">
                    <?php the_tags( '<span class="tags-links">' . esc_html__( 'Tags: ', 'jarco-core' ) . '</span>', ', ' ); ?>
                </footer>
            </article>

            <?php
            // Если захотите добавить навигацию между постами
            the_post_navigation( array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'jarco-core' ) . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'jarco-core' ) . '</span> <span class="nav-title">%title</span>',
            ) );

        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();