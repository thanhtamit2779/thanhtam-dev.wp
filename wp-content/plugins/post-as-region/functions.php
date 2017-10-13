<?php 

// Tạo taxonomy vùng miền trong bài viết tại trang admin
if(!function_exists('tao_taxonomy')) {
    function tao_taxonomy() {   
        /* Biến $label chứa các tham số thiết lập tên hiển thị của Taxonomy
         */
        $labels = array(
                'name' => 'Tên vùng miền',
                'singular' => 'Vùng miền',
                'menu_name' => 'Vùng miền'
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
 
        /* Hàm register_taxonomy để khởi tạo taxonomy
         */

        register_taxonomy('vung-mien', 'post', $args);    
    }
    add_action( 'init', 'tao_taxonomy', 0 );
}

if( !function_exists('list_posts_as_region') ) {
    function list_posts_as_region($args) {
        $posts = new WP_Query($args);
        if ($posts->have_posts()) { ?>
            <?php while ($posts->have_posts()): $posts->the_post(); ?>
                <?php get_template_part( 'post', 'col3' ); ?>
            <?php endwhile; ?>
        <?php } 
    }
    add_action( 'init', 'list_posts_as_region');
}