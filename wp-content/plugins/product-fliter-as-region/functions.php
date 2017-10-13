<?php 

// Tạo taxonomy vùng miền trong bài viết tại trang admin
if(!function_exists('created_region')) {
    function created_region() {   
        /* Biến $label chứa các tham số thiết lập tên hiển thị của Taxonomy
         */
        $labels = array(
                'name'        => 'Tỉnh-Thành, Quận-Huyện',
                'singular'    => 'S-Tỉnh-Thành',
                'menu_name'   => 'Menu-Tỉnh-Thành'
        );
 
        /* Biến $args khai báo các tham số trong custom taxonomy cần tạo
         */
        $args = array(
                'labels'                     => $labels,
                'hierarchical'               => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
        );
 
        /* Hàm register_taxonomy để khởi tạo taxonomy */

        register_taxonomy('product-as-region', 'product', $args);    
    }
    add_action( 'init', 'created_region', 0 );
}

if( !function_exists('list_product_as_region') ) {
    function list_product_as_region($args) {
        $posts = new WP_Query($args);
        if ($posts->have_posts()) { ?>
            <?php do_action( 'woocommerce_before_shop_loop' ); ?>
                <?php woocommerce_product_loop_start(); ?>
                    <?php while ($posts->have_posts()): $posts->the_post(); ?>
                        <?php do_action( 'woocommerce_shop_loop' ); ?>
                        <li <?php post_class(); ?> data-current-page="<?php echo $args['paged'] ;?>" data-total-page="<?php echo $posts->max_num_pages;?>">
                            <?php
                            /**
                             * woocommerce_before_shop_loop_item hook.
                             *
                             * @hooked woocommerce_template_loop_product_link_open - 10
                             */
                            do_action( 'woocommerce_before_shop_loop_item' );

                            /**
                             * woocommerce_before_shop_loop_item_title hook.
                             *
                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                             */
                            do_action( 'woocommerce_before_shop_loop_item_title' );

                            /**
                             * woocommerce_shop_loop_item_title hook.
                             *
                             * @hooked woocommerce_template_loop_product_title - 10
                             */
                            do_action( 'woocommerce_shop_loop_item_title' );

                            /**
                             * woocommerce_after_shop_loop_item_title hook.
                             *
                             * @hooked woocommerce_template_loop_rating - 5
                             * @hooked woocommerce_template_loop_price - 10
                             */
                            do_action( 'woocommerce_after_shop_loop_item_title' );

                            /**
                             * woocommerce_after_shop_loop_item hook.
                             *
                             * @hooked woocommerce_template_loop_product_link_close - 5
                             * @hooked woocommerce_template_loop_add_to_cart - 10
                             */
                            do_action( 'woocommerce_after_shop_loop_item' );
                            ?>
                        </li>
                    <?php endwhile; // end of the loop. ?>
                <?php woocommerce_product_loop_end(); ?>
			<?php do_action( 'woocommerce_after_shop_loop' ); ?>
        <?php } 
    }
    add_action( 'init', 'list_product_as_region');
}