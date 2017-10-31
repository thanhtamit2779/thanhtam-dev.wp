<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		//do_action( 'woocommerce_before_single_product_summary' );
	?>

<div class="td-pb-span9">
	<h1 class="title-product br-bro"><?php the_title(); ?></h1>
	<div class="single-product-feature-img images">
		<!-- Place somewhere in the <body> of your page -->

		<div id="slider" class="flexslider foogallery-container foogallery-lightbox-foobox-free fbx-instance">
		  <ul class="slides ">			
			<?php
				global $product;
				$attachment_ids = $product->get_gallery_attachment_ids();
				foreach( $attachment_ids as $attachment_id ) 
				{	
					echo '<li><a class="foobox" rel="gallery" href="' . wp_get_attachment_image_src( $attachment_id, 'full')[0] . '"><img alt="'.$product_name.'" src="'. wp_get_attachment_image_src( $attachment_id, 'shop_single')[0] . '" /></a></li>';
				}
			?>
		  </ul>
		</div>
		
		<div id="carousel" class="flexslider" style="display: none;">
		  <ul class="slides">
			<?php
				foreach( $attachment_ids as $attachment_id ) 
				{
					echo '<li><img alt="'.$product_name.'" src="'. wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail')[0] . '"/></li>';
				}
			?>
		  </ul>
		</div>

	<?php
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	</div></div>

    <div class="td-pb-span3 td-main-sidebar">
		<div class="summary entry-summary">
			<?php
				do_action( 'woocommerce_single_product_summary' );
			?>
	            <div class="td-ss-main-sidebar"  style="margin-top: 24px;">
	                <?php get_sidebar(); ?>
	            </div>
        </div>

	</div><!-- .summary -->
	

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
