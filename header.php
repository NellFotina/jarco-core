<?php
/**
 * Header - шапка темы Jarco Core
 */
defined( 'ABSPATH' ) || exit;

$global_options = get_jarco_options();

$banner_mobile  = $global_options['banner_mobile'] ?? [];
$banner_tablet  = $global_options['banner_tablet'] ?? [];
$banner_desktop = $global_options['banner_desktop'] ?? [];

// Получаем текущий язык из Redux
$schedual      = jarco_get_lang_opt('schedual');
$location      = jarco_get_lang_opt('location');
$header_button = jarco_get_lang_opt('header-button');
?>


<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if (!empty($banner_mobile['url'])): ?>
		<link rel="preload" href="<?php echo esc_url($banner_mobile['url']); ?>" as="image" fetchpriority="high" media="(max-width: 575px)">
	<?php endif; ?>
	<?php if (!empty($banner_tablet['url'])): ?>
		<link rel="preload" href="<?php echo esc_url($banner_tablet['url']); ?>" as="image" fetchpriority="high" media="(min-width: 576px) and (max-width: 1024px)">
	<?php endif; ?>
	<?php if (!empty($banner_desktop['url'])): ?>
		<link rel="preload" href="<?php echo esc_url($banner_desktop['url']); ?>" as="image" fetchpriority="high" media="(min-width: 1025px)">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	
	<header class="header">
		<div class="header-desktop">
			<div class="header-left">
				<div class="header-logo">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="flex-center">
						<?php if (!empty($global_options['header-logo']['url'])): ?>
							<img src="<?php echo esc_url($global_options['header-logo']['url']); ?>" alt="<?php bloginfo('name'); ?>">
						<?php else: ?>
							<img src="<?php echo get_template_directory_uri();?>/assets/images/header-logo.svg" alt="<?php bloginfo('name'); ?>">
						<?php endif; ?>
					</a>
				</div>
			</div>
			<div class="header-right">
				<div class="header-top">
					<div class="container">
						<div class="header-top-row">
							<div class="header-info">
								<?php if(!empty($schedual)):?>
									<div class="header-info-item">
										<span class="header-info-icon">
											<img src="<?php echo get_template_directory_uri();?>/assets/images/info-clock.svg" alt="<?php echo pll__('Графік роботи'); ?>">
										</span>
										<span class="header-info-text">
											<?php echo esc_html($schedual);?>
										</span>
									</div>
								<?php endif;?>
								<?php if(!empty($global_options['phone'])):?>
									<a href="tel:<?php echo esc_attr($global_options['phone']);?>" class="header-info-item header-phone">
										<span class="header-info-icon">
											<img src="<?php echo get_template_directory_uri();?>/assets/images/info-phone.svg" alt="<?php echo pll__('Телефон'); ?>">
										</span>
										<span class="header-info-text">
											<?php echo esc_html($global_options['phone']);?>
										</span>
									</a>
								<?php endif;?>
								<?php if(!empty($location)):?>
									<div class="header-info-item">
										<span class="header-info-icon">
											<img src="<?php echo get_template_directory_uri();?>/assets/images/info-location.svg" alt="<?php echo pll__('Адреса'); ?>">
										</span>
										<span class="header-info-text">
											<?php echo esc_html($location);?>
										</span>
									</div>
								<?php endif;?>
								<?php if(!empty($global_options['email'])):?>
									<div class="header-info-item">
										<span class="header-info-icon">
											<img src="<?php echo get_template_directory_uri();?>/assets/images/info-envelope.svg" alt="Email">
										</span>
										<span class="header-info-text">
											<?php echo esc_html($global_options['email']);?>
										</span>
									</div>
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
				<div class="header-bottom">
					<div class="container">
						<div class="header-bottom-row">
							<div class="header-social">
								<?php if(!empty($global_options['social-whatsapp'])):?>
									<a href="<?php echo esc_url($global_options['social-whatsapp']);?>" target="_blank" rel="noopener">
										<img src="<?php echo get_template_directory_uri();?>/assets/images/social-whatsapp.svg" alt="Whatsapp">
									</a>
								<?php endif;?>
								<?php if(!empty($global_options['social-facebook'])):?>
									<a href="<?php echo esc_url($global_options['social-facebook']);?>" target="_blank" rel="noopener">
										<img src="<?php echo get_template_directory_uri();?>/assets/images/social-facebook.svg" alt="Facebook">
									</a>
								<?php endif;?>
								<?php if(!empty($global_options['social-instagram'])):?>
									<a href="<?php echo esc_url($global_options['social-instagram']);?>" target="_blank" rel="noopener">
										<img src="<?php echo get_template_directory_uri();?>/assets/images/social-instagram.svg" alt="Instagram">
									</a>
								<?php endif;?>
							</div>
							
							<nav class="menu-nav">
								<?php
									wp_nav_menu(
										array(
											'theme_location'  => 'menu-header',
											'menu_id'         => 'menu-header',
											'container'       => 'ul',
										)
									);
								?>
							</nav>
							
							<?php if(!empty($header_button)):?>
							<div class="header-btn">
								<a href="<?php echo esc_url(home_url('/#contacts')); ?>">
									<?php echo esc_html($header_button);?>
								</a>
							</div>
							<?php endif; ?>
							
							<div class="hamburger">
								<img src="<?php echo get_template_directory_uri();?>/assets/images/hamburger.svg" alt="<?php echo pll__('Меню'); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header mobile START -->
		<div class="header-mobile">
			<div class="header-mobile-head">
				<div class="header-mobile-logo">
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php if (!empty($global_options['header-logo']['url'])): ?>
							<img src="<?php echo esc_url($global_options['header-logo']['url']); ?>" alt="<?php bloginfo('name'); ?>">
						<?php else: ?>
							<img src="<?php echo get_template_directory_uri();?>/assets/images/header-logo.svg" alt="<?php bloginfo('name'); ?>">
						<?php endif; ?>
					</a>
				</div>
				<div class="header-mobile-close">
					<img src="<?php echo get_template_directory_uri();?>/assets/images/x.svg" alt="<?php echo pll__('Закрыть'); ?>">
				</div>
			</div>

			<div class="header-mobile-top">
				<div class="header-mobile-social">
					<?php if(!empty($global_options['social-whatsapp'])):?>
						<a href="<?php echo esc_url($global_options['social-whatsapp']);?>" target="_blank" rel="noopener">
							<img src="<?php echo get_template_directory_uri();?>/assets/images/social-whatsapp.svg" alt="Whatsapp">
						</a>
					<?php endif;?>
					<?php if(!empty($global_options['social-facebook'])):?>
						<a href="<?php echo esc_url($global_options['social-facebook']);?>" target="_blank" rel="noopener">
							<img src="<?php echo get_template_directory_uri();?>/assets/images/social-facebook.svg" alt="Facebook">
						</a>
					<?php endif;?>
					<?php if(!empty($global_options['social-instagram'])):?>
						<a href="<?php echo esc_url($global_options['social-instagram']);?>" target="_blank" rel="noopener">
							<img src="<?php echo get_template_directory_uri();?>/assets/images/social-instagram.svg" alt="Instagram">
						</a>
					<?php endif;?>
				</div>

				<div class="header-mobile-info">
					<?php if(!empty($schedual)):?>
						<div class="header-info-item">
							<span class="header-info-icon">
								<img src="<?php echo get_template_directory_uri();?>/assets/images/info-clock.svg" alt="<?php echo pll__('Графік роботи'); ?>">
							</span>
							<span class="header-info-text">
								<?php echo esc_html($schedual);?>
							</span>
						</div>
					<?php endif;?>
					<?php if(!empty($global_options['phone'])):?>
						<a href="tel:<?php echo esc_attr($global_options['phone']);?>" class="header-info-item">
							<span class="header-info-icon">
								<img src="<?php echo get_template_directory_uri();?>/assets/images/info-phone.svg" alt="<?php echo pll__('Телефон'); ?>">
							</span>
							<span class="header-info-text">
								<?php echo esc_html($global_options['phone']);?>
							</span>
						</a>
					<?php endif;?>
					<?php if(!empty($location)):?>
						<div class="header-info-item">
							<span class="header-info-icon">
								<img src="<?php echo get_template_directory_uri();?>/assets/images/info-location.svg" alt="<?php echo pll__('Адреса'); ?>">
							</span>
							<span class="header-info-text">
								<?php echo esc_html($location);?>
							</span>
						</div>
					<?php endif;?>
					<?php if(!empty($global_options['email'])):?>
						<div class="header-info-item">
							<span class="header-info-icon">
								<img src="<?php echo get_template_directory_uri();?>/assets/images/info-envelope.svg" alt="Email">
							</span>
							<span class="header-info-text">
								<?php echo esc_html($global_options['email']);?>
							</span>
						</div>
					<?php endif;?>
				</div>
			</div>

			<nav class="menu-mobile-nav">
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'menu-header',
							'menu_id'         => 'menu-header',
							'container'       => 'ul',
						)
					);
				?>
			</nav>
			
			<?php if(!empty($header_button)):?>
			<div class="header-mobile-btn">
				<a href="<?php echo esc_url(home_url('/#contacts')); ?>">
					<?php echo esc_html($header_button);?>
				</a>
			</div>
			<?php endif; ?>
		</div>
		<!-- Header mobile END -->
	</header>