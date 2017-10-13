var url  = ajax_object.ajax_url ; 
var busy = false;
var page = 1 ;

function append_data(selected, data, text = null, clean = true) {
	if(clean == true) jQuery(selected).empty();
	if( text != '' || text != null ) jQuery(selected).html(text);
	if(data.length == 0) return false;
	jQuery(selected).append(data) ;
	//return false;
}

function ajax_load(option) {
	return jQuery.ajax({
		url  		: option.url  ,
		data 		: option.data ,
		type 		: 'post' ,
		dataType    : 'html' ,
	});
}

function get_posts_as_filter(page) { // Load sản phẩm theo điều kiện              
	var region_id       = jQuery('#lct-widget-region').find(':selected').val() ;
	var city_id       	= jQuery('#lct-widget-city').find(':selected').val() ;
    var dictrict_id     = jQuery('#lct-widget-dictrict').find(':selected').val() ;

    ajax_load({
    	url : url, 
    	data 		: {
			action			: 'search_post_as_region',
            region_id 		: region_id ,
            city_id 		: city_id ,
            dictrict_id 	: dictrict_id ,
            page            : page
		}
    }).done(function(data) {
    	jQuery('#filter-post-as-region .td-block-row').append(data)
	    window.busy = false;
    });

    return false;
}

jQuery(document).ready(function() {	
	
	// Chọn vùng miền : gửi dữ liêu + load tỉnh , thành
	jQuery('#lct-widget-region').on('change', function(e) {		
		var region_id  = jQuery(this).find(':selected').val() ;		
		ajax_load({
			url   : url ,
			data  : {
						action		: 'get_city' ,
           	 			region_id	: region_id 
					}
		}).done(function(data) {
			append_data('#lct-widget-city', data, '<option value="-1">--- Chọn tỉnh, thành ---</option>');
		}) ;	
		return false;
	}) ;

	// Chọn tỉnh, thành : gửi dữ liêu + load quận huyện
	jQuery('#lct-widget-city').on('change', function(e) {
		var city_id  = jQuery(this).find(':selected').val() ;		
		ajax_load({
			url   : url ,
			data  : {
						action: 'get_dictrict',
                		city_id : city_id
					}
		}).done(function(data) {
			append_data('#lct-widget-dictrict', data, '<option value="-1">--- Chọn quận, huyện, thị xã ---</option>');
		}) ;
		return false;
	}) ;

	// Lọc theo vùng miền
	jQuery('#btn-search').on('click', function() {
		page = 1 ;
		// Làm sạch dữ liệu
		jQuery('#all-post-as-region .td-block-row').empty() ;
		jQuery('#all-post-as-region .td-row-load-more').remove() ;
		jQuery('#all-post-as-region').removeAttr('id').attr('id', 'filter-post-as-region') ;
		jQuery('#filter-post-as-region .td-block-row').empty() ;

		get_posts_as_filter(1) ;
	}) ;	

	page = 1 ;
	jQuery(window).scroll(function() {
      var number_page =  jQuery('#filter-post-as-region .td-block-row div.info-page:last-child').data('current-page');
      var total_page  = jQuery('#filter-post-as-region .td-block-row div.info-page:last-child').data('total-page');
      if (jQuery(window).scrollTop() + jQuery(window).height() >  jQuery('#filter-post-as-region .td-block-row').height() && !busy) {    		              		
            if(number_page < total_page) {
                busy = true;
                page = page + 1;
                get_posts_as_filter(page);
            }           
      }
	});
}) ;


