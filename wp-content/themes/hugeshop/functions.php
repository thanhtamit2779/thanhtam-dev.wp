<?php
/**
 * Huge Shop functions and definitions
 */

/**
* Require files
*/
	//TGM-Plugin-Activation
require_once( get_template_directory().'/class-tgm-plugin-activation.php' );
	//Init the Redux Framework
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_template_directory().'/theme-config.php' ) ) {
	require_once( get_template_directory().'/theme-config.php' );
}
	// Theme files
if ( !class_exists( 'hugeshop_widgets' ) && file_exists( get_template_directory().'/include/hugewidgets.php' ) ) {
	require_once( get_template_directory().'/include/hugewidgets.php' );
}
if ( file_exists( get_template_directory().'/include/styleswitcher.php' ) ) {
	require_once( get_template_directory().'/include/styleswitcher.php' );
}
if ( file_exists( get_template_directory().'/include/wooajax.php' ) ) {
	require_once( get_template_directory().'/include/wooajax.php' );
}
if ( file_exists( get_template_directory().'/include/map_shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/map_shortcodes.php' );
}
if ( file_exists( get_template_directory().'/include/blogsharing.php' ) ) {
	require_once( get_template_directory().'/include/blogsharing.php' );
}
if ( file_exists( get_template_directory().'/include/productsharing.php' ) ) {
	require_once( get_template_directory().'/include/productsharing.php' );
}

Class HugeShop {
	/**
	* Constructor
	*/
	function __construct() {
		// Register action/filter callbacks
		
			//WooCommerce - action/filter
		add_theme_support( 'woocommerce' );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		add_filter( 'get_product_search_form', array($this, 'hugeshop_woo_search_form'));
		add_filter( 'woocommerce_shortcode_products_query', array($this, 'hugeshop_woocommerce_shortcode_count'));
		add_action( 'woocommerce_share', array($this, 'hugeshop_woocommerce_social_share'), 35 );
		add_action( 'woocommerce_archive_description', array($this, 'hugeshop_woocommerce_category_image'), 2 );
		
			//move message to top
		remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
		add_action( 'woocommerce_show_message', 'wc_print_notices', 10 );

			//remove cart total under cross sell
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

			//Single product organize
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
		
		
			//WooProjects - Project organize
		remove_action( 'projects_before_single_project_summary', 'projects_template_single_title', 10 );
		add_action( 'projects_single_project_summary', 'projects_template_single_title', 5 );
		remove_action( 'projects_before_single_project_summary', 'projects_template_single_short_description', 20 );
		remove_action( 'projects_before_single_project_summary', 'projects_template_single_gallery', 40 );
		add_action( 'projects_single_project_gallery', 'projects_template_single_gallery', 40 );
		
			//WooProjects - projects list
		remove_action( 'projects_loop_item', 'projects_template_loop_project_title', 20 );
		
			//Theme actions
		add_action( 'after_setup_theme', array($this, 'hugeshop_setup'));
		add_action( 'tgmpa_register', array($this, 'hugeshop_register_required_plugins')); 
		add_action( 'widgets_init', array($this, 'hugeshop_override_woocommerce_widgets'), 15 );
		
		add_action( 'wp_enqueue_scripts', array($this, 'hugeshop_scripts_styles') );
		add_action( 'wp_head', array($this, 'hugeshop_custom_code_header'));
		add_action( 'widgets_init', array($this, 'hugeshop_widgets_init'));
		add_action( 'add_meta_boxes', array($this, 'hugeshop_add_meta_box'));
		add_action( 'save_post', array($this, 'hugeshop_save_meta_box_data'));
		add_action('comment_form_before_fields', array($this, 'hugeshop_before_comment_fields'));
		add_action('comment_form_after_fields', array($this, 'hugeshop_after_comment_fields'));
		add_action( 'customize_register', array($this, 'hugeshop_customize_register'));
		add_action( 'customize_preview_init', array($this, 'hugeshop_customize_preview_js'));
		add_action( 'admin_head', array($this, 'hugeshop_remove_redux_ads'));
		
			//Theme filters
		add_filter( 'woocommerce_get_price_html', array($this, 'hugeshop_woo_price_html'), 100, 2 );
		add_filter( 'loop_shop_per_page', array($this, 'hugeshop_woo_change_per_page'), 20 );
		add_filter( 'woocommerce_output_related_products_args', array($this, 'hugeshop_woo_related_products_limit'));
		add_filter( 'get_search_form', array($this, 'hugeshop_search_form'));
		add_filter('excerpt_more', array($this, 'hugeshop_new_excerpt_more'));
		add_filter( 'excerpt_length', array($this, 'hugeshop_change_excerpt_length'), 999 );
		add_filter('wp_nav_menu_objects', array($this, 'hugeshop_first_and_last_menu_class'));
		add_filter( 'wp_page_menu_args', array($this, 'hugeshop_page_menu_args'));
		add_filter('dynamic_sidebar_params', array($this, 'hugeshop_widget_first_last_class'));
		add_filter('dynamic_sidebar_params', array($this, 'hugeshop_mega_menu_widget_change'));
		add_filter( 'dynamic_sidebar_params', array($this, 'hugeshop_put_widget_content'));
		
		//Adding theme support
		if ( ! isset( $content_width ) ) {
			$content_width = 625;
		}
	}
	
	/**
	* Filter callbacks
	* ----------------
	*/
	//Change price html
	function hugeshop_woo_price_html( $price, $product ){

		if($product->product_type=="variable") {
			if($product->get_variation_sale_price() && $product->get_variation_regular_price()!=$product->get_variation_sale_price()){
				$rprice = $product->get_variation_regular_price();
				$sprice = $product->get_variation_sale_price();
				
				return '<span class="special-price">'.( ( is_numeric( $sprice ) ) ? woocommerce_price( $sprice ) : $sprice ) .'</span><span class="old-price">'. ( ( is_numeric( $rprice ) ) ? woocommerce_price( $rprice ) : $rprice ) .'</span>'.$product->get_price_suffix();
			} else {
				$rprice = $product->get_variation_regular_price();
				return '<span class="special-price">' . ( ( is_numeric( $rprice ) ) ? woocommerce_price( $rprice ) : $rprice ) . '</span>'.$product->get_price_suffix();
			}
		}
		if ( $product->price > 0 ) {
			if ( $product->price && isset( $product->regular_price ) && ( $product->price!=$product->regular_price )) {
			$rprice = $product->regular_price;
			$sprice = $product->price;
			return '<span class="special-price">'.( ( is_numeric( $sprice ) ) ? woocommerce_price( $sprice ) : $sprice ) .'</span><span class="old-price">'. ( ( is_numeric( $rprice ) ) ? woocommerce_price( $rprice ) : $rprice ) .'</span>'.$product->get_price_suffix();
			} else {
			$sprice = $product->price;
			return '<span class="special-price">' . ( ( is_numeric( $sprice ) ) ? woocommerce_price( $sprice ) : $sprice ) . '</span>'.$product->get_price_suffix();
			}
		} else {
			return '<span class="special-price">0</span>'.$product->get_price_suffix();
		}
	}
	// Change products per page
	function hugeshop_woo_change_per_page() {
		global $hugeshop_opt;
		
		return $hugeshop_opt['product_per_page'];
	}
	//Change number of related products on product page. Set your own value for 'posts_per_page'
	function hugeshop_woo_related_products_limit( $args ) {
		global $product, $hugeshop_opt;
		$args['posts_per_page'] = $hugeshop_opt['related_amount'];

		return $args;
	}
	// Count number of products from shortcode
	function hugeshop_woocommerce_shortcode_count( $args ) {
		global $hugeshop_opt, $hugeshop_productsfound;
		
		$hugeshop_productsfound = new WP_Query($args);
		$hugeshop_productsfound = $hugeshop_productsfound->post_count;
		
		return $args;
	}
	//Change search form
	function hugeshop_search_form( $form ) {
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search...', 'hugeshop' );
		}
		
		$form = '<form role="search" method="get" id="blogsearchform" class="searchform" action="' . esc_url(home_url( '/' ) ). '" >
		<div class="form-input">
			<input class="input_text" type="text" value="'.esc_attr($search_str).'" name="s" id="search_input" />
			<button class="button" type="submit" id="blogsearchsubmit"><i class="fa fa-search"></i></button>
			</div>
		</form>';
		$form .= '<script type="text/javascript">';
		$form .= 'jQuery(document).ready(function(){
			jQuery("#search_input").focus(function(){
				if(jQuery(this).val()=="'.__( 'Search...', 'hugeshop' ).'"){
					jQuery(this).val("");
				}
			});
			jQuery("#search_input").focusout(function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("'.__( 'Search...', 'hugeshop' ).'");
				}
			});
			jQuery("#blogsearchsubmit").click(function(){
				if(jQuery("#search_input").val()=="'.__( 'Search...', 'hugeshop' ).'" || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});';
		$form .= '</script>';
		return $form;
	}
	//Change woocommerce search form
	function hugeshop_woo_search_form( $form ) {
		global $wpdb;
		
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search product...', 'hugeshop' );
		}
		
		$form = '<form role="search" method="get" id="searchform" action="'.esc_url( home_url( '/'  ) ).'">';
			$form .= '<div>';
				$form .= '<input type="text" value="'.esc_attr($search_str).'" name="s" id="ws" placeholder="" />';
				$form .= '<button class="btn btn-primary" type="submit" id="wsearchsubmit"><i class="fa fa-search"></i></button>';
				$form .= '<input type="hidden" name="post_type" value="product" />';
			$form .= '</div>';
		$form .= '</form>';
		$form .= '<script type="text/javascript">';
		$form .= 'jQuery(document).ready(function(){
			jQuery("#ws").focus(function(){
				if(jQuery(this).val()=="'.__( 'Search product...', 'hugeshop' ).'"){
					jQuery(this).val("");
				}
			});
			jQuery("#ws").focusout(function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("'.__( 'Search product...', 'hugeshop' ).'");
				}
			});
			jQuery("#wsearchsubmit").click(function(){
				if(jQuery("#ws").val()=="'.__( 'Search product...', 'hugeshop' ).'" || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
		});';
		$form .= '</script>';
		return $form;
	}
	// Replaces the excerpt "more" text by a link
	function hugeshop_new_excerpt_more($more) {
		return '';
	}
	//Change excerpt length
	function hugeshop_change_excerpt_length( $length ) {
		global $hugeshop_opt;
		
		if(isset($hugeshop_opt['excerpt_length'])){
			return $hugeshop_opt['excerpt_length'];
		}
		
		return 22;
	}
	//Add 'first, last' class to menu
	function hugeshop_first_and_last_menu_class($items) {
		$items[1]->classes[] = 'first';
		$items[count($items)]->classes[] = 'last';
		return $items;
	}
	/**
	 * Filter the page menu arguments.
	 *
	 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
	 *
	 * @since Huge Shop 1.0
	 */
	function hugeshop_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) )
			$args['show_home'] = true;
		return $args;
	}
	//Add first, last class to widgets
	function hugeshop_widget_first_last_class($params) {
		global $my_widget_num;
		
		$class = '';
		
		$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
		$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

		if(!$my_widget_num) {// If the counter array doesn't exist, create it
			$my_widget_num = array();
		}

		if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
			return $params; // No widgets in this sidebar... bail early.
		}

		if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
			$my_widget_num[$this_id] ++;
		} else { // If not, create it starting with 1
			$my_widget_num[$this_id] = 1;
		}

		if($my_widget_num[$this_id] == 1) { // If this is the first widget
			$class .= ' widget-first ';
		} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
			$class .= ' widget-last ';
		}
		
		$params[0]['before_widget'] = str_replace('first_last', ' '.$class.' ', $params[0]['before_widget']);
		
		return $params;
	}
	//Change mega menu widget from div to li tag
	function hugeshop_mega_menu_widget_change($params) {
		
		$sidebar_id = $params[0]['id'];
		
		$pos = strpos($sidebar_id, '_menu_widgets_area_');
		
		if ( !$pos == false ) {
			$params[0]['before_widget'] = '<li class="widget_mega_menu">'.$params[0]['before_widget'];
			$params[0]['after_widget'] = $params[0]['after_widget'].'</li>';
		}
		
		return $params;
	}
	// Push sidebar widget content into a div
	function hugeshop_put_widget_content( $params ) {
		global $wp_registered_widgets;

		if( $params[0]['id']=='sidebar-category' ){
			$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
			$settings = $settings_getter->get_settings();
			$settings = $settings[ $params[1]['number'] ];
			
			if($params[0]['widget_name']=="Text" && isset($settings['title']) && $settings['text']=="") { // if text widget and no content => don't push content
				return $params;
			}
			if( isset($settings['title']) && $settings['title']!='' ){
				$params[0][ 'after_title' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			} else {
				$params[0][ 'before_widget' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			}
		}
		
		return $params;
	}
	
	/**
	* Action hooks
	* ----------------
	*/
	/**
	 * Huge Shop setup.
	 *
	 * Sets up theme defaults and registers the various WordPress features that
	 * Huge Shop supports.
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_editor_style() To add a Visual Editor stylesheet.
	 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
	 * 	custom background, and post formats.
	 * @uses register_nav_menu() To add support for navigation menus.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Huge Shop 1.0
	 */
	function hugeshop_setup() {
		/*
		 * Makes Huge Shop available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Huge Shop, use a find and replace
		 * to change 'hugeshop' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hugeshop', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// This theme supports a variety of post formats.
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );

		// Register menus
		register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'hugeshop' ) );
		register_nav_menu( 'categories', esc_html__( 'Categories Menu', 'hugeshop' ) );
		register_nav_menu( 'topmenu', esc_html__( 'Top Menu', 'hugeshop' ) );
		register_nav_menu( 'mobilemenu', esc_html__( 'Mobile Menu', 'hugeshop' ) );

		/*
		 * This theme supports custom background color and image,
		 * and here we also set up the default background color.
		 */
		add_theme_support( 'custom-background', array(
			'default-color' => 'e6e6e6',
		) );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		
		// This theme uses a custom image size for featured images, displayed on "standard" posts.
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 870, 9999 ); // Unlimited height, soft crop
		add_image_size( 'hugeshop-category-thumb', 320, 320, true ); // (cropped)
		add_image_size( 'hugeshop-post-thumb', 650, 440, true ); // (cropped)
		add_image_size( 'hugeshop-post-thumbwide', 370, 250, true ); // (cropped)
	}
	//Override woocommerce widgets
	function hugeshop_override_woocommerce_widgets() {
		//Show mini cart on all pages
		if ( class_exists( 'WC_Widget_Cart' ) ) {
			unregister_widget( 'WC_Widget_Cart' ); 
			include_once( get_template_directory().'/woocommerce/class-wc-widget-cart.php' );
			register_widget( 'Custom_WC_Widget_Cart' );
		}
	}
	// Add image to category description
	function hugeshop_woocommerce_category_image() {
		if ( is_product_category() ){
			global $wp_query;
			
			$cat = $wp_query->get_queried_object();
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id );
			
			if ( $image ) {
				echo '<p class="category-image-desc"><img src="' . esc_url($image) . '" alt="" /></p>';
			}
		}
	}
	//Display social sharing on product page
	function hugeshop_woocommerce_social_share(){
		global $hugeshop_opt;
	?>
		<div class="share_buttons">
			<?php if ($hugeshop_opt['share_code']!='') {
				echo wp_kses($hugeshop_opt['share_code'], array(
					'div' => array(
						'class' => array()
					),
					'span' => array(
						'class' => array(),
						'displayText' => array()
					),
				));
			} ?>
		</div>
	<?php
	}
	/**
	 * Enqueue scripts and styles for front-end.
	 *
	 * @since Huge Shop 1.0
	 */
	function hugeshop_scripts_styles() {
		global $wp_styles, $wp_scripts, $hugeshop_opt;
		
		/*
		 * Adds JavaScript to pages with the comment form to support
		 * sites with threaded comments (when in use).
		*/
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		
		// Add Bootstrap JavaScript
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.2.0', true );
		
		// Add Slick files
		wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick/slick.min.js', array('jquery'), '1.3.15', true );
		wp_enqueue_style( 'slick-style', get_template_directory_uri() . '/js/slick/slick.css', array(), '1.3.15' );
		
		// Add Chosen js files
		wp_enqueue_script( 'chosen-js', get_template_directory_uri() . '/js/chosen/chosen.jquery.min.js', array('jquery'), '1.3.0', true );
		wp_enqueue_script( 'chosenproto-js', get_template_directory_uri() . '/js/chosen/chosen.proto.min.js', array('jquery'), '1.3.0', true );
		wp_enqueue_style( 'chosen-style', get_template_directory_uri() . '/js/chosen/chosen.min.css', array(), '1.3.0' );
		
		// Add parallax script files
		
		// Add Fancybox
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true );
		wp_enqueue_script( 'fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.js', array('jquery'), '1.0.5', true );
		wp_enqueue_script( 'fancybox-media', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-media.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.js', array('jquery'), '1.0.7', true );
		wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5' );
		wp_enqueue_style( 'fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.css', array(), '1.0.5' );
		wp_enqueue_style( 'fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.css', array(), '1.0.7' );
		
		//Superfish
		wp_enqueue_script( 'superfish-js', get_template_directory_uri() . '/js/superfish/superfish.min.js', array('jquery'), '1.3.15', true );
		
		//Add Shuffle js
		wp_enqueue_script( 'modernizr-js', get_template_directory_uri() . '/js/modernizr.custom.min.js', array('jquery'), '2.6.2', true );
		wp_enqueue_script( 'shuffle-js', get_template_directory_uri() . '/js/jquery.shuffle.min.js', array('jquery'), '3.0.0', true );

		//Add mousewheel
		wp_enqueue_script( 'mousewheel-js', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array('jquery'), '3.1.12', true );
		
		// Add jQuery countdown file
		wp_enqueue_script( 'countdown-js', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '2.0.4', true );
		
		//Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions.
		wp_enqueue_script( 'html5-js', get_template_directory_uri() . '/js/html5.js', array(), '3.7.0', true );
		$wp_scripts->add_data( 'html5-js', 'conditional', 'lt IE 9' );
		
		// Add theme.js file
		wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/js/theme.js', array('jquery'), '20140826', true );

		$font_url = $this->hugeshop_get_font_url();
		if ( ! empty( $font_url ) )
			wp_enqueue_style( 'roadthemes-fonts', esc_url_raw( $font_url ), array(), null );

		// Loads our main stylesheet.
		wp_enqueue_style( 'roadthemes-style', get_stylesheet_uri() );
		
		// Mega Main Menu
		wp_enqueue_style( 'megamenu-css', get_template_directory_uri() . '/css/megamenu_style.css', array(), '2.0.4' );
	
		// Load fontawesome css
		wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.2.0' );

		// Load Simple-Line-Icons css
		wp_enqueue_style( 'simple-line-css', get_template_directory_uri() . '/css/simple-line-icons.css', array(), '2.2.2' );
		
		// Load bootstrap css
		wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.2.0' );
		
		// Compile Less to CSS
		$previewpreset = (isset($_REQUEST['preset']) ? $_REQUEST['preset'] : null);
			//get preset from url (only for demo/preview)
		if($previewpreset){
			$_SESSION["preset"] = $previewpreset;
		}
		$presetopt = 1;
		if(!isset($_SESSION["preset"])){
			$_SESSION["preset"] = 1;
		}
		if($_SESSION["preset"] != 1) {
			$presetopt = $_SESSION["preset"];
		} else { /* if no preset varialbe found in url, use from theme options */
			if(isset($hugeshop_opt['preset_option'])){
				$presetopt = $hugeshop_opt['preset_option'];
			}
		}
		if(!isset($presetopt)) $presetopt = 1; /* in case first time install theme, no options found */
		
		if(isset($hugeshop_opt['enable_less'])){
			if($hugeshop_opt['enable_less']){
				$themevariables = array(
					'body_font'=> $hugeshop_opt['bodyfont']['font-family'],
					'text_color'=> $hugeshop_opt['bodyfont']['color'],
					'text_selected_bg' => $hugeshop_opt['text_selected_bg'],
					'text_selected_color' => $hugeshop_opt['text_selected_color'],
					'text_size'=> $hugeshop_opt['bodyfont']['font-size'],
					
					'heading_font'=> $hugeshop_opt['headingfont']['font-family'],
					'heading_color'=> $hugeshop_opt['headingfont']['color'],
					'heading_font_weight'=> $hugeshop_opt['headingfont']['font-weight'],
					
					'menu_font'=> $hugeshop_opt['menufont']['font-family'],
					'menu_color'=> $hugeshop_opt['menufont']['color'],
					'menu_font_size'=> $hugeshop_opt['menufont']['font-size'],
					'menu_font_weight'=> $hugeshop_opt['menufont']['font-weight'],
					'sub_menu_bg' => $hugeshop_opt['sub_menu_bg'],
					'sub_menu_color' => $hugeshop_opt['sub_menu_color'],
					
					'link_color' => $hugeshop_opt['link_color']['regular'],
					'link_hover_color' => $hugeshop_opt['link_color']['hover'],
					'link_active_color' => $hugeshop_opt['link_color']['active'],
					
					'primary_color' => $hugeshop_opt['primary_color'],
					
					'sale_color' => $hugeshop_opt['sale_color'],
					'saletext_color' => $hugeshop_opt['saletext_color'],
					'rate_color' => $hugeshop_opt['rate_color'],

					'header_color' => $hugeshop_opt['header_color'],
					'header_link_color' => $hugeshop_opt['header_link_color']['regular'],
					'header_link_hover_color' => $hugeshop_opt['header_link_color']['hover'],
					'header_link_active_color' => $hugeshop_opt['header_link_color']['active'],
					
					
					'footer_color' => $hugeshop_opt['footer_color'],
					'footer_link_color' => $hugeshop_opt['footer_link_color']['regular'],
					'footer_link_hover_color' => $hugeshop_opt['footer_link_color']['hover'],
					'footer_link_active_color' => $hugeshop_opt['footer_link_color']['active'],
				);
				if(isset($hugeshop_opt['header_bg']['background-color']) && $hugeshop_opt['header_bg']['background-color']!="") {
					$themevariables['header_bg'] = $hugeshop_opt['header_bg']['background-color'];
				} else {
					$themevariables['header_bg'] = 'transparent';
				}
				if(isset($hugeshop_opt['header_sticky_bg']['rgba']) && $hugeshop_opt['header_sticky_bg']['rgba']!="") {
					$themevariables['header_sticky_bg'] = $hugeshop_opt['header_sticky_bg']['rgba'];
				} else {
					$themevariables['header_sticky_bg'] = '#fff';
				}
				if(isset($hugeshop_opt['footer_bg']['background-color']) && $hugeshop_opt['footer_bg']['background-color']!="") {
					$themevariables['footer_bg'] = $hugeshop_opt['footer_bg']['background-color'];
				} else {
					$themevariables['footer_bg'] = 'transparent';
				}
				switch ($presetopt) {
					case 2:
						$themevariables['primary_color'] = '#5ED9E7';
						$themevariables['sale_color'] = '#5ED9E7';
					break;
					case 3:
						$themevariables['primary_color'] = '#D95380';
						$themevariables['sale_color'] = '#D95380';
					break;
					case 4:
						$themevariables['primary_color'] = '#FFB548';
						$themevariables['sale_color'] = '#FFB548';
					break;
					case 5:
						$themevariables['primary_color'] = '#3ACF87';
						$themevariables['sale_color'] = '#3ACF87';
					break;
					case 6:
						$themevariables['primary_color'] = '#DB6163';
						$themevariables['sale_color'] = '#DB6163';
					break;
				}

				if(function_exists('compileLessFile')){
					compileLessFile('reset.less', 'reset'.$presetopt.'.css', $themevariables);
					compileLessFile('global.less', 'global'.$presetopt.'.css', $themevariables);
					compileLessFile('pages.less', 'pages'.$presetopt.'.css', $themevariables);
					compileLessFile('woocommerce.less', 'woocommerce'.$presetopt.'.css', $themevariables);
					compileLessFile('portfolio.less', 'portfolio'.$presetopt.'.css', $themevariables);
					compileLessFile('layouts.less', 'layouts'.$presetopt.'.css', $themevariables);
					compileLessFile('responsive.less', 'responsive'.$presetopt.'.css', $themevariables);
					compileLessFile('ie.less', 'ie'.$presetopt.'.css', $themevariables);
				}
			}
		}
		
		// Load main theme css style files
		wp_enqueue_style( 'hugeshopcss-reset', get_template_directory_uri() . '/css/reset'.$presetopt.'.css', array('bootstrap-css'), '1.0.0' );
		wp_enqueue_style( 'hugeshopcss-global', get_template_directory_uri() . '/css/global'.$presetopt.'.css', array('hugeshopcss-reset'), '1.0.0' );
		wp_enqueue_style( 'hugeshopcss-pages', get_template_directory_uri() . '/css/pages'.$presetopt.'.css', array('hugeshopcss-global'), '1.0.0' );
		wp_enqueue_style( 'hugeshopcss-woocommerce', get_template_directory_uri() . '/css/woocommerce'.$presetopt.'.css', array('hugeshopcss-pages'), '1.0.0' );
		wp_enqueue_style( 'hugeshopcss-portfolio', get_template_directory_uri() . '/css/portfolio'.$presetopt.'.css', array('hugeshopcss-woocommerce'), '1.0.0' );
		wp_enqueue_style( 'hugeshopcss-layouts', get_template_directory_uri() . '/css/layouts'.$presetopt.'.css', array('hugeshopcss-portfolio'), '1.0.0' );
		wp_enqueue_style( 'hugeshopcss-responsive', get_template_directory_uri() . '/css/responsive'.$presetopt.'.css', array('hugeshopcss-layouts'), '1.0.0' );
		
		// Loads the Internet Explorer specific stylesheet.
		wp_enqueue_style( 'hugeshopcss-ie', get_template_directory_uri() . '/css/ie'.$presetopt.'.css', array( 'hugeshopcss-style' ), '20121010' );
		$wp_styles->add_data( 'hugeshopcss-ie', 'conditional', 'lte IE 9' );
		
		if(isset($hugeshop_opt['enable_sswitcher'])){
			if($hugeshop_opt['enable_sswitcher']){
				// Add styleswitcher.js file
				wp_enqueue_script( 'styleswitcher-js', get_template_directory_uri() . '/js/styleswitcher.js', array(), '20140826', true );
				// Load styleswitcher css style
				wp_enqueue_style( 'styleswitcher-css', get_template_directory_uri() . '/css/styleswitcher.css', array(), '1.0.0' );
				// Load scroll bar js
				wp_enqueue_script( 'scrollbar-js', get_template_directory_uri() . '/js/jquery.scrollbar.min.js', array('jquery'), '0.2.8', true );
				wp_enqueue_style( 'scrollbar-css', get_template_directory_uri() . '/css/scrollbar.css', array(), '1.0.0' );
			}
		}
	}
	//add custom css, sharing code to header
	function hugeshop_custom_code_header() {
		global $hugeshop_opt;

		if ( isset($hugeshop_opt['share_head_code']) && $hugeshop_opt['share_head_code']!='') {
			echo wp_kses($hugeshop_opt['share_head_code'], array(
				'script' => array(
					'type' => array(),
					'src' => array(),
					'async' => array()
				),
			));
		}
		if ( isset($hugeshop_opt['custom_css']) && $hugeshop_opt['custom_css']!='') { ?>
			<style><?php echo esc_html($hugeshop_opt['custom_css']); ?></style>
		<?php } ?>
		<script type="text/javascript">
		var hugeshop_brandnumber = <?php if(isset($hugeshop_opt['brandnumber'])) { echo esc_js($hugeshop_opt['brandnumber']); } else { echo '6'; } ?>,
			hugeshop_brandscrollnumber = <?php if(isset($hugeshop_opt['brandscrollnumber'])) { echo esc_js($hugeshop_opt['brandscrollnumber']); } else { echo '2';} ?>,
			hugeshop_brandpause = <?php if(isset($hugeshop_opt['brandpause'])) { echo esc_js($hugeshop_opt['brandpause']); } else { echo '3000'; } ?>,
			hugeshop_brandanimate = <?php if(isset($hugeshop_opt['brandanimate'])) { echo esc_js($hugeshop_opt['brandanimate']); } else { echo '700';} ?>;
		var hugeshop_brandscroll = 'false';
			<?php if(isset($hugeshop_opt['brandscroll'])){ ?>
				hugeshop_brandscroll = <?php echo esc_js($hugeshop_opt['brandscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var hugeshop_categoriesnumber = <?php if(isset($hugeshop_opt['categoriesnumber'])) { echo esc_js($hugeshop_opt['categoriesnumber']); } else { echo '6'; } ?>,
			hugeshop_categoriesscrollnumber = <?php if(isset($hugeshop_opt['categoriesscrollnumber'])) { echo esc_js($hugeshop_opt['categoriesscrollnumber']); } else { echo '2';} ?>,
			hugeshop_categoriespause = <?php if(isset($hugeshop_opt['categoriespause'])) { echo esc_js($hugeshop_opt['categoriespause']); } else { echo '3000'; } ?>,
			hugeshop_categoriesanimate = <?php if(isset($hugeshop_opt['categoriesanimate'])) { echo esc_js($hugeshop_opt['categoriesanimate']); } else { echo '700';} ?>;
		var hugeshop_categoriesscroll = 'false';
			<?php if(isset($hugeshop_opt['categoriesscroll'])){ ?>
				hugeshop_categoriesscroll = <?php echo esc_js($hugeshop_opt['categoriesscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var hugeshop_blogpause = <?php if(isset($hugeshop_opt['blogpause'])) { echo esc_js($hugeshop_opt['blogpause']); } else { echo '3000'; } ?>,
			hugeshop_bloganimate = <?php if(isset($hugeshop_opt['bloganimate'])) { echo esc_js($hugeshop_opt['bloganimate']); } else { echo '700'; } ?>;
		var hugeshop_blogscroll = 'false';
			<?php if(isset($hugeshop_opt['blogscroll'])){ ?>
				hugeshop_blogscroll = <?php echo esc_js($hugeshop_opt['blogscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var hugeshop_testipause = <?php if(isset($hugeshop_opt['testipause'])) { echo esc_js($hugeshop_opt['testipause']); } else { echo '3000'; } ?>,
			hugeshop_testianimate = <?php if(isset($hugeshop_opt['testianimate'])) { echo esc_js($hugeshop_opt['testianimate']); } else { echo '700'; } ?>;
		var hugeshop_testiscroll = 'false';
			<?php if(isset($hugeshop_opt['testiscroll'])){ ?>
				hugeshop_testiscroll = <?php echo esc_js($hugeshop_opt['testiscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var hugeshop_catenumber = <?php if(isset($hugeshop_opt['catenumber'])) { echo esc_js($hugeshop_opt['catenumber']); } else { echo '6'; } ?>,
			hugeshop_catescrollnumber = <?php if(isset($hugeshop_opt['catescrollnumber'])) { echo esc_js($hugeshop_opt['catescrollnumber']); } else { echo '2';} ?>,
			hugeshop_catepause = <?php if(isset($hugeshop_opt['catepause'])) { echo esc_js($hugeshop_opt['catepause']); } else { echo '3000'; } ?>,
			hugeshop_cateanimate = <?php if(isset($hugeshop_opt['cateanimate'])) { echo esc_js($hugeshop_opt['cateanimate']); } else { echo '700';} ?>;
		var hugeshop_catescroll = 'false';
			<?php if(isset($hugeshop_opt['catescroll'])){ ?>
				hugeshop_catescroll = <?php echo esc_js($hugeshop_opt['catescroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var hugeshop_menu_number = <?php if(isset($hugeshop_opt['categories_menu_items'])) { echo esc_js((int)$hugeshop_opt['categories_menu_items']+1); } else { echo '9';} ?>;
		var hugeshop_sticky_header = 'false';
			<?php if(isset($hugeshop_opt['sticky_header'])){ ?>
				hugeshop_sticky_header = <?php echo esc_js($hugeshop_opt['sticky_header'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		</script>
		<?php
	}
	/**
	 * Register sidebars.
	 *
	 * Registers our main widget area and the front page widget areas.
	 *
	 * @since Huge Shop 1.0
	 */
	function hugeshop_widgets_init() {
		register_sidebar( array(
			'name' => esc_html__( 'Blog Sidebar', 'hugeshop' ),
			'id' => 'sidebar-1',
			'description' => esc_html__( 'Sidebar on blog page', 'hugeshop' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		
		register_sidebar( array(
			'name' => esc_html__( 'Shop Sidebar', 'hugeshop' ),
			'id' => 'sidebar-shop',
			'description' => esc_html__( 'Sidebar on shop page (only sidebar shop layout)', 'hugeshop' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Pages Sidebar', 'hugeshop' ),
			'id' => 'sidebar-page',
			'description' => esc_html__( 'Sidebar on content pages', 'hugeshop' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		
		register_sidebar( array(
			'name' => esc_html__( 'Home Sidebar', 'hugeshop' ),
			'id' => 'sidebar-home',
			'description' => esc_html__( 'Sidebar on home page 5', 'hugeshop' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Home Sidebar 6', 'hugeshop' ),
			'id' => 'sidebar-home6',
			'description' => esc_html__( 'Sidebar on home page 6', 'hugeshop' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
	}
	function hugeshop_meta_box_callback( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'hugeshop_meta_box', 'hugeshop_meta_box_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, '_hugeshop_meta_value_key', true );

		echo '<label for="hugeshop_post_intro">';
		_e( 'This content will be used to replace the featured image, use shortcode here', 'hugeshop' );
		echo '</label><br />';
		//echo '<textarea id="hugeshop_post_intro" name="hugeshop_post_intro" rows="5" cols="50" />' . esc_attr( $value ) . '</textarea>';
		wp_editor( $value, 'hugeshop_post_intro', $settings = array() );
		
		
	}
	function hugeshop_add_meta_box() {

		$screens = array( 'post' );

		foreach ( $screens as $screen ) {

			add_meta_box(
				'hugeshop_post_intro_section',
				__( 'Post featured content', 'hugeshop' ),
				'HugeShop::hugeshop_meta_box_callback',
				$screen
			);
		}
	}
	function hugeshop_save_meta_box_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['hugeshop_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['hugeshop_meta_box_nonce'], 'hugeshop_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		if ( ! isset( $_POST['hugeshop_post_intro'] ) ) {
			return;
		}

		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hugeshop_post_intro'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_hugeshop_meta_value_key', $my_data );
	}
	//Change comment form
	function hugeshop_before_comment_fields() {
		echo '<div class="comment-input">';
	}
	function hugeshop_after_comment_fields() {
		echo '</div>';
	}
	/**
	 * Register postMessage support.
	 *
	 * Add postMessage support for site title and description for the Customizer.
	 *
	 * @since Huge Shop 1.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function hugeshop_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
	/**
	 * Enqueue Javascript postMessage handlers for the Customizer.
	 *
	 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
	 *
	 * @since Huge Shop 1.0
	 */
	function hugeshop_customize_preview_js() {
		wp_enqueue_script( 'roadthemes-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
	}
	// Remove Redux Ads
	function hugeshop_remove_redux_ads() { ?>
	<style type="text/css">
	.rAds, .redux-messageredux-notice {
		display: none !important;
	}
	</style>
	<?php
	}
	/**
	* Utility methods
	* ---------------
	*/
	
	//Add breadcrumbs
	static function hugeshop_breadcrumb() {
		global $post, $hugeshop_opt;
		
		$brseparator = '<span class="separator">/</span>';
		if (!is_home()) {
			echo '<div class="breadcrumbs">';
			
			echo '<a href="';
			echo esc_url( home_url( '/' ));
			echo '">';
			echo 'Trang chủ';
			echo '</a>'.$brseparator;
			if (is_category() || is_single()) {
				the_category($brseparator);
				if (is_single()) {
					echo ''.$brseparator;
					the_title();
				}
			} elseif (is_page()) {
				if($post->post_parent){
					$anc = get_post_ancestors( $post->ID );
					$title = get_the_title();
					foreach ( $anc as $ancestor ) {
						$output = '<a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a>'.$brseparator;
					}
					echo wp_kses($output, array(
							'a'=>array(
								'href' => array(),
								'title' => array()
							),
							'span'=>array(
								'class'=>array()
							)
						)
					);
					echo '<span title="'.$title.'"> '.$title.'</span>';
				} else {
					echo '<span> '.get_the_title().'</span>';
				}
			}
			elseif (is_tag()) {single_tag_title();}
			elseif (is_day()) {echo"<span>Archive for "; the_time('F jS, Y'); echo'</span>';}
			elseif (is_month()) {echo"<span>Archive for "; the_time('F, Y'); echo'</span>';}
			elseif (is_year()) {echo"<span>Archive for "; the_time('Y'); echo'</span>';}
			elseif (is_author()) {echo"<span>Author Archive"; echo'</span>';}
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>Blog Archives"; echo'</span>';}
			elseif (is_search()) {echo"<span>Search Results"; echo'</span>';}
			
			echo '</div>';
		} else {
			echo '<div class="breadcrumbs">';
			
			echo '<a href="';
			echo esc_url( home_url( '/' ) );
			echo '">';
			echo 'Trang chủ';
			echo '</a>'.$brseparator;
			
			if(isset($hugeshop_opt['blog_header_text']) && $hugeshop_opt['blog_header_text']!=""){
				echo esc_html($hugeshop_opt['blog_header_text']);
			} else {
				echo 'Blog';
			}
			
			echo '</div>';
		}
	}
	static function hugeshop_limitStringByWord ($string, $maxlength, $suffix = '') {

		if(function_exists( 'mb_strlen' )) {
			// use multibyte functions by Iysov
			if(mb_strlen( $string )<=$maxlength) return $string;
			$string = mb_substr( $string, 0, $maxlength );
			$index = mb_strrpos( $string, ' ' );
			if($index === FALSE) {
				return $string;
			} else {
				return mb_substr( $string, 0, $index ).$suffix;
			}
		} else { // original code here
			if(strlen( $string )<=$maxlength) return $string;
			$string = substr( $string, 0, $maxlength );
			$index = strrpos( $string, ' ' );
			if($index === FALSE) {
				return $string;
			} else {
				return substr( $string, 0, $index ).$suffix;
			}
		}
	}
	static function hugeshop_excerpt_by_id($post, $length = 10, $tags = '<a><em><strong>') {
 
		if(is_int($post)) {
			// get the post object of the passed ID
			$post = get_post($post);
		} elseif(!is_object($post)) {
			return false;
		}
	 
		if(has_excerpt($post->ID)) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters('the_content', $the_excerpt);
		} else {
			$the_excerpt = $post->post_content;
		}
	 
		$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
		$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
		$excerpt_waste = array_pop($the_excerpt);
		$the_excerpt = implode($the_excerpt);
	 
		return apply_filters('the_content', $the_excerpt);
	}
	/**
	 * Return the Google font stylesheet URL if available.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * @since Huge Shop 1.2
	 *
	 * @return string Font stylesheet or empty string if disabled.
	 */
	function hugeshop_get_font_url() {
		$font_url = '';

		/* translators: If there are characters in your language that are not supported
		 * by Open Sans, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'hugeshop' ) ) {
			$subsets = 'latin,latin-ext';

			/* translators: To add an additional Open Sans character subset specific to your language,
			 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
			 */
			$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'hugeshop' );

			if ( 'cyrillic' == $subset )
				$subsets .= ',cyrillic,cyrillic-ext';
			elseif ( 'greek' == $subset )
				$subsets .= ',greek,greek-ext';
			elseif ( 'vietnamese' == $subset )
				$subsets .= ',vietnamese';

			$protocol = is_ssl() ? 'https' : 'http';
			$query_args = array(
				'family' => 'Open+Sans:400italic,700italic,400,700',
				'subset' => $subsets,
			);
			$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
		}

		return $font_url;
	}
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Huge Shop 1.0
	 */
	static function hugeshop_content_nav( $html_id ) {
		global $wp_query;

		$html_id = esc_attr( $html_id );

		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo esc_attr($html_id); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'hugeshop' ); ?></h3>
				<div class="nav-previous"><?php next_posts_link( wp_kses(__( '<span class="meta-nav">&larr;</span> Older posts', 'hugeshop' ),array('span'=>array('class'=>array())) )); ?></div>
				<div class="nav-next"><?php previous_posts_link( wp_kses(__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'hugeshop' ), array('span'=>array('class'=>array())) )); ?></div>
			</nav>
		<?php endif;
	}
	/* Pagination */
	static function hugeshop_pagination() {
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'prev_text'    => esc_html__('Previous', 'hugeshop'),
			'next_text'    =>esc_html__('Next', 'hugeshop'),
		) );
	}
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own hugeshop_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Huge Shop 1.0
	 */
	static function hugeshop_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'hugeshop' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'hugeshop' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</div>
				<div class="comment-info">
					<header class="comment-meta comment-author vcard">
						<?php
							
							printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'hugeshop' ) . '</span>' : ''
							);
							printf( '<time datetime="%1$s">%2$s</time>',
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( esc_html__( '%1$s at %2$s', 'hugeshop' ), get_comment_date(), get_comment_time() )
							);
						?>
						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'hugeshop' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->
					</header><!-- .comment-meta -->
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'hugeshop' ); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'hugeshop' ), '<p class="edit-link">', '</p>' ); ?>
					</section><!-- .comment-content -->
				</div>
			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
	}
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own hugeshop_entry_meta() to override in a child theme.
	 *
	 * @since Huge Shop 1.0
	 */
	static function hugeshop_entry_meta() {
		
		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', ', ' );

		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = esc_html__('0 comments', 'hugeshop');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . esc_html__(' comments', 'hugeshop');
			} else {
				$comments = esc_html__('1 comment', 'hugeshop');
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}

		$utility_text = esc_html__( '%1$s / Tags: %2$s', 'hugeshop' );

		printf( $utility_text, $write_comments, $tag_list);
	}
	static function hugeshop_entry_meta_small() {
		
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(', ');

		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( wp_kses(__( 'View all posts by %s', 'hugeshop' ), array('a'=>array())), get_the_author() ) ),
			get_the_author()
		);
		
		$utility_text = esc_html__( 'Posted by %1$s / %2$s', 'hugeshop' );

		printf( $utility_text, $author, $categories_list );
		
	}
	static function hugeshop_entry_comments() {
		
		$date = sprintf( '<time class="entry-date" datetime="%3$s">%4$s</time>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = wp_kses(__('<span>0</span> comments', 'hugeshop'), array('span'=>array()));
			} elseif ( $num_comments > 1 ) {
				$comments = '<span>'.$num_comments .'</span>'. esc_html__(' comments', 'hugeshop');
			} else {
				$comments = wp_kses(__('<span>1</span> comment', 'hugeshop'), array('span'=>array()));
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
		
		$utility_text = esc_html__( '%1$s', 'hugeshop' );
		
		printf( $utility_text, $write_comments );
	}
	/**
	* TGM-Plugin-Activation
	*/
	function hugeshop_register_required_plugins() {

		$plugins = array(
			array(
				'name'               => 'Hugeshop Helper',
				'slug'               => 'hugeshop-helper',
				'source'             => get_template_directory() . '/plugins/hugeshop-helper.zip',
				'required'           => true,
				'version'            => '1.0.0',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			// Plugins from the WordPress Plugin Repository.
			array(
				'name'               => 'Redux Framework',
				'slug'               => 'redux-framework',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'required'  => true,
			),
			array(
				'name'      => 'MailPoet Newsletters',
				'slug'      => 'wysija-newsletters',
				'required'  => true,
			),
			array(
				'name'      => 'Projects',
				'slug'      => 'projects-by-woothemes',
				'required'  => false,
			),
			array(
				'name'      => 'Shortcodes Ultimate',
				'slug'      => 'shortcodes-ultimate',
				'required'  => true,
			),
			array(
				'name'      => 'Simple Local Avatars',
				'slug'      => 'simple-local-avatars',
				'required'  => false,
			),
			array(
				'name'      => 'Testimonials',
				'slug'      => 'testimonials-by-woothemes',
				'required'  => true,
			),
			array(
				'name'      => 'TinyMCE Advanced',
				'slug'      => 'tinymce-advanced',
				'required'  => false,
			),
			array(
				'name'      => 'Widget Importer & Exporter',
				'slug'      => 'widget-importer-exporter',
				'required'  => false,
			),
			array(
				'name'      => 'WooCommerce',
				'slug'      => 'woocommerce',
				'required'  => true,
			),
			array(
				'name'      => 'YITH WooCommerce Compare',
				'slug'      => 'yith-woocommerce-compare',
				'required'  => false,
			),
			array(
				'name'      => 'YITH WooCommerce Wishlist',
				'slug'      => 'yith-woocommerce-wishlist',
				'required'  => false,
			),
			array(
				'name'      => 'YITH WooCommerce Zoom Magnifier',
				'slug'      => 'yith-woocommerce-zoom-magnifier',
				'required'  => false,
			),
		);

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'hugeshop' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'hugeshop' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'hugeshop' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'hugeshop' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'hugeshop' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'hugeshop' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'hugeshop' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'hugeshop' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'hugeshop' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'hugeshop' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'hugeshop' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);

		tgmpa( $plugins, $config );

	}
}

// Instantiate theme
$hugeshop = new HugeShop();

//Fix duplicate id of mega menu
function hugeshop_mega_menu_id_change($params) {
	ob_start('hugeshop_mega_menu_id_change_call_back');
}
function hugeshop_mega_menu_id_change_call_back($html){
	$html = preg_replace('/id="mega_main_menu"/', 'id="mega_main_menu_first"', $html, 1);
	$html = preg_replace('/id="mega_main_menu_ul"/', 'id="mega_main_menu_ul_first"', $html, 1);
	
	return $html;
}
add_action('wp_loaded', 'hugeshop_mega_menu_id_change');
