<?php /* Template Name: THIẾT KẾ WEBSITE CHUYÊN NGHIỆP */ ?>

<!-- Header -->
<?php get_header(); ?>
<link rel="stylesheet"  href="<?php bloginfo('template_directory'); ?>/landing-page/webdoctor/css/style.css"/>
<link rel="stylesheet"  href="<?php bloginfo('template_directory'); ?>/landing-page/webdoctor/css/minify.css"/>
<!-- Content -->
<section id="service" class="text-center">
   <div class="container">
        <div class="service-content">
            <div class="row">
            <div class="col-md-5">
                <h1 class="involve_h1">Mẫu website nổi bật</h1>
            </div>
            <div id="formSearch">
                <?php echo do_shortcode('[load_form_filter_themes]'); ?>
            </div>
            <div class="clearfix"></div>
            </div>
            <div class="row" id="load-template">
                <?php echo do_shortcode('[load_themes_featured]'); ?>
            </div>
            <div id="loader"></div>
        </div>
   </div>
</section>
<script type="text/javascript">
   jQuery(document).ready(function() {
        jQuery(".js-thumbnail-item").on("touchend", function(a) {
            jQuery(this).parents(".js-thumbnail").trigger("mouseenter");
            a.stopImmediatePropagation() ;
        });
    });
</script> 
<?php get_footer(); ?>