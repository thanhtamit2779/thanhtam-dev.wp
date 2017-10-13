<?php
/**
 * Template Name:BÀI VIẾT THEO VÙNG MIỀN
 * Description: HIỂN THỊ BÀI VIẾT THEO VÙNG MIỀN
 */
get_header();
?>
<div class="td-main-content-wrap">
   <div class="container">
      <!-- hiển thị select box để chọn post theo vùng miền --> 
      <div class="">
        <?php echo do_shortcode('[display_region_form]'); ?>
      </div>
      <!-- hiển thị tất cả bài viết theo vùng miền -->

      <br/>
      <div id="all-post-as-region">
         <div class="td-block-row">
            <div class="row">
               <?php
                  $taxonomy_ids   = array();
                  $get_terms_args  = array('parent' => 0) ;
                  $tax_terms       = get_terms('vung-mien', $get_terms_args ); 
                  if( $tax_terms ){
                    foreach( $tax_terms  as $tax_term ){
                        $taxonomy_ids[] = $tax_term->term_id ;
                    }
                  }
                  
                  $page = max( 1, absint( get_query_var( 'paged' ) ) );

                  
                  $args  = array(
                      'post_type'         => 'post',
                      'post_status'       => 'publish',
                      'posts_per_page'    => get_option('posts_per_page') ,
                      'paged'             => $page,
                      'meta_query' => array(    
                              'relation' => 'OR',           
                              array(
                                  'key' => '_is_featured',
                                  'value' => 'yes',
                                  'compare' => '=',
                              ),
                              array(
                                  'key' => '_is_featured',
                                  'value' => 'no',
                                  'compare' => '=',
                              ),
                              array(
                                  'key' => '_is_featured',
                                  'value' => 'yes',
                                  'compare' => 'NOT EXISTS',
                              )
                      ) ,
                      'orderby'     => array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'vung-mien',
                              'field' => 'term_id',
                              'operator' => 'IN',
                              'terms' => $taxonomy_ids
                          )
                      )
                  );
  
                  $posts = new WP_Query($args);
                  if ($posts->have_posts()) { ?>
                      <?php while ($posts->have_posts()): $posts->the_post(); ?>
                            <?php get_template_part( 'post', 'col3' ); ?>
                      <?php endwhile; ?>
                  <?php } ?>
            </div>
            <div class="clearfix">
               <style type="text/css">
                  .page-numbers {
                  display: inline-block;
                  padding: 5px 10px;
                  margin: 0 2px 0 0;
                  border: 1px solid #eee;
                  line-height: 1;
                  text-decoration: none;
                  border-radius: 2px;
                  font-weight: 600;
                  }
                  .page-numbers.current, a.page-numbers:hover {
                      background: #f9f9f9;
                  }
               </style>
               <?php 
                  if($posts->max_num_pages > 1) {
                    echo '<div class="pagination">';
                    echo paginate_links( array(
                      'base' 		  => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
                      'prev_next'     => true,
                      'format' 		  => '?page=%#%',
                      'end_size'      => 1,
                      'mid_size'      => 1,
                      'total'  		  => $posts->max_num_pages,  
                    ) );
                    echo '</div>' ;
                  }
                  ?>
            </div>
         </div>
         <!-- /.td-pb-row -->
      </div>
      <!-- all-post-as-region -->     
   </div>
   <!-- /.td-container -->
</div>
<!-- /.td-main-content-wrap -->
<?php get_footer(); ?>