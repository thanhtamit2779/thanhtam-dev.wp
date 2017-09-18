<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Huge Shop already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage hugeshop_Themes
 * @since Huge Shop 1.0
 */
global $hugeshop_opt, $hugeshop_postthumb;

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
		$blogcolclass = 9;
		$hugeshop_postthumb = 'hugeshop-category-thumb';
		break;
	case 'largeimage':
		$blogclass = 'blog-large';
		$blogcolclass = 9;
		$hugeshop_postthumb = '';
		break;
	default:
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		$blogsidebar = 'none';
		$hugeshop_postthumb = 'hugeshop-post-thumb';
}
?>
<div class="main-container">
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
				<div class="page-content blog-page <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>
						<header class="archive-header">
							<h1 class="archive-title"><?php
								if ( is_day() ) :
									printf( esc_html__( 'Daily Archives: %s', 'hugeshop' ), '<span>' . get_the_date() . '</span>' );
								elseif ( is_month() ) :
									printf( esc_html__( 'Monthly Archives: %s', 'hugeshop' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'hugeshop' ) ) . '</span>' );
								elseif ( is_year() ) :
									printf( esc_html__( 'Yearly Archives: %s', 'hugeshop' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'hugeshop' ) ) . '</span>' );
								else :
									_e( 'Archives', 'hugeshop' );
								endif;
							?></h1>
						</header><!-- .archive-header -->

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/* Include the post format-specific template for the content. If you want to
							 * this in a child theme then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						endwhile;
						?>
						
						<div class="pagination">
							<?php HugeShop::hugeshop_pagination(); ?>
						</div>
						
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php if( $blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
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
<?php get_footer(); ?>