<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage hugeshop_Themes
 * @since Huge Shop 1.0
 */

global $hugeshop_opt;

get_header();

?>
	<div class="main-container error404">
		<div class="container">
			<div class="search-form-wrapper">
				<h1>404</h1>
				<h2><?php _e( "Opps! PAGE NOT BE FOUND", 'hugeshop' ); ?></h2>
				<p class="home-link"><?php _e( "Sorry but the page you are looking for does not exist, have been removed, name changed or is temporarity unavailable.", 'hugeshop' ); ?></p>
				<?php get_search_form(); ?>
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php _e( 'Back to home', 'hugeshop' ); ?>"><?php _e( 'Back to home page', 'hugeshop' ); ?></a>
			</div>
		</div>
		<div class="brands-logo other-page">
			<div class="container">
			<?php echo do_shortcode('[ourbrands]'); ?>
			</div>
		</div>
		<div class="home-static3 other-page">
			<div class="container">
				<?php if(isset($hugeshop_opt['static_block3'])) {
					echo wp_kses($hugeshop_opt['static_block3'], array(
						'a' => array(
						'class' => array(),
						'href' => array(),
						'title' => array()
						),
						'img' => array(
							'src' => array(),
							'alt' => array()
						),
						'strong' => array(),
						'h2' => array(),
						'p' => array(),
						'i' => array(),
					)); 
				} ?>
			</div>	
		</div>
	</div>
</div>
<?php get_footer(); ?>