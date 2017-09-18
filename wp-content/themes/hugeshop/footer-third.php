<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage hugeshop_Themes
 * @since Huge Shop 1.0
 */
?>
<?php global $hugeshop_opt; ?>

	<div class="footer layout6">
		<?php if(isset($hugeshop_opt)) { ?>
		<div class="footer-top">	
			<div class="container">
					<?php if(isset($hugeshop_opt['corporate_about']) && $hugeshop_opt['corporate_about']!=''){ ?>
						<div class="widget widget_corporate_about">
						<?php echo wp_kses($hugeshop_opt['corporate_about'], array(
								'a' => array(
									'href' => array(),
									'title' => array()
								),
								'div' => array(
									'class' => array(),
								),
								'img' => array(
									'src' => array(),
									'alt' => array()
								),
								'h3' => array(
									'class' => array(),
								),
								'ul' => array(),
								'li' => array(),
								'i' => array(
									'class' => array()
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'p' => array(),
							)); ?>
						</div>
					<?php } ?>
			</div>		
		</div>
		<?php } ?>

		<?php if(isset($hugeshop_opt)) { ?>
		<div class="footer-middle">
			<div class="container">
				<div class="footer-middle-inner">
					<div class="row">

						<?php if(isset($hugeshop_opt['about_us7']) && $hugeshop_opt['about_us7']!=''){ ?>
							<div class="col-xs-12 col-md-3 col-sm-6">
								<div class="widget widget_about_us">
								<?php echo wp_kses($hugeshop_opt['about_us7'], array(
										'a' => array(
									'href' => array(),
									'title' => array()
									),
									'div' => array(
										'class' => array(),
									),
									'img' => array(
										'src' => array(),
										'alt' => array()
									),
									'h3' => array(
										'class' => array(),
									),
									'ul' => array(),
									'li' => array(),
									'i' => array(
										'class' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
									'p' => array(),
									)); ?>
								</div>
							</div>
						<?php } ?>

					
						<?php
						if( isset($hugeshop_opt['footer_menu1']) && $hugeshop_opt['footer_menu1']!='' ) {
							$menu1_object = wp_get_nav_menu_object( $hugeshop_opt['footer_menu1'] );
							$menu1_args = array(
								'menu_class'      => 'nav_menu',
								'menu'         => $hugeshop_opt['footer_menu1'],
							); ?>
							<div class="col-sm-6  col-md-3">
								<div class="widget widget_menu">
									<h3 class="widget-title"><?php echo esc_html($menu1_object->name); ?></h3>
									<?php wp_nav_menu( $menu1_args ); ?>
								</div>
							</div>
						<?php }
						if( isset($hugeshop_opt['footer_menu2']) && $hugeshop_opt['footer_menu2']!='' ) {
							$menu2_object = wp_get_nav_menu_object( $hugeshop_opt['footer_menu2'] );
							$menu2_args = array(
								'menu_class'      => 'nav_menu',
								'menu'         => $hugeshop_opt['footer_menu2'],
							); ?>
							<div class="col-sm-6  col-md-3">
								<div class="widget widget_menu">
									<h3 class="widget-title"><?php echo esc_html($menu2_object->name); ?></h3>
									<?php wp_nav_menu( $menu2_args ); ?>
								</div>
							</div>
						<?php }?>

						<div class="col-sm-6  col-md-3">
							<?php
							if ( isset($hugeshop_opt['newsletter_form']) ) {
								if(class_exists( 'WYSIJA_NL_Widget' )){
									the_widget('WYSIJA_NL_Widget', array(
										'title' => esc_html($hugeshop_opt['newsletter_title']),
										'form' => (int)$hugeshop_opt['newsletter_form'],
										'id_form' => 'newsletter1',
										'success' => '',
									));
								}
							}
							?>
							<div class="widget widget-social">
								<h3 class="widget-title"><?php echo esc_html($hugeshop_opt['social_title']);?></h3>
								<?php

								if(isset($hugeshop_opt['social_icons'])) {
									echo '<ul class="social-icons">';
									foreach($hugeshop_opt['social_icons'] as $key=>$value ) {
										if($value!=''){
											if($key=='vimeo'){
												echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
											} else {
												echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
											}
										}
									}
									echo '</ul>';
								}
								?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="footer-bottom-inner">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="widget-copyright">
								<?php 
								if( isset($hugeshop_opt['copyright']) && $hugeshop_opt['copyright']!='' ) {
									echo wp_kses($hugeshop_opt['copyright'], array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'br' => array(),
										'em' => array(),
										'strong' => array(),
									));
								} else {
									echo 'Copyright <a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo('name').'</a> '.date('Y').'. All Rights Reserved';
								}
								?>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="widget-payment">
								<?php if(isset($hugeshop_opt['payment_icons']) && $hugeshop_opt['payment_icons']!='' ) {
									echo wp_kses($hugeshop_opt['payment_icons'], array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'img' => array(
											'src' => array(),
											'alt' => array()
										),
									)); 
								} ?>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>