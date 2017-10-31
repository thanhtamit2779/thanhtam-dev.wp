<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<h3 class="title-product br-bro" style=" line-height: 40px; ">Thông Tin</h3>
<p class="price">Giá: <?php echo $product->get_price_html(); ?></p>

<table class="top_attributes">	
	<tbody>
		<tr>
			<td>Diện Tích</td>
			<td>
			<?php echo $acreage = array_shift( wc_get_product_terms( get_the_ID(), 'pa_dien-tich', array( 'fields' => 'names' ) ) );?>
			</td>
		</tr>
		<tr>
			<td>Loại Nhà Đất</td>
			<td>
			<?php echo $acreage = array_shift( wc_get_product_terms( get_the_ID(), 'pa_loai-nha-dat', array( 'fields' => 'names' ) ) );?>
			</td>
		</tr>
		<tr>
			<td>Hướng</td>
			<td>
			<?php echo $acreage = array_shift( wc_get_product_terms( get_the_ID(), 'pa_huong', array( 'fields' => 'names' ) ) );?>
			</td>
		</tr>
		<tr>
			<td>Phòng Ngủ</td>
			<td>
			<?php echo $acreage = array_shift( wc_get_product_terms( get_the_ID(), 'pa_phong-ngu', array( 'fields' => 'names' ) ) );?>
			</td>
		</tr>
		<tr>
			<td>Phòng Tắm</td>
			<td>
			<?php echo $acreage = array_shift( wc_get_product_terms( get_the_ID(), 'pa_phong-tam', array( 'fields' => 'names' ) ) );?>
			</td>
		</tr>
	</tbody>
</table>
