<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php
global $hugeshop_viewmode, $hugeshop_opt, $hugeshop_shopclass, $wp_query, $woocommerce_loop;

$shoplayout = 'sidebar';
if(isset($hugeshop_opt['shop_layout']) && $hugeshop_opt['shop_layout']!=''){
	$shoplayout = $hugeshop_opt['shop_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$shoplayout = $_GET['layout'];
}
$shopsidebar = 'left';
if(isset($hugeshop_opt['sidebarshop_pos']) && $hugeshop_opt['sidebarshop_pos']!=''){
	$shopsidebar = $hugeshop_opt['sidebarshop_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$shopsidebar = $_GET['sidebar'];
}
switch($shoplayout) {
	case 'fullwidth':
		$hugeshop_shopclass = 'shop-fullwidth';
		$shopcolclass = 12;
		$shopsidebar = 'none';
		$productcols = 4;
		break;
	default:
		$hugeshop_shopclass = 'shop-sidebar';
		$shopcolclass = 9;
		$productcols = 3;
}

$hugeshop_viewmode = 'grid-view';
if(isset($hugeshop_opt['default_view'])) {
	if($hugeshop_opt['default_view']=='list-view'){
		$hugeshop_viewmode = 'list-view';
	}
}
if(isset($_GET['view']) && $_GET['view']=='list-view'){
	$hugeshop_viewmode = $_GET['view'];
}
?>
<div class="main-container">
	<div class="page-content">
		<?php if( is_shop() ) { ?>
		<div class="shop-desc <?php echo esc_attr($shoplayout);?>">
			<div class="shop_header">
				<div class="shop-desc-inner">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<header class="entry-header">
							<h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
						</header>
					<?php endif; ?>
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action( 'woocommerce_before_main_content' );
					?>
				</div>
			</div>
		</div>
		<?php } elseif (is_product_category()) { ?>
		<div class="category-desc <?php echo esc_attr($shoplayout);?>">
			<div class="category_header">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<header class="entry-header">
							<h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
						</header>
					<?php endif; ?>
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action( 'woocommerce_before_main_content' );
					?>
			</div>
			<div class="category-desc-inner">
				<div class="container">
					<?php do_action( 'woocommerce_archive_description' ); ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="shop_content">
			<div class="container">
				<div class="row">
					<?php if( $shopsidebar == 'left' ) :?>
						<?php get_sidebar('shop'); ?>
					<?php endif; ?>
					<div id="archive-product" class="col-xs-12 <?php echo 'col-md-'.$shopcolclass; ?>">
						
						<div class="archive-border">
							<?php if ( have_posts() ) : ?>
								
								<?php
									/**
									* remove message from 'woocommerce_before_shop_loop' and show here
									*/
									do_action( 'woocommerce_show_message' );
								?>
								<div class="shop-products">
									<?php woocommerce_product_subcategories();
									//reset loop
									$woocommerce_loop['loop'] = 0; ?>
								</div>
								
								<div class="toolbar">
									<div class="view-mode">
										<label><?php _e('View on', 'hugeshop');?></label>
										<a href="#" class="grid <?php if($hugeshop_viewmode=='grid-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'Grid', 'hugeshop' ); ?>"><i class="fa fa-th"></i></a>
										<a href="#" class="list <?php if($hugeshop_viewmode=='list-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'List', 'hugeshop' ); ?>"><i class="fa fa-th-list"></i></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 *
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 */
										do_action( 'woocommerce_before_shop_loop' );
									?>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>	
								
							<?php if ( have_posts() ) : ?>	
							
								<?php //woocommerce_product_loop_start(); ?>
								<div class="shop-products products row <?php echo esc_attr($hugeshop_viewmode);?> <?php echo esc_attr($shoplayout);?>">
									
									<?php $woocommerce_loop['columns'] = $productcols; ?>
									
									<?php while ( have_posts() ) : the_post(); ?>

										<?php wc_get_template_part( 'content', 'product-archive' ); ?>

									<?php endwhile; // end of the loop. ?>
								</div>
								<?php //woocommerce_product_loop_end(); ?>
								
								<div class="toolbar tb-bottom">
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 *
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 */
										do_action( 'woocommerce_after_shop_loop' );
										//do_action( 'woocommerce_before_shop_loop' );
									?>
									<div class="clearfix"></div>
								</div>
								
							<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

								<?php wc_get_template( 'loop/no-products-found.php' ); ?>

							<?php endif; ?>

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
					<?php if($shopsidebar == 'right') :?>
						<?php get_sidebar('shop'); ?>
					<?php endif; ?>
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
</div>
<?php get_footer( 'shop' ); ?>