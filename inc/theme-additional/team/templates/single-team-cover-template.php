<?php 
global $post;

?>
<div class="themeextends-single-team-image-cover-container">
    <div class="image-cover-inner">
        <?php 
        /**
         * @hook jayla_team_single_image_cover. 
         * 
         * @see jayla_team_single_image_cover_func - 20 
         */
        do_action( 'jayla_team_single_image_cover' ); 
        ?>
        <div class="<?php do_action('jayla_container_class') ?>">
            <div class="row">
                <div class="col-12">
                    <div class="image-cover-container-entry">
                        <?php do_action( 'jayla_team_single_image_cover_inner_entry' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 