<?php
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('jetpack-portfolio-single-default-template'); ?> role="contentinfo">
  <div class="post__inner layout-petpack-portfolio">
    <?php 
    /**
     * Hooks jayla_single_jetpack_portfolio_top
     * 
     * @see  
     */
    do_action( 'jayla_single_jetpack_portfolio_top' ); 
    ?>
    <div id="theme_extends_jetpack_portfolio_single_entry_content">
      <?php
        /**
         * Hooks jayla_jetpack_portfolio_single_entry
         * 
         * @see 
         */
        do_action( 'jayla_jetpack_portfolio_single_entry' );
      ?>
    </div> <!-- .row -->
    <?php
    /**
  	 * Functions hooked in to jayla_single_jetpack_portfolio_bottom action
  	 *
  	 * @hooked jayla_post_nav               - 10
  	 * @hooked jayla_display_comments       - 20
  	 */
  	do_action( 'jayla_single_jetpack_portfolio_bottom' );
    ?>
  </div> <!-- .layout-post -->
</article>
