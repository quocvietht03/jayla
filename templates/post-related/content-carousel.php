<?php 
/**
 * Post relative carousel template
 * @version 1.0.0 
 */

$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
if($blog_settings['detail']['post_related'] != 'yes') return;

$related_post = jayla_get_related_articles( (int) $blog_settings['detail']['post_related_limit'] );
if( empty($related_post) || count($related_post) <= 0 ) return;

// Related Slide Options
$related_swiper_opts = apply_filters( 'jayla_related_swiper_opts_filter', array(
    'slidesPerView' => 4,
    'spaceBetween' => 34,
    'pagination' => array(
        'el' => '.post-relative-swiper-pagination',
        'clickable' => true,
    ),
    'breakpoints' => array(
        1024 => array(
            'slidesPerView' => 3,
            'spaceBetween' => 30,
        ),
        786 => array(
            'slidesPerView' => 2,
            'spaceBetween' => 30,
        ),
        350 => array(
            'slidesPerView' => 1,
        ),
    ),
) )
?>
<div class="post-related-container post-related-carousel-ui">
    <div class="_related-inner">
        <div class="related-heading">
            <h3 class="post-relared-title" data-design-name="<?php _e('Related title', 'jayla'); ?>" data-design-selector="#page .post-related-container .post-relared-title"><?php _e('Most Popular Posts', 'jayla'); ?></h3>
            <p class="post-relared-sub-title" data-design-name="<?php _e('Related sub-title', 'jayla'); ?>" data-design-selector="#page .post-related-container .post-relared-sub-title"><?php _e('That You Shouldn\'t Miss Out', 'jayla'); ?></p>
        </div>
        <div class="theme-extends-swiper-carousel-default-ui swiper-container" data-themeextends-swiper='<?php echo esc_attr( wp_json_encode( $related_swiper_opts ) ); ?>'>
            <div class="swiper-wrapper">
                <?php foreach($related_post as $item) {
                    echo '<div class="swiper-slide"><div class="post-related-item">';
                    /**
                     * Hooks
                     * @see  jayla_related_post_carousel_item_entry - 20
                     */
                    do_action('jayla_related_post_carousel_item', $item, $blog_settings);
                    echo '</div></div>';
                } ?>
            </div>
            <!-- Add Pagination -->
            <div class="post-relative-swiper-pagination"></div>
        </div>
    </div>
</div>