<div class="col-sm-3 col-md-3">
    <div class="item">
        <?php 
            if(has_post_thumbnail()) { ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img src="<?php the_post_thumbnail_url(); ?>" class="img-responsive" title="<?php echo get_the_title() ;?>" />
                </a>
            <?php } 
        ?>						
        <p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
    </div>
</div>