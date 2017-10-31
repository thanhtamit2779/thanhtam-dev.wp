<?php /* Template Name: Landing Page */ get_header(); ?>
<div class="td-container tdc-content-wrap">
    <div class="vc_row wpb_row td-pb-row bg-padding">
        <div class="col-sm-12"><div class="td-crumb-container"><?php echo td_page_generator::get_single_breadcrumbs($td_mod_single->title); ?></div></div>
        <div class="col-sm-12">
            <?php echo do_shortcode('[display_region_form]'); ?>
        </div>
        <div class="col-sm-12">
            <br/>
            <div id="filter-product-as-region" class="woocommerce woocommerce-page">
            
            </div>
        </div>
    </div>
</div>
<?php get_footer();        