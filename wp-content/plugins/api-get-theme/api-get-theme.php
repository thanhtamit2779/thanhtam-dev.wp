<?php
/**
 * Plugin Name: API GET THEME
 * Plugin URI: themes.webdoctor.vn
 * Description: Lấy theme từ themes.webdoctor.vn trả về dạng Json
 * Version: 7.0
 * Author: Thanh Tam IT
 * Author URI: http://themes.webdoctor.vn/
 License: GPL
 */


define('THEME_WEBDOCTOR_VN_URL' , 'http://localhost:9090/themes.webdoctor.vn/');
define('WEBDOCTOR_VN_URL'       , 'https://webdoctor.vn/');

// Khởi tạo Plugin
add_action('widgets_init', 'init_api_get_theme');
function init_api_get_theme()
{
    return register_widget('api_get_theme');
}

// Khởi tạo js + css + ajax
add_action('wp_enqueue_scripts', 'init_ajax_api_get_theme', null);
function init_ajax_api_get_theme()
{
    wp_enqueue_style( 'gspinner-css',  plugins_url('/css/gspinner.css', __FILE__) , false );
    wp_enqueue_style( 'style-css',  plugins_url('/css/style.css', __FILE__) , false );
    wp_enqueue_style( 'css-js-thumbnail',  plugins_url('/css/js-thumbnail.css', __FILE__) , false );

    wp_enqueue_script('ajax-api-get-theme', plugins_url('/js/api-get-theme.js', __FILE__), array(
        'jquery'
    ));
    wp_enqueue_script('g-spinner-js', plugins_url('/js/g-spinner.js', __FILE__), array(
        'jquery'
    ));
    wp_enqueue_script('js-thumbnail', plugins_url('/js/js-thumbnail.js', __FILE__), array(
        'jquery'
    ));
    wp_localize_script('ajax-api-get-theme', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

add_action('wp_ajax_nopriv_get_themes_filter', 'get_themes_filter');
add_action('wp_ajax_get_themes_filter', 'get_themes_filter');
function get_themes_filter()
{
    $link    = THEME_WEBDOCTOR_VN_URL . 'theme/list'  ;
    $params  = array_merge($_GET, $_POST);
    unset($params['action']) ;
    $plugin_dir = plugin_dir_path(__FILE__) ;
    $themes = Requests::request($link, array(), $params) ;
    $themes = json_decode($themes->body) ;
    $themes = $themes->data;
    require_once $plugin_dir . 'html/list_theme.php';
    die();
}

function load_form_filter_themes( $atts = array()) {
    extract(shortcode_atts(array('name' => 'World'), $atts));
    require_once $plugin_dir . 'html/form_filter_themes.php';   
}
add_shortcode('load_form_filter_themes', 'load_form_filter_themes');

function load_themes_featured( $atts = array()) {
  //$link = THEME_WEBDOCTOR_VN_URL . 'api/theme/list?type=featured'  ;
  $link = THEME_WEBDOCTOR_VN_URL . 'theme/list?type=featured'  ;
  $plugin_dir = plugin_dir_path(__FILE__) ;

  $themes = Requests::request($link) ;
  $themes = json_decode($themes->body) ;
  $themes = $themes->data;

  require_once $plugin_dir . 'html/list_theme.php';
}
add_shortcode('load_themes_featured', 'load_themes_featured');

class api_get_theme extends WP_Widget {
  public function __construct() {
    parent::__construct( 'api_get_theme', $name = 'API GET THEME', array(
            'customize_selective_refresh' => true,
        ) );
  }

}