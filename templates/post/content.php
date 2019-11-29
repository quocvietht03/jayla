<?php 
$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
ob_start();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-layout-'. $blog_settings['archive']['layout'] .'-item'); ?>>
  <div class="post__inner layout-post">
    <header class="entry-header">
      <?php
        jayla_posted_on();
        the_title( sprintf(
          '<h2 class="alpha entry-title" data-design-name="%s" data-design-selector="%s"><a href="%s" rel="bookmark">%s',
          __('Post title', 'jayla'),
          implode(' ', array( '#page', 'article .post__inner.layout-post', '.entry-header', '.entry-title > a' )),
          esc_url( get_permalink() ),
          apply_filters( 'jayla_post_title_layout_default_before', '' )
        ), '</a></h2>' );
      ?>
    </header> <!-- .entry-header -->
    <div class="row theme-extends-selector-sticky-meta-entry">
      <div class="col-lg-2 col-md-12">
        <?php jayla_post_meta(); ?>
      </div>
      <div class="col-lg-10 col-md-12">
        <div class="entry-content" >
        <?php
          /**
           * Functions hooked in to jayla_post_content_before action.
           *
           * @hooked jayla_post_thumbnail - 10
           */
          do_action( 'jayla_post_content_before' );
        ?>
        <div
          class="content-excerpt"
          data-design-name="<?php echo esc_attr('Post content', 'jayla') ?>"
          data-design-selector='<?php echo esc_attr( implode(' ', array( '#page', 'article .post__inner.layout-post', '.content-excerpt' )) ); ?>'>
          <?php the_excerpt(); ?>
        </div>
        <?php
          do_action( 'jayla_post_content_after' );

          wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'jayla' ),
            'after'  => '</div>',
          ) );
        ?>
        </div><!-- .entry-content -->
      </div>
    </div>
  </div> <!-- .layout-post -->
</article>
<?php 
  /**
   * Hooks
   * @see jayla_archive_post_grid_template - 20 
   */
  echo apply_filters( sprintf('jayla_blog_archive_layout_%s', $blog_settings['archive']['layout'] ), ob_get_clean() ); 
?>