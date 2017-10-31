<div class="td-footer-wrapper td-container-wrap td-footer-template-9 <?php echo td_util::get_option('td_full_footer'); ?>">

    <div class="footer-menu">
        <div class="td-container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer-menu',
                'menu_class'=> 'td-subfooter-menu',
                'fallback_cb' => 'td_wp_footer_menu'
            ));

            //if no menu
            function td_wp_footer_menu() {
                //do nothing?
            }
            ?>
        </div>
    </div>
    <div class="td-container">
        <div class="td-pb-row">
            <div class="td-pb-span6">
                <?php
                td_global::vc_set_custom_column_number(1);
                dynamic_sidebar('Footer 1');
                ?>
            </div>

            <div class="td-pb-span3">
                <?php
                td_global::vc_set_custom_column_number(1);
                dynamic_sidebar('Footer 2');
                ?>
            </div>

            <div class="td-pb-span3">
                <?php
                td_global::vc_set_custom_column_number(1);
                dynamic_sidebar('Footer 3');
                ?>
            </div>

        </div>
    </div>
</div>