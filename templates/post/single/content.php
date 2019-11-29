<?php
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-single-default-template'); ?> role="contentinfo">
  <div class="post__inner layout-post">
    <?php 
    /**
     * Hooks
     * @see jayla_single_post_header_temp - 20 
     */
    do_action( 'jayla_single_post_top' ); 
    ?>
    <div id="theme_extends_post_single_entry_content" class="row">
      <?php
        $action_name = ( $post->post_type == 'post' ) ? 'jayla_post_single_entry' : 'jayla_no_post_single_entry';
        do_action( $action_name );
      ?>
    </div> <!-- .row -->
    <?php
    /**
  	 * Functions hooked in to jayla_single_post_bottom action
  	 *
  	 * @hooked jayla_post_nav               - 10
  	 * @hooked jayla_post_related_carousel  - 12
  	 * @hooked jayla_display_comments       - 20
  	 */
  	do_action( 'jayla_single_post_bottom' );
    ?>
  </div> <!-- .layout-post -->
</article>
