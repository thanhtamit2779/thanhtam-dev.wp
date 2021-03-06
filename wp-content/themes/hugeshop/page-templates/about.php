<?php
/**
 * Template Name: About page
 *
 * Description: About page template
 *
 * @package WordPress
 * @subpackage hugeshop_Themes
 * @since Huge Shop 1.0
 */
global $hugeshop_opt;

get_header();
?>
<div class="main-container about-page">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<?php HugeShop::hugeshop_breadcrumb(); ?>
			</div>
		</div>
	</div>
	<div class="page-content">
		<div class="about-container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
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