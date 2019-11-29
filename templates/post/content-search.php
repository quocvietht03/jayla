<?php
ob_start();
$post_type = get_post_type();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-item-layout-search hentry'); ?>>
    <div class="post__inner">
        <?php do_action('jayla_content_search_item_before_entry'); ?>
        <a class="p-title" href="<?php the_permalink() ?>"><?php jayla_get_posttype_name($post_type, true) ?>: <?php the_title(); ?></a>
        <div class="p-meta-tags">
            <?php do_action('jayla_content_search_item_before_meta_tags'); ?>
            <div class="p-author">
                <span><?php _e( 'Created by', 'jayla' ) ?></span> <?php the_author_posts_link(); ?>
            </div>
            <div class="p-on">
                <i class="fa fa-calendar-o"></i> <?php jayla_posted_on( '%s' ); ?>
            </div>
            <?php 
                /**
                 * hook jayla_content_search_item_after_meta_tags.
                 * 
                 * jayla_content_search_item_after_meta_tags_post_cat - 20 
                 * jayla_content_search_item_after_meta_tags_post_tag - 22
                 */
                do_action('jayla_content_search_item_after_meta_tags'); 
            ?>
        </div>
        <div class="p-entry">
            <?php the_excerpt(); ?>
        </div>
        <?php do_action('jayla_content_search_item_after_entry'); ?>
    </div>
</article>
<?php 
echo apply_filters( 'jayla_post_'. $post_type .'_loop_item_search_page', ob_get_clean() );
?>