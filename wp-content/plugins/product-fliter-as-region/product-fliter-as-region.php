<?php
/**
 * Plugin Name: Tìm SP theo vùng
 * Plugin URI: webdoctor.vn-adplus.vn
 * Description: Widget that displays category listings for custom post types (custom taxonomies).
 * Version: 4.1
 * Author: Thanh Tam IT - Webdoctor.vn-Adsplus.vn
 * Author URI: webdoctor.vn-adplus.vn
 * Tags: custom taxonomy, custom tax, widget, sidebar, category, categories, taxonomy, custom category, custom categories, post types, custom post types, custom post type categories
 * License: GPL
 
 =====================================================================================
 Copyright (C) 2017 Thanh Tâm IT
 =====================================================================================
 */
require_once 'functions.php' ;

// Register 'List Custom Taxonomy' widget
add_action('widgets_init', 'init_product_fliter_as_region');
function init_product_fliter_as_region()
{
    return register_widget('product_fliter_as_region');
}

// Tạo file javascript + Khởi tạo AJAX
add_action('wp_enqueue_scripts', 'init_ajax_product_fliter_as_region', null);
function init_ajax_product_fliter_as_region()
{
    wp_enqueue_style( 'bootstrap',  plugins_url('/css/bootstrap.min.css', __FILE__) , false );
    wp_enqueue_script('ajax-bootstrap', plugins_url('/js/bootstrap.min.js', __FILE__), array(
        'jquery'
    ));
    wp_enqueue_script('ajax-product-fliter-as-region', plugins_url('/js/product-fliter-as-region.js', __FILE__), array(
        'jquery'
    ));
    wp_localize_script('ajax-product-fliter-as-region', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

// Load tỉnh thành
add_action('wp_ajax_nopriv_get_city', 'get_city');
add_action('wp_ajax_get_city', 'get_city');
function get_city()
{
    $region_id = (isset($_POST['region_id'])) ? $_POST['region_id'] : -1;
    if (empty($region_id)) return FALSE;
    
    $args['child_of'] = $region_id;
    $args['depth']    = 1;
    echo dropdown_region($args);
    die();
}

// Load quận , huyện
add_action('wp_ajax_nopriv_get_dictrict', 'get_dictrict');
add_action('wp_ajax_get_dictrict', 'get_dictrict');
function get_dictrict()
{
    $city_id = (isset($_POST['city_id'])) ? $_POST['city_id'] : -1;
    if (empty($city_id))
        return FALSE;
    
    $args['child_of'] = $city_id;
    $args['depth']    = 1;
    echo dropdown_region($args);
    die();
}

// Lọc theo vùng miền + tỉnh, thành + quận huyện
add_action('wp_ajax_nopriv_search_product_as_region', 'search_product_as_region');
add_action('wp_ajax_search_product_as_region', 'search_product_as_region');
function search_product_as_region()
{
    $city_id         = $_POST['city_id'];
    if($city_id != -1) $taxonomy_id = $city_id ; 

    $dictrict_id     = $_POST['dictrict_id'] ;
    if($dictrict_id != -1) $taxonomy_id = $dictrict_id ; 
     
    $paged = isset($_POST['page']) ? $_POST['page'] : 1 ;
    
    $args  = array(
        'post_type'         => 'product',
        'post_status'       => 'publish',
        'posts_per_page'    => get_option('posts_per_page') ,
        'paged'             => $paged,
        'orderby'           => array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
        'tax_query'         => array(
            array(
                'taxonomy' => 'product-as-region',
                'field'    => 'term_id',
                'operator' => 'IN',
                'terms'    => $taxonomy_id
            )
        )
    );
    list_product_as_region($args) ; 
    die() ;
}

// Danh sách vùng miền + tỉnh, thành + quận huyện
function dropdown_region($args = '')
{
    $walker = new product_fliter_as_region_Dropdown_Walker();
    
    $defaults = array(
        'show_option_all'   => false,
        'show_option_none'  => '',
        'orderby'           => 'name', //$orderby,
        'order'             => 'asc',
        'show_count'        => 1,
        'hide_empty'        => 0,
        'child_of'          => 0,
        'echo'              => 1,
        //'selected'           => 0,
        'hierarchical'      => 1,
        'name'              => 'created_region',
        'id'                => 'product-region',
        //'class'              => 'postform',
        'depth'             => 1,
        //'tab_index'          => 0,
        'taxonomy'          => 'product-as-region',
        'hide_if_empty'     => false,
        'walker'            => $walker
    );
    
    $defaults['selected'] = (is_category()) ? get_query_var('cat') : 0;
    
    $r                 = wp_parse_args($args, $defaults);
    $get_terms_args = $r;
    unset($get_terms_args['name']);
    $categories = get_terms($r['taxonomy'], $get_terms_args);

    if (!empty($categories)) {
        
        if ($r['show_option_all']) {
            
            /** This filter is documented in wp-includes/category-template.php */
            $show_option_all = apply_filters('list_cats', $r['show_option_all']);
            $selected        = ('0' === strval($r['selected'])) ? " selected='selected'" : '';
            $output .= "\t<option value='0'$selected>$show_option_all</option>\n";
        }
        
        if ($r['show_option_none']) {
            
            /** This filter is documented in wp-includes/category-template.php */
            $show_option_none = apply_filters('list_cats', $r['show_option_none']);
            $selected         = selected($option_none_value, $r['selected'], false);
            $output .= "\t<option value='" . esc_attr($option_none_value) . "'$selected>$show_option_none</option>\n";
        }
        
        if ($r['hierarchical']) {
            $depth = $r['depth']; // Walk the full depth.
        } else {
            $depth = -1; // Flat.
        }
        $output .= walk_category_dropdown_tree($categories, $depth, $r);
    }
    
    /**
     * Filters the taxonomy drop-down output.
     *
     * @since 2.1.0
     *
     * @param string $output HTML output.
     * @param array  $r      Arguments used to build the drop-down.
     */
    $output = apply_filters('wp_dropdown_cats', $output, $r);
    return $output;
}
                                                                                                                                                                        
 function display_region_form( $atts = array()) {
        extract(shortcode_atts(array('name' => 'World'), $atts));
        ?>
            <div method="post" id="form-post-as-region" class="form-inline">               
                
                <!-- vung mien 
                <div class="form-group">
                    <select name="region" id="lct-widget-region" class="form-control">
                        <option value="-1" class="select-default">--- Chọn vùng miền ---</option>
                        <?php //echo dropdown_region(); ?>
                    </select>
                </div> -->
            
                <!-- tỉnh, thành -->
                <div class="form-group">
                    <select name="city" id="lct-widget-city" class="form-control">';
                        <option value="-1" class="select-default">--- Chọn tỉnh, thành ---</option>
                        <?php echo dropdown_region(); ?>
                    </select>
                </div>
            
                <!--  quận, huyện, thị xã -->
                <div class="form-group">
                    <select name="dictrict" id="lct-widget-dictrict" class="form-control">
                        <option value="-1" class="select-default">--- Chọn quận, huyện, thị xã ---</option>
                    </select>
                </div>
                
                <!-- tìm kiếm -->    
                <div class="form-group"><button class="btn btn-success btn-sm" id="btn-search" type="button">Tìm kiếm</button></div>

            </div>
        <?php     
}

add_shortcode('display_region_form', 'display_region_form');
 
class product_fliter_as_region extends WP_Widget {
    /** constructor */
    function __construct() {
        parent::__construct( 'product_filter_as_region', $name = 'Lọc Sản Phẩm Theo Vùng', array(
            'customize_selective_refresh' => true,
        ) );
    }

} // class product_filter_as_region


/* Custom version of Walker_CategoryDropdown */
class product_fliter_as_region_Dropdown_Walker extends Walker
{
    var $tree_type = 'product-as-region';
    var $db_fields = array('id' => 'term_id', 'parent' => 'parent');
    
    function start_el(&$output, $term, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $term      = get_term($term, $term->taxonomy);
        $term_slug = $term->slug;
        $term_id   = $term->term_id;
        
        $text = str_repeat('&nbsp;', $depth * 3) . $term->name;
        if ($args['show_count']) {
            $text .= '&nbsp;(' . $term->count . ')';
        }
        
        $class_name = 'level-' . $depth;
        
        $output .= "\t" . '<option' . ' class="' . esc_attr($class_name) . '" value="' . esc_attr($term_id) . '">' . esc_html($text) . '</option>' . "\n";
    }
}
?>