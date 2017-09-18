<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php global $hugeshop_opt; ?>
<div class="main-container">

	<div class="page-content">
	
		<div class="product-page">
			<div class="title-breadcrumb">
				<div class="container">
					<div class="title-breadcrumb-inner">
						<h1><?php the_title(); ?></h1>
						<?php do_action( 'woocommerce_before_main_content' ); ?>
					</div>
				</div>
			</div>
			<div class="product-view">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

				<?php
					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>

				<?php
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					//do_action( 'woocommerce_sidebar' );
				?>
			</div>
			
		</div>
		
<!--

		<div class="brands-logo other-page">
			<div class="container">
			<?php echo do_shortcode('[ourbrands]'); ?>
			</div>
		</div>

-->

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
<?php get_footer( 'shop' ); ?>