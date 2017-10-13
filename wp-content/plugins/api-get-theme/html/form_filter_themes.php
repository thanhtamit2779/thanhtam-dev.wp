<div class="col-md-3 col-sm-6">
    <div class="form-group select">
       <div id="_colletion">
          <select name="collection_id" id="collection_id" class="form-control select">
             <option value="" selected="selected">Chọn ngành nghề</option>
             <?php 
                 // Category
                 //$categories  = wp_cache_get('category');
                 if(FALSE == $categories)
                 {
                    //$get_categories = Requests::request(THEME_WEBDOCTOR_VN_URL . 'api/category/list') ;
                    $get_categories = Requests::request(THEME_WEBDOCTOR_VN_URL . 'category/list') ;
                    $get_categories = json_decode($get_categories->body) ;
                    if($get_categories->status == 1) 
                    {
                        wp_cache_set('category', $get_categories->data, '', 300);
                        $categories  = wp_cache_get('category');
                    }
                 }

                 if(!empty($categories)) : ?>
                    <?php foreach ($categories as $cate_id => $cate_name) : ?>
                       <option value="<?php echo $cate_id ;?>"><?php echo $cate_name ;?></option>
                    <?php endforeach; ?>
                 <?php endif ; ?>   
          </select>
          <div class="carets"><i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></div>
       </div>
    </div>
</div>
<div class="col-md-4 col-sm-6">
  <div class="form-group search" id="search">
     <input type="text" name="search" value="" class="form-control input-lg" placeholder="Nhập từ khóa...">
     <img class="btnFilter" id="btn-search" src="<?php bloginfo('template_directory'); ?>/landing-page/webdoctor/images/search.png" alt="tim-kiem" title="Tìm kiếm" />          
  </div>
</div>