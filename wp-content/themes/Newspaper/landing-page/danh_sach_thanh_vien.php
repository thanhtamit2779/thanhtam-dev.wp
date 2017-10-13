<?php
/**
 * Template Name: DANH SÁCH THÀNH VIÊN
 *
 * Description: Hiển thị thông tin danh sách thành viên
 */
get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>THÔNG TIN USER</h3>
            <?php 
            $paged    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

            $limit    = get_option('posts_per_page') ;
            $offset   = $limit * ($paged - 1);

            $is_login = is_user_logged_in();

            $args     = array(
            'number'       => $limit,
            'offset'       => $offset,
            'paged'        => $paged,
            'role__in'     => array('subscriber'),
            'orderby'      => 'nicename',
            'order'        => 'ASC',
            'fields'       => array('ID', 'user_url', 'user_login', 'user_email', 'user_url', 'display_name')
                ); 
            $get_users         = new WP_User_Query( $args );
            $total_user        = $get_users->get_total();
            $get_users         = $get_users->get_results();  

            $total_pages       = ceil($total_user / $limit);
                                    
            if( !empty($get_users) ) : ?>
                <?php if(TRUE === $is_login) :?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Website</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($get_users as $user) : ?>
                                <?php
                                    $user_id            = $user->ID ;
                                    $user_name          = $user->display_name ;
                                    $website            = $user->user_url;
                                ?>
                                <tr>
                                    <td><?php echo $user_name; ?></td>
                                    <td><?php echo $website; ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else :?>
                    <table class="table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Website</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($get_users as $user) : ?>
                                    <?php
                                        $user_id            = $user->ID ;
                                        $user_name          = $user->display_name ;
                                        $website            = $user->user_url;
                                    ?>
                                    <tr>
                                        <td><?php echo $user_name; ?></td>
                                        <td><?php echo $website; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                <?php endif ?>
            <?php endif ;?>

            <?php if($total_pages > 1) : ?> 
                <div class="text-center">
                    <ul class="pagination">
                        <?php 
                            echo paginate_links( 
                                    array(
                                        'base' 		  => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
                                        'prev_next'   => true,
                                        'format'      => '?paged=%#%',
                                        'current'     => get_query_var('paged'),
                                        'current'      => $paged,
                                        'total'  	   => $total_pages ,
                                    )
                                );
                        ?>
                    </ul>
                </div>    
            <?php endif ;?>
        </div> 
    </div>                
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('ul.pagination a').wrap( '<li></li>');

        jQuery('ul.pagination span.current').wrap( '<li class="disabled"><a href="#"></a></li>') ;
    }) ;
</script>
<?php get_footer(); ?>