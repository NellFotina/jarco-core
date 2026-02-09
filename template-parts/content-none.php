<?php
/**
 * Шаблон для отображения сообщения о том, что контент не найден
 * Универсальная версия для Jarco Core
 */

defined('ABSPATH') || exit;
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">
            <?php pll_e('Нічого не знайдено'); ?>
        </h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
                <?php 
                printf(
                    pll__('Готові опублікувати свій перший пост? <a href="%1$s">Почніть тут</a>.'),
                    esc_url( admin_url( 'post-new.php' ) )
                ); 
                ?>
            </p>

		<?php elseif ( is_search() ) : ?>

			<p><?php pll_e('Вибачте, але за вашим запитом нічого не знайдено. Спробуйте ще раз з іншими ключовими словами.'); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php pll_e('Здається, ми не можемо знайти те, що ви шукаєте. Можливо, пошук допоможе.'); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>