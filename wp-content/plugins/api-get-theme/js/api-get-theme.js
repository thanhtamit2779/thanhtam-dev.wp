var url = ajax_object.ajax_url;
var busy = false;
var page = 1;
var loader = jQuery("#load-template");
 
function ajax_load(options) {
    var args = {
        type       : 'post',
        dataType   : 'json',
    };
    var options = jQuery.extend(args, options);
    return jQuery.ajax(options);
}

function filter_theme(page) {
    var collection_id = jQuery('#collection_id').find(':selected').val();
    var search        = jQuery('#search :input').val();

    if (collection_id == '' && search == '') return false;
    if (collection_id == null && search == null) return false;

    jQuery.ajax({
        url                 : url,
        type                : 'get',
        dataType            : 'html',
        data: {
            action          : 'get_themes_filter',
            collection_id   : collection_id,
            search          : search,
            orderby         : 'post_title',
            order           : 'asc',
            total_record    : 4,
            page: page,

        },
        beforeSend  : function() {
            loader.gSpinner({
                'scale': 0.8
            });
        }
    }).done(function(data) {
        loader.gSpinner("hide");
        if (data == null || data == '') return false;
        jQuery('#filter-themes').append(data);
        jQuery('.product_detail .service-overlay_a ul').addClass('product service-overlay');
        jQuery('ul.service-overlay li:last-child').addClass('final');
        window.busy = false;
    })
    return false;
}

jQuery(document).ready(function() {

    // Form
    jQuery('#btn-formt-submit').on('click', function() {
        jQuery('#contact_form form').submit();
    });

    // Tim kiem
    jQuery("#btn-search").click(function() {
        var collection_id = jQuery('#collection_id').find(':selected').val();
        var search = jQuery('#search :input').val();

        if (collection_id == '' && search == '') return false;
        if (collection_id == null && search == null) return false;

        page = 1;
        jQuery('#load-template').removeAttr('id').attr('id', 'filter-themes');
        jQuery('#filter-themes').empty();
        filter_theme(1);
    });

    // Nhap tu khoa tim kiem va enter
    jQuery('#search :input').keypress(function(event) {
        if (event.which == 13) {
            jQuery("#btn-search").trigger('click');
        }
    });

    // // Chon danh muc => hien thi theme
    // jQuery('#collection_id').on('change', function(e) {
    //     var collection_id = jQuery('#collection_id').find(':selected').val();
    //     if (collection_id == '') return false;
    //     if (collection_id == null) return false;
    //     jQuery("#btn-search").trigger('click');
    // });

    // Phan trang khi cuon chuot
    page = 1;
    jQuery(window).scroll(function() {
        var number_page = jQuery('#filter-themes .product_detail:last-child').data('current-page');
        var total_page = jQuery('#filter-themes .product_detail:last-child').data('total-page');
        if (jQuery(window).scrollTop() + jQuery(window).height() > jQuery('#filter-themes').height() && !busy) {
            if (number_page < total_page) {
                busy = true;
                page = page + 1;
                filter_theme(page);
            }
        }
    });
});