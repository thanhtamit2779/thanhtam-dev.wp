<?php if(!empty($themes->themes)) : ?>
	<?php foreach ($themes->themes as $theme) : ?>
         <?php
			 $imageSource = $theme->post_thumb;
		     $image_alt   = sanitize_title(remove_accents($theme->post_title));
		     $link        = THEME_WEBDOCTOR_VN_URL . 'san-pham/' . $theme->post_slug . '-' . $theme->post_id;
		     $image_detail= get_template_directory_uri() . '/landing-page/images/detail_product.png';
		     $image_thumb = THEME_WEBDOCTOR_VN_URL . str_replace('./', '', $theme->post_thumb);
             $desktop_image = THEME_WEBDOCTOR_VN_URL . str_replace('./', '/', $theme->desktop_image);

		 ?>    
             <div class="col-sm-3 col-md-3 col-xs-12 product_detail js-thumbnail-item" data-current-page="<?php echo $themes->page;?>" data-total-page="<?php echo $themes->total_page;?>" data-total-item="<?php echo $themes->total_record ;?>" alt="<?php echo $image_alt;?>" title="<?php echo $theme->post_title ;?>" data-toggle="popover" data-placement="right">
                <div class="thumbnail-container">
                    <div class="service_border js-thumbnail-proposed js-thumbnail thumbnail-preview">
                       <a href="<?php echo $link ;?>" title="<?php echo $theme->post_title ;?>" target="_blank" class="thumb_preview js-thumb_preview js-view-product">
                          <div class="service-img">
                             <img src="<?php echo $image_thumb ;?>" alt="<?php echo $image_alt ;?>" title="<?php echo $theme->post_title ;?>" class="img-responsive js-thumbnail-img thumbnail-img" style="height: 315px"/>
                          </div>
                       </a>
                       <p>
                          <a href="<?php echo $link ;?>" title="<?php echo $theme->post_title ;?>" title="<?php echo $theme->post_title ;?>" target="_blank"><?php echo $theme->post_title ;?></a>
                          <a href="<?php echo $link ;?>" title="<?php echo $theme->post_title ;?>" title="<?php echo $theme->post_title ;?>" class="dislay-image-detail" target="_blank">
                          <img class="none" alt="icon-detail" title="<?php echo $theme->post_title ;?>" src="<?php echo $image_detail;?>" /></a>
                       </p>
                    </div>
                    <div class="template-data js-template-data-wrap" style="display: none">
                      <img src="<?php echo $desktop_image;?>" class="img-responsive text-center"/>
                      <div class="list-view-btn js-live-buttons">
                        <div class="one-btn-wrap pull-left">
                            <a href="<?php echo $link ;?>" class="btn btn-link btn-flat"><i class="fa fa-link" aria-hidden="true"></i> CHI TIẾT</a>
                        </div>                        
                        <div class="one-btn-wrap pull-right">
                            <a class="btn btn-view btn-flat" target="_blank" href="<?php echo THEME_WEBDOCTOR_VN_URL . 'san-pham/demo/' . $theme->post_slug . '-' . $theme->post_id ?>"><i class="fa fa-eye" aria-hidden="true"></i> XEM DEMO</a>
                        </div>
                      </div>
                    </div>
                </div>
             </div>
	<?php endforeach ;?>
<?php else :?>
    <p>Không tìm thấy kết quả</p>
<?php endif ;?>