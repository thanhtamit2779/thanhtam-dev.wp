<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage hugeshop_Themes
 * @since Huge Shop 1.0
 */
?>
<?php global $hugeshop_opt; 
if(is_ssl()){
	$hugeshop_opt['logo_main']['url'] = str_replace('http:', 'https:', $hugeshop_opt['logo_main']['url']);
}
?>
	<div class="header-container layout4">
		<div class="header">
			<div class="<?php if(isset($hugeshop_opt['sticky_header']) && $hugeshop_opt['sticky_header']) {echo 'header-sticky';} ?> <?php if ( is_admin_bar_showing() ) {echo 'with-admin-bar';} ?>">
				<div class="container header-inner">
					<div class="global-table hide-scroll">
						<div class="global-row">
							<div class="global-cell">
								<?php if( isset($hugeshop_opt['logo_main']['url']) ){ ?>
									<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url(get_template_directory_uri().'/images/logo3.png'); ?>" alt="" /></a></div>
								<?php
								} else { ?>
									<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								} ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-md-10">
							<div class="logo-scroll">
								<?php if( isset($hugeshop_opt['logo_main']['url']) ){ ?>
									<div class="logo-small"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url(get_template_directory_uri().'/images/logo3.png'); ?>" alt="" /></a></div>
								<?php
								} else { ?>
									<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								} ?>
							</div>	
							<div class="horizontal-menu">
								<div class="visible-large">
									<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
								</div>
								<div class="visible-small mobile-menu">
									<div class="nav-container">
										<div class="mbmenu-toggler"><?php echo esc_html($hugeshop_opt['mobile_menu_label']);?><span class="mbmenu-icon"><i class="fa fa-bars"></i></span></div>
										<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-md-2 content-header">
							<?php if(class_exists('WC_Widget_Product_Search') ) { ?>
								<div class="header-search">
									<div class="search-icon">
										<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
									</div>
								</div>
							<?php } ?>
							<?php if ( class_exists( 'WC_Widget_Cart' ) ) {
								the_widget('Custom_WC_Widget_Cart'); 
							} ?>
							<div class="vmenu-toggler">
								<div class="vmenu-toggler-button">
									<i class="fa fa-bars"></i>
								</div>
								<div class="vmenu-content">
									<?php wp_nav_menu( array( 'theme_location' => 'topmenu', 'container_class' => 'top-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
									<div class="title-vmenu">
										<?php _e('Currency', 'hugeshop');?>
									</div>	
									<?php do_action('currency_switcher'); ?>
									<div class="title-vmenu">
										<?php _e('Language', 'hugeshop');?>
									</div>	
									<?php do_action('icl_language_selector'); ?>
								</div>
							</div>
						</div>
						
					</div>	
				</div>
			</div>
		</div><!-- .header -->
		<div class="clearfix"></div>
	</div>
	