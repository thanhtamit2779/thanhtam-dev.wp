<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage hugeshop_Themes
 * @since Huge Shop 1.0
 */

global $hugeshop_opt;

get_header();
?>
<?php 
$bloglayout = 'nosidebar';
if(isset($hugeshop_opt['blog_layout']) && $hugeshop_opt['blog_layout']!=''){
	$bloglayout = $hugeshop_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$bloglayout = $_GET['layout'];
}
$blogsidebar = 'right';
if(isset($hugeshop_opt['sidebarblog_pos']) && $hugeshop_opt['sidebarblog_pos']!=''){
	$blogsidebar = $hugeshop_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$blogsidebar = $_GET['sidebar'];
}
switch($bloglayout) {
	case 'sidebar':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 12;
		break;
	default:
		$blogclass = 'blog-nosidebar'; //for both fullwidth and no sidebar
		$blogcolclass = 12;
		$blogsidebar = 'none';
}
?>
<div class="main-container page-wrapper">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner">
				<header class="entry-header">
					<h1 class="entry-title"><?php if(isset($hugeshop_opt)) { echo esc_html($hugeshop_opt['blog_header_text']); } else { _e('Blog', 'hugeshop');}  ?></h1>
				</header>
				<?php HugeShop::hugeshop_breadcrumb(); ?>
			</div>
		</div>
		
	</div>
	<div class="container">
		<div class="row">

			<?php if($blogsidebar=='left') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			
			<div class="col-xs-12 <?php echo 'col-md-'.$blogcolclass; ?>">
				<div class="page-content blog-page single <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>

						<?php comments_template( '', true ); ?>
						
						<!--<nav class="nav-single">
							<h3 class="assistive-text"><?php _e( 'Post navigation', 'hugeshop' ); ?></h3>
							<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'hugeshop' ) . '</span> %title' ); ?></span>
							<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'hugeshop' ) . '</span>' ); ?></span>
						</nav><!-- .nav-single -->
						
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<?php if( $blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
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

<?php get_footer(); ?>