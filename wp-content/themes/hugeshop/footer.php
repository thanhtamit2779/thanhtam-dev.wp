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
			<?php
			if ( !isset($hugeshop_opt['footer_layout']) || $hugeshop_opt['footer_layout']=='default' ) {
				get_footer('first');
			} else {
				get_footer($hugeshop_opt['footer_layout']);
			}
			?>
		</div><!-- .page -->
	</div><!-- .wrapper -->
	<!--<div class="hugeshop_loading"></div>-->
	<?php if ( isset($hugeshop_opt['back_to_top']) && $hugeshop_opt['back_to_top'] ) { ?>
	<div id="back-top" class="hidden-xs hidden-sm hidden-md"></div>
	<?php } ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/ie8.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_footer(); ?>
</body>
</html>