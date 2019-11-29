<?php 
/**
 * @package jayla
 * wpbakery custom template
 * 
 * @version 1.0.0
 */

if(! function_exists('jayla_bevc_element_block_slide_items__add_layout_image_large')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_bevc_element_block_slide_items__add_layout_image_large($post, $atts) {
        if( has_post_thumbnail() ) {
            $thumbnail_large_src = get_the_post_thumbnail_url($post, 'large');
            ?>
            <div class="thumbnail-large-overlay" data-background-image-lazyload-onload="<?php echo esc_attr( $thumbnail_large_src ); ?>"></div>
            <?php
        }
    }
}