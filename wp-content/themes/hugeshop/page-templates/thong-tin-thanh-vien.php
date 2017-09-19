<?php
/**
 * Template Name: USER INFO LIST
 *
 * Description: Hiển thị thông tin danh sách thành viên
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
		<div class="">
			<div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo do_shortcode( '[user-meta-profile form="user_info"]' ); ?> 
                    </div>
                    <div class="col-sm-6">
                        <?php echo do_shortcode( '[user-meta-registration form="user_info"]' ) ;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h3>THÔNG TIN USER</h3>
                        <?php 
                        global $wp_country;
                    
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
                                            <th>Company</th>
                                            <th>Country</th>
                                            <th>City</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($get_users as $user) : ?>
                                            <?php
                                                $user_id            = $user->ID ;
                                                $user_name          = $user->display_name ;
                                                $website            = $user->user_url;
                                                $country_code       = get_user_meta($user_id, 'usermeta_country', true) ;
                                                $country_name       = empty($wp_country->name($country_code)) ? $country_code : $wp_country->name($country_code) ;
                                
                                                $commpany           = get_user_meta($user_id, 'usermeta_company', true);
                                                $country            = $country_name;
                                                $city               = get_user_meta($user_id, 'usermeta_city', true);
                                            ?>
                                            <tr>
                                                <td><?php echo $user_name; ?></td>
                                                <td><?php echo $website; ?></td>
                                                <td><?php echo $commpany; ?></td>
                                                <td><?php echo $country; ?></td>
                                                <td><?php echo $city; ?></td>
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
                                                <!--<th>Company</th>
                                                <th>Country</th>
                                                <th>City</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($get_users as $user) : ?>
                                                <?php
                                                    $user_id            = $user->ID ;
                                                    $user_name          = $user->display_name ;
                                                    $website            = $user->user_url;
                                                    // $country_code       = get_user_meta($user_id, 'usermeta_country', true) ;
                                                    // $country_name       = empty($wp_country->name($country_code)) ? $country_code : $wp_country->name($country_code) ;
                                    
                                                    // $commpany           = get_user_meta($user_id, 'usermeta_company', true);
                                                    // $country            = $country_name;
                                                    // $city               = get_user_meta($user_id, 'usermeta_city', true);
                                                ?>
                                                <tr>
                                                    <td><?php echo $user_name; ?></td>
                                                    <td><?php echo $website; ?></td>
                                                    <!--<td><?php //echo $commpany; ?></td>
                                                    <td><?php //echo $country; ?></td>
                                                    <td><?php //echo $city; ?></td>-->
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
                                                    'format' => '?paged=%#%',
                                                    'current' => get_query_var('paged'),
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