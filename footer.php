<?php
/**
 * Footer - подвал темы Jarco Core
 * @package Jarco_Core
 */
defined( 'ABSPATH' ) || exit;

$global_options = get_jarco_options();

// Получаем текущий язык из Redux
$footer_desk      = jarco_get_lang_opt('footer-desk');
$footer_location  = jarco_get_lang_opt('footer-location');
$footer_copyright = jarco_get_lang_opt('footer-copyright');
?>

	<footer class="footer">
		<div class="container">
			<div class="footer-row">
				<div class="footer-left">
					<div class="footer-1">
                        <?php if(!empty($global_options['footer-logo']['url'])):?>
                            <div class="footer-logo">
                                <a href="<?php echo home_url();?>">
                                    <img src="<?php echo $global_options['footer-logo']['url'];?>" alt="<?php bloginfo('name'); ?>">
                                </a>
                            </div>
                        <?php endif; ?>
                    
                        <?php if($footer_desk):?>
                            <div class="footer-desc">
                                <p><?php echo $footer_desk;?></p>
                            </div>
                        <?php endif; ?>   
                    
                        <div class="footer-social">
                            <?php if(!empty($global_options['social-whatsapp'])):?>
                                <a href="<?php echo $global_options['social-whatsapp'];?>" target="_blank">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/social-whatsapp.svg" alt="Whatsapp">
                                </a>
                            <?php endif; ?>
                    
                            <?php if(!empty($global_options['social-facebook'])):?>	
                                <a href="<?php echo $global_options['social-facebook'];?>" target="_blank">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/social-facebook.svg" alt="Facebook">
                                </a>
                            <?php endif; ?>
                    
                            <?php if(!empty($global_options['social-instagram'])):?>
                                <a href="<?php echo $global_options['social-instagram'];?>" target="_blank">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/social-instagram.svg" alt="Instagram">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

					<div class="footer-1">
						<nav class="footer-menu-nav">
							<h4 class="footer-menu-title"><?php echo pll__('Навігація'); ?></h4>
							<?php
								wp_nav_menu(
									array(
										'theme_location'  => 'menu-footer1',
										'menu_id'         => 'menu-footer1',
										'container'       => 'ul',
										)
									);
							?>
						</nav>
					</div>
				</div>

				<div class="footer-right">					
					<nav class="footer-menu-nav">
						<h4 class="footer-menu-title"><?php bloginfo('name'); ?></h4>
						<?php
					        wp_nav_menu(
					            array(
		                            'theme_location'  => 'menu-footer2',
		                            'menu_id'         => 'menu-footer2',
		                            'container'       => 'ul',
		                            )
					            );
					    ?>
					</nav>
                    <div class="footer-menu-nav">
                        <h4 class="footer-menu-title"><?php echo pll__('Контакти'); ?></h4>
                        <div class="footer-contacts-info">
                            
                            <?php // Проверка телефона ?>
                            <?php if(!empty($global_options['phone'])): ?>
                                <a href="tel:<?php echo $global_options['phone'];?>" class="footer-contacts-item">
                                    <span class="footer-contacts-icon">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/info-phone.svg" alt="<?php echo pll__('Телефон'); ?>">
                                    </span>
                                    <span class="footer-contacts-phone"><?php echo $global_options['phone'];?></span>
                                </a>
                            <?php endif;?>
                    
                            <?php // Проверка локации ?>
                            <?php if(!empty($footer_location)): ?>
                                <div class="footer-contacts-item">
                                    <span class="footer-contacts-icon">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/info-location.svg" alt="<?php echo pll__('Адреса'); ?>">
                                    </span>
                                    <span class="footer-contacts-phone">
                                        <?php echo $footer_location;?>
                                    </span>
                                </div>
                            <?php endif;?>
                    
                            <?php // Проверка email ?>
                            <?php if(!empty($global_options['email'])): ?>
                                <div class="footer-contacts-item">
                                    <span class="footer-contacts-icon">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/info-envelope.svg" alt="Email">
                                    </span>
                                    <span class="footer-contacts-phone">
                                        <?php echo $global_options['email'];?>
                                    </span>
                                </div>
                            <?php endif;?>
                            
                        </div>
                    </div>
				</div>
			</div>

			<div class="footer-copyright">
				<?php if(!empty($footer_copyright)):?>
					<p><?php echo $footer_copyright;?></p>
				<?php endif;?>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>