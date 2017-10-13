<?php print_r($themes) ?>
<?php if(!empty($themes)) : ?>
	<?php foreach ($themes as $theme) : ?>
		 <?php 
			 $imageSource = $theme->post_thumb;
		     $image_alt   = sanitize_title(remove_accents($theme->post_title));
		     $link        = THEME_WEBDOCTOR_VN_URL . 'san-pham/' . $theme->post_slug . '-' . $theme->post_id;
		     $image_detail   = get_template_directory_uri() . '/landing-page/images/detail_product.png';
		     $image_thumb = THEME_WEBDOCTOR_VN_URL . str_replace('./', '', $theme->post_thumb);
		 ?>    
             <div class="col-sm-6 col-md-3 col-xs-12 product_detail wow bounceInUp">
                <div class="service_border">
                   <a href="<?php echo $link ;?>" title="<?php echo $theme->post_title ;?>">
                      <div class="service-img">
                         <img src="<?php echo $image_thumb ;?>" alt="<?php echo $image_alt ;?>" title="<?php echo $theme->post_title ;?>" class="img-responsive" style="height: 315px"/>
                         <div class="service-overlay_a">
                            <?php echo $theme->post_detail ;?>
                         </div>
                      </div>
                   </a>
                   <p>
                      <a href="<?php echo $link ;?>" title="<?php echo $theme->post_title ;?>" title="<?php echo $theme->post_title ;?>"><?php echo $theme->post_title ;?></a>
                      <a href="<?php echo $link ;?>" title="<?php echo $theme->post_title ;?>" title="<?php echo $theme->post_title ;?>" class="dislay-image-detail" >
                      <img class="none" alt="icon-detail" title="<?php echo $theme->post_title ;?>" src="<?php echo $image_detail;?>" /></a>
                   </p>
                </div>
             </div>
	<?php endforeach ;?>
<?php endif; ?>
