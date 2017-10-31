<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php 
	$land = array_shift( wc_get_product_terms( get_the_ID(), 'pa_loai-nha-dat', array( 'fields' => 'names' ) ) );
	$acreage = array_shift( wc_get_product_terms( get_the_ID(), 'pa_dien-tich', array( 'fields' => 'names' ) ) );
	$bedroom = array_shift( wc_get_product_terms( get_the_ID(), 'pa_phong-ngu', array( 'fields' => 'names' ) ) );
	$bathroom = array_shift( wc_get_product_terms( get_the_ID(), 'pa_phong-tam', array( 'fields' => 'names' ) ) );
?>

<span class="aat">
	<?php if(isset($land)){ ?>
		<span class="acreage" style="width: 100%;float: left;">Loại: <?php echo $land; ?></span>
	<?php }; ?>
	<?php if(isset($acreage)){ ?>
		<span class="acreage">Diện tích: <?php echo $acreage; ?></span>
	<?php }; ?>
	<?php if(isset($bedroom)){ ?>
		<span class="bedroom"><?php echo $bedroom; ?></span>
	<?php }; ?>
	<?php if(isset($bathroom)){ ?>
		<span class="bathroom"><?php echo $bathroom; ?></span>
	<?php }; ?>
</span>
<?php if ( $price_html = $product->get_price_html()){ ?>
	<div class="price"><a  class="holine" href="tel:0903644040"><i class="fa fa-phone" aria-hidden="true"></i> 0903 64 4040</a> <span><?php echo $price_html; ?></span></div>
<?php }else{?>
	<div class="price"><a  class="holine" href="tel:0903644040"><i class="fa fa-phone" aria-hidden="true"></i> 0903 64 4040</a> <span>Liên hệ</span></div>
<?php } ?>
