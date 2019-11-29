<?php

if(! function_exists('jayla_body_layout_classes')) {
	/**
	 * body layout
	 */
	function jayla_body_layout_classes($classes) {
		$post_id = jayla_get_post_id();

		$global_layout = fintotheme_global_layout_options();
		$layout = $global_layout['layout'];

		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_layout'] == 'yes') {
			$layout = $custom_metabox_data['layout'];
		}

		array_push($classes, 'theme-extends-layout-' . $layout);

		return $classes;
	}
	add_filter( 'body_class', 'jayla_body_layout_classes' );
}

if(! function_exists('jayla_header_button_toggle')) {
	/**
	 * header button toggle off-canvas
	 */
	function jayla_header_button_toggle() {
		$post_id = jayla_get_post_id();

		$global_layout = fintotheme_global_layout_options();
		$layout_validate = array('nav-left', 'nav-right');
		$layout = $global_layout['layout'];

		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_layout'] == 'yes') {
			$layout = $custom_metabox_data['layout'];
		}

		if(! in_array($layout, $layout_validate)) return;
		?>
		<div class="theme-extends-header-toggle-btn">
			<button class="hamburger hamburger--collapse" type="button">
			  <span class="hamburger-box">
			    <span class="hamburger-inner"></span>
			  </span>
			</button>
		</div>
		<?php
	}
}

if(! function_exists('jayla_container_class_func')) {
	/**
	 * action container class
	 */
	function jayla_container_class_func() {

		$post_id = jayla_get_post_id();

		$global_layout = fintotheme_global_layout_options();
		$container_width = $global_layout['container_width'];

		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_layout'] == 'yes' && !is_archive()) {
			$container_width = $custom_metabox_data['container_width'];
		}

		echo jayla_container_class($container_width, array(), false);
	}
}

if ( ! function_exists( 'jayla_get_sidebar' ) ) {
	/**
	 * Display jayla sidebar
	 *
	 * @uses get_sidebar()
	 * @since 1.0.0
	 */
	function jayla_get_sidebar() {
		$show_sidebar = apply_filters( 'jayla_show_sidebar_filter', true);
		if( false == $show_sidebar ) return;

		$post_id = jayla_get_post_id();

		$sidebar_opts	= fintotheme_sidebar_options();
		$sidebar_layout = $sidebar_opts['layout'];

		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		$is_archive = apply_filters( 'jayla_sidebar_is_archive_page_filter', is_archive() );

		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_sidebar'] == 'yes' && !$is_archive) {
			$sidebar_layout = $custom_metabox_data['sidebar_layout'];
		}

		if($sidebar_layout == 'no-sidebar') return;

		get_sidebar();
	}
}

if ( ! function_exists( 'jayla_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function jayla_post_header() {
		?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {
			jayla_posted_on();
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			if ( 'post' == get_post_type() ) {
				jayla_posted_on();
			}

			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if (! function_exists('jayla_load_loop_post_template') ) {
	/**
	 * load loop post template
	 */
	function jayla_load_loop_post_template() {
		$blog_archive_layouts_data = jayla_blog_archive_layouts();
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		$blog_settings_archive = $blog_settings['archive'];
		$blog_layout = $blog_settings_archive['layout'];

		$default_path = 'templates/post';
		$blog_layout_path = isset( $blog_archive_layouts_data[$blog_layout] ) ? $blog_archive_layouts_data[$blog_layout]['path_template'] : $default_path;
		$blog_layout_path = apply_filters( 'jayla_blog_archive_layout_path_filter', $blog_layout_path );

		if( is_dir( get_template_directory() . '/' . $blog_layout_path ) )
			get_template_part( $blog_layout_path . '/content', get_post_format() );
	 	else
			get_template_part( $default_path . '/content', get_post_format() );
	}
}

if(! function_exists('jayla_load_single_post_template') ) {
	/**
	 *	load single post template
	 */
	function jayla_load_single_post_template() {
		$blog_single_layouts_data = jayla_blog_single_layouts();
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		$blog_settings_detail = $blog_settings['detail'];
		$blog_layout = $blog_settings_detail['layout'];

		$default_path = 'templates/post/single';
		$blog_layout_path = isset( $blog_single_layouts_data[$blog_layout] ) ? $blog_single_layouts_data[$blog_layout]['path_template'] : $default_path;
		$blog_layout_path = apply_filters( 'jayla_blog_single_layout_path_filter', $blog_layout_path );

		if( is_dir( get_template_directory() . '/' . $blog_layout_path ) )
			get_template_part( $blog_layout_path . '/content', get_post_format() );
	 	else
			get_template_part( $default_path . '/content', get_post_format() );
	}
}

if ( ! function_exists( 'jayla_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0.0
	 */
	function jayla_post_meta() {
		global $post;
		$design_selector = apply_filters( 'jayla_post_entry_meta_design', array(
			array(
				'name' => __('Post entry meta wrap', 'jayla'),
				'selector' => '#page .theme-extends-post-entry-meta',
			),
			array(
				'name' => __('Post entry meta label', 'jayla'),
				'selector' => '#page .theme-extends-post-entry-meta div.label',
			),
			array(
				'name' => __('Post entry meta link', 'jayla'),
				'selector' => '#page .theme-extends-post-entry-meta a',
			),
			array(
				'name' => __('Post entry meta link (:hover)', 'jayla'),
				'selector' => '#page .theme-extends-post-entry-meta a:hover',
			),
		) );

		$sticky_data_element = array(
			'topSpacing' 			=> 30,
			'bottomSpacing' 		=> 30,
			'containerSelector' 	=> '#theme_extends_post_single_entry_content',
			'innerWrapperSelector' 	=> '.post-entry-meta__inner',
			'minWidth'				=> 991,
		);
		$sticky_data_element['containerSelector'] = (is_single()) ? '#theme_extends_post_single_entry_content' : '#post-'. $post->ID .' .theme-extends-selector-sticky-meta-entry';
		$attr_sticky_element = 'data-sticky-element=\''. wp_json_encode( $sticky_data_element ) .'\'';
		?>
		<aside class="entry-meta theme-extends-post-entry-meta" <?php echo esc_attr($attr_sticky_element); ?> data-design-name="<?php _e('Post entry meta', 'jayla'); ?>" data-design-selector='<?php echo esc_attr( wp_json_encode( $design_selector ) ); ?>'>
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search.

			?>
			<div class="post-entry-meta__inner">
				<?php do_action( 'jayla_before_inner_entry_meta' ); ?>

				<div class="author">
					<?php
						echo get_avatar( get_the_author_meta( 'ID' ), 128 );
						echo '<div class="label">' . esc_attr( __( 'Written by', 'jayla' ) ) . '</div>';
						the_author_posts_link();
					?>
				</div>
				<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( ' ' );

				if ( $categories_list ) : ?>
					<div class="cat-links">
						<?php
						echo '<div class="label">' . esc_attr( __( 'Posted in', 'jayla' ) ) . '</div>';
						echo wp_kses_post( $categories_list );
						?>
					</div>
				<?php endif; // End if categories. ?>

				<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', ' ' );

				if ( $tags_list ) : ?>
					<div class="tags-links">
						<?php
						echo '<div class="label">' . esc_attr( __( 'Tagged', 'jayla' ) ) . '</div>';
						echo wp_kses_post( $tags_list );
						?>
					</div>
				<?php endif; // End if $tags_list. ?>

				<?php endif; // End if 'post' == get_post_type(). ?>

				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
					<div class="comments-link">
						<?php echo '<div class="label">' . esc_attr( __( 'Comment', 'jayla' ) ) . '</div>'; ?>
						<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'jayla' ), __( '1 Comment', 'jayla' ), __( '% Comments', 'jayla' ) ); ?></span>
					</div>
				<?php endif; ?>

				<?php do_action( 'jayla_after_inner_entry_meta' ); ?>
			</div>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'jayla_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function jayla_post_content() {
		?>
		<div class="entry-content">
		<?php

		/**
		 * Functions hooked in to jayla_post_content_before action.
		 *
		 * @hooked jayla_post_thumbnail - 10
		 */
		do_action( 'jayla_post_content_before' );

		the_content(
			sprintf(
				__( 'Continue reading %s', 'jayla' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		do_action( 'jayla_post_content_after' );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'jayla' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'jayla_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function jayla_posted_on($text = 'Posted on %s') {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			$text,
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo wp_kses( apply_filters( 'jayla_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span>', $posted_on ), array(
			'span' => array(
				'class'  => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		) );
	}
}

if ( ! function_exists( 'jayla_page_header' ) ) {
	/**
	 * Display the page header
	 * Revert - https://d.pr/free/i/YDGsA4
	 * @since 1.0.0
	 */
	function jayla_page_header() {

	}
}

if ( ! function_exists( 'jayla_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.0.0
	 */
	function jayla_post_thumbnail( $size = 'full' ) {
		global $post;

		if ( has_post_thumbnail() ) {
			$thumbnail_src = get_the_post_thumbnail_url($post, 'large');
			echo '<div class="p-featured-image">';
			the_post_thumbnail( $size );
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'jayla_display_comments' ) ) {
	/**
	 * jayla display comments
	 *
	 * @since  1.0.0
	 */
	function jayla_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'jayla_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function jayla_post_nav() {
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		if($blog_settings['detail']['navigation'] != 'yes') return;

		$args = array(
			'next_text' => sprintf( '<div class="post-navigation-label">%1$s <span class="icon-wrap"><i class="ion-android-arrow-forward"></i></span></div>', __('Newer', 'jayla') ) . ' %title', //'%title <i class="ion-android-arrow-forward"></i>',
			'prev_text' => sprintf( '<div class="post-navigation-label"><span class="icon-wrap"><i class="ion-android-arrow-back"></i></span> %1$s</div>', __('Older', 'jayla') ) . ' %title'// '<i class="ion-android-arrow-back"></i> %title',
		);
		?>
		<div
			class="post-navigation theme-extends-post-navigation"
			data-design-name="<?php echo esc_attr('Post navigation', 'jayla') ?>"
			data-design-selector='<?php echo esc_attr( implode(' ', array('#page', '.theme-extends-post-navigation', 'a')) ); ?>'>
			<?php the_post_navigation( $args ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'jayla_footer_builder' ) ) {
	/**
	 * Display the footer builder.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function jayla_footer_builder() {
		$post_id = jayla_get_post_id();

		$footer_builder_data = json_decode(get_theme_mod( 'jayla_footer_builder_data' ), true);
		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_footer'] == 'yes') {
			$footer_builder_layout = json_decode(get_theme_mod( 'jayla_footer_builder_layout' ), true);
			$found_key = array_search($custom_metabox_data['custom_footer_layout'], array_column($footer_builder_layout, 'key'));

			if(! empty($found_key)) { $footer_builder_data = $footer_builder_layout[$found_key]; }
		}

		$footer_class = new Jayla_Footer_Render($footer_builder_data);
		?>
		<div id="footer-builder-container">
			<div class="footer-builder-container-inner">
				<?php $footer_class->render(); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'jayla_credit' ) ) {
	/**
	 * Display the theme credit
	 * Revert - https://d.pr/free/i/1FLrux
	 * @since  1.0.0
	 * @return void
	 */
	function jayla_credit() {

	}
}

if ( ! function_exists( 'jayla_comment' ) ) {
	/**
	 * jayla comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since 1.0.0
	 */
	function jayla_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-body">
			<div class="comment-meta commentmetadata">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 128 ); ?>
					<div class="cm-name-date">
						<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'jayla' ), get_comment_author_link() ); ?>
						<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
							<?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
						</a>
					</div>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						<?php edit_comment_link( __( 'Edit', 'jayla' ), '  ', '' ); ?>
					</div>
					<?php if ( 'div' != $args['style'] ) : ?>
						<div id="div-comment-<?php comment_ID() ?>" class="comment-content">
							<?php endif; ?>
							<div
								class="comment-text"
								data-design-name="<?php esc_attr_e('Comment text', 'jayla') ?>"
								data-design-selector="#page .theme-extends-comments-area .comment-body .comment-content .comment-text">
								<?php comment_text(); ?>
							</div>
						</div>
						<?php if ( 'div' != $args['style'] ) : ?>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'jayla' ); ?></em>
					<br />
				<?php endif; ?>
			</div>
	<?php
	}
}

if ( ! function_exists( 'jayla_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function jayla_post_content() {
		?>
		<div class="entry-content">
		<?php

		/**
		 * Functions hooked in to jayla_post_content_before action.
		 *
		 * @hooked jayla_post_thumbnail - 10
		 */
		do_action( 'jayla_post_content_before' );

		the_content(
			sprintf(
				__( 'Continue reading %s', 'jayla' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		do_action( 'jayla_post_content_after' );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'jayla' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if(! function_exists('jayla_heading_bar_func')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_heading_bar_func() {
		$header_bar_type = '';

		if(is_archive() || (!is_front_page() && is_home())) {
			$obj = get_queried_object();
			$taxonomy_name = jayla_get_taxonomy_name(); 
			
			if( 'default' == $taxonomy_name ) {
				$taxonomy_name = get_queried_object()->name;
			}

			$all_options = json_decode(get_theme_mod('jayla_taxonomy_heading_bar_settings'), true);
			$current_options = isset($all_options[$taxonomy_name]) ? $all_options[$taxonomy_name] : $all_options['default'];
			$current_options = apply_filters( 'jayla_taxonomy_heading_bar_options', $current_options, $obj );			
		} else {
			$background_settings = get_theme_mod('jayla_heading_bar_background_settings', true);
			$background_settings = json_decode($background_settings, true);
			$current_options = array(
				'display' => get_theme_mod('jayla_heading_bar_display', true),
				'title_display' => get_theme_mod('jayla_heading_bar_page_title_display', true),
				'breadcrumb_display' => get_theme_mod('jayla_heading_bar_breadcrumb_display', true),
				'content_align' => get_theme_mod('jayla_heading_bar_content_align', true),
			);

			$current_options = apply_filters('jayla_heading_bar_options', array_replace_recursive($current_options, $background_settings));
		}

		jayla_heading_bar_html($current_options);
	}
}

if(! function_exists('jayla_heading_bar_html')) {
	/**
	 * @since 1.0.0
	 * Heading bar html output
	 * @param {array} $options
	 * 	- display
	 * 	- title_display
	 * 	- breadcrumb_display
	 *  - content_align
	 *  - background_type
	 *  - background_gradient
	 *  - background_color
	 *  - background_color2
	 *  - background_image
	 *  - background_size
	 *  - background_position
	 *  - background_repeat
	 *  - background_attachment
	 *  - background_image_parallax
	 *  - background_video_url
	 *  - background_overlay_color_display
	 *  - background_overlay_color
	 *
	 * @return {html}
	 */
	function jayla_heading_bar_html($options = array()) {
		extract($options);

		$page_title = jayla_heading_title();
		$heading_bar_display = apply_filters('jayla_heading_bar_display_data', $display);
		if($heading_bar_display == 'false') return;
?>
<div class="theme-heading-bar theme-extends-heading-bar" data-design-name="<?php echo esc_attr('Heading bar', 'jayla'); ?>" data-design-selector="#page .theme-extends-heading-bar">
	<!-- background -->
	<?php echo apply_filters('fintotheme_heading_bar_background_type_' . $background_type, '', $options); ?>

	<!-- background overlay color -->
	<?php if( $background_overlay_color_display == 'true' ) { ?>
	<div class="heading-bar-background-overlay-color" style="background: <?php echo esc_attr($background_overlay_color); ?>"></div>
	<?php } ?>

	<!-- heading bar content -->
	<div class="theme-heading-bar__inner <?php echo esc_attr($content_align); ?>">
		<div class="<?php do_action('jayla_container_class') ?>">
			<div class="row">
				<div class="col-12">
					<?php do_action('jayla_before_heading_bar', $options); ?>
					<?php if($title_display == 'true') { ?>
					<div class="theme-heading-title-container">
						<h1
							class="heading-title-page"
							data-design-name="<?php echo esc_attr('Heading title', 'jayla'); ?>"
							data-design-selector="#page .theme-extends-heading-bar .heading-title-page">
							<?php echo implode(' ', $page_title); ?>
						</h1>
					</div>
					<?php } ?>
					<?php do_action('jayla_after_heading_bar', $options); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
}

if(! function_exists('jayla_breadcrumbs')) {
	/**
	 * breadcrumbs
	 * @param {array} $opts
	 *
	 * @return {html}
	 */
	function jayla_breadcrumbs($opts = array()) {

		$breadcrumb_display = $opts['breadcrumb_display'];
		if($breadcrumb_display == 'false') return;

		/* check class Breadcrumbs exist */
		if(! class_exists('Inc2734\WP_Breadcrumbs\Breadcrumbs') ) return;

		$breadcrumbs = new Inc2734\WP_Breadcrumbs\Breadcrumbs();
		$items = $breadcrumbs->get();
		$design_selector = json_encode(array(
			array( 'name' => __('Breadcrumb container', 'jayla'), 'selector' => '#page .theme-extends-heading-bar .theme-breadcrumbs-container' ),
			array( 'name' => __('Breadcrumb item link', 'jayla'), 'selector' => '#page .theme-extends-heading-bar .theme-breadcrumbs-container .theme-breadcrumbs__list .theme-breadcrumbs__item > a' ),
		));
		?>
		<div class="theme-breadcrumbs-container" data-design-name="<?php echo esc_attr('Breadcrumb', 'jayla'); ?>" data-design-selector='<?php echo esc_attr($design_selector); ?>'>
			<ol class="theme-breadcrumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">
				<?php foreach ( $items as $key => $item ) : ?>
				<li class="theme-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<?php if ( empty( $item['link'] ) ) : ?>
					<span itemscope itemtype="http://schema.org/Thing" itemprop="item">
						<span itemprop="name"><?php echo esc_html( $item['title'] ); ?></span>
					</span>
					<?php else : ?>
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo esc_url( $item['link'] ); ?>">
						<span itemprop="name"><?php echo esc_html( $item['title'] ); ?></span>
					</a>
					<?php endif; ?>
					<meta itemprop="position" content="<?php echo esc_attr( $key + 1 ); ?>" />
				</li>
				<?php endforeach; ?>
			</ol>
		</div>
		<?php
	}
}

if(! function_exists('fintotheme_heading_bar_background_type_color')) {
	/**
	 * heading background color
	 */
	function fintotheme_heading_bar_background_type_color($output, $settings = array()) {

		if($settings['background_gradient'] == 'true') {
			$color_temp = 'background: {color}; /* For browsers that do not support gradients */
			  background: -webkit-linear-gradient(left top, {color}, {color2}); /* For Safari 5.1 to 6.0 */
			  background: -o-linear-gradient(bottom right, {color}, {color2}); /* For Opera 11.1 to 12.0 */
			  background: -moz-linear-gradient(bottom right, {color}, {color2}); /* For Firefox 3.6 to 15 */
			  background: linear-gradient(to bottom right, {color}, {color2}); /* Standard syntax */';
		} else {
			$color_temp = 'background-color: {color}';
		}

		$variables = array(
			'{color}' => $settings['background_color'],
			'{color2}' => $settings['background_color2'],
		);

		$style_inline = str_replace( array_keys($variables), array_values($variables), $color_temp );
		ob_start();
		?>
		<div class="heading-bar-background-color" style="<?php echo esc_attr($style_inline); ?>"></div>
		<?php
		return ob_get_clean();
	}
	add_filter('fintotheme_heading_bar_background_type_color', 'fintotheme_heading_bar_background_type_color', 10, 2);
}

if(! function_exists('fintotheme_heading_bar_background_type_image')) {
	/**
	 * heading background image
	 */
	function fintotheme_heading_bar_background_type_image($output, $settings = array()) {

		$variables = array(
			'{background_image}' => $settings['background_image'],
			'{background_size}' => $settings['background_size'],
			'{background_position}' => $settings['background_position'],
			'{background_repeat}' => $settings['background_repeat'],
			'{background_attachment}' => $settings['background_attachment'],
		);

		$parallax_effect = $settings['background_image_parallax'];

		$style_inline = str_replace(
			array_keys($variables),
			array_values($variables),
		 	implode(' ', array(
				'background-image: url("{background_image}");',
				! empty( $variables['{background_repeat}'] ) ? 'background-repeat: {background_repeat};' : '',
				! empty( $variables['{background_position}'] ) ? 'background-position: {background_position};' : '',
				! empty( $variables['{background_attachment}'] ) ? 'background-attachment: {background_attachment};' : '',
				! empty( $variables['{background_size}'] ) ? 'background-size: {background_size};' : '',
			)));

		ob_start();
		if( $parallax_effect == 'true' ) { ?>
			<!-- parallax -->
			<div class="heading-bar-background-image jarallax" data-jarallax data-speed="0.2" style="<?php echo esc_attr($style_inline); ?>">
				<img class="jarallax-img" src="<?php echo esc_url($settings['background_image']); ?>" alt="<?php echo esc_attr( 'image', 'jayla' ) ?>">
			</div>
		<?php } else { ?>
			<!-- normal -->
			<div class="heading-bar-background-image" style="<?php echo esc_attr($style_inline); ?>"></div>
		<?php }
		return ob_get_clean();
	}
	add_filter('fintotheme_heading_bar_background_type_image', 'fintotheme_heading_bar_background_type_image', 10, 2);
}

if(! function_exists('jayla_title_sticky_post')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_title_sticky_post($content) {
		if(is_sticky()) {
			$content = '<span class="fa fa-bookmark" aria-hidden="true"></span> ';
		}

		return $content;
	}
}

if(! function_exists('fintotheme_heading_bar_background_type_video')) {
	/**
	 * heading background video
	 */
	function fintotheme_heading_bar_background_type_video($output, $settings = array()) {
		if(empty($settings['background_video_url'])) return;
		return sprintf('<div class="heading-bar-background-video jarallax" data-jarallax-video="%s"></div>', $settings['background_video_url']);
	}
	add_filter('fintotheme_heading_bar_background_type_video', 'fintotheme_heading_bar_background_type_video', 10, 2);
}


if(! function_exists('jayla_builder')) {
	/**
	 * header builder render html
	 */
	function jayla_header_builder() {
		$post_id = jayla_get_post_id();
		$header_builder_data = json_decode(get_theme_mod( 'jayla_header_builder_data' ), true);
		$custom_metabox_data = jayla_get_custom_metabox($post_id);

		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_header'] == 'yes') {
			$header_builder_layout = json_decode(get_theme_mod( 'jayla_header_builder_layout' ), true);
			$found_key = array_search($custom_metabox_data['custom_header_layout'], array_column($header_builder_layout, 'key'));

			if(! empty($found_key)) { $header_builder_data = $header_builder_layout[$found_key]; }
		}

		$header_class = new Jayla_Header_Render($header_builder_data);
		?>
		<div id="header-builder-container">
			<?php do_action('jayla_before_header_builder'); ?>
			<div class="header-builder-container-inner">
				<?php $header_class->render(); ?>
			</div>
			<?php do_action('jayla_after_header_builder'); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'jayla_page_content' ) ) {
	/**
	 * Display the post content
	 *
	 * @since 1.0.0
	 */
	function jayla_page_content() {
		?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'jayla' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'jayla_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function jayla_paging_nav() {
		global $wp_query;

		$layout = 'default';
		$args = array(
			'type' 	    => 'list',
			'next_text' => sprintf( '%s <i class="ion-android-arrow-forward"></i>', __('Next', 'jayla') ),
			'prev_text' => sprintf( '<i class="ion-android-arrow-back"></i> %s', __('Previous', 'jayla') ),
		);

		$pagination_design_selector = json_encode(array(
			array( 'name' => __('Pagination container', 'jayla'), 'selector' => '#page .theme-extends-posts-pagination.pagination-layout-default' ),
			array( 'name' => __('Pagination Current', 'jayla'), 'selector' => '#page .theme-extends-posts-pagination.pagination-layout-default li .current' ),
			array( 'name' => __('Pagination Dots', 'jayla'), 'selector' => '#page .theme-extends-posts-pagination.pagination-layout-default li .dots' ),
			array( 'name' => __('Pagination Link', 'jayla'), 'selector' => '#page .theme-extends-posts-pagination.pagination-layout-default li a' ),
			array( 'name' => __('Pagination Link on :hover', 'jayla'), 'selector' => '#page .theme-extends-posts-pagination.pagination-layout-default li a:hover' ),
		));

		$classes = implode(' ', array(
			'theme-extends-posts-pagination',
			'pagination-layout-' . $layout,
		));
		ob_start();
		?>
		<div class="<?php echo esc_attr($classes); ?>" data-design-name="<?php echo esc_attr('Pagination', 'jayla') ?>" data-design-selector='<?php echo esc_attr($pagination_design_selector); ?>'>
			<?php the_posts_pagination( $args ); ?>
		</div>
		<?php
		echo apply_filters( 'jayla_paging_nav_html', ob_get_clean() );
	}
}

if(! function_exists('jayla_header_attributes')) {
	/**
	 * header attributes
	 */
	function jayla_header_attributes() {
		$designer_header = apply_filters('jayla_header_attribute_data', array(
			'data-design-name' 			=> __('Header wrap', 'jayla'),
			'data-design-selector' 	=> '#page .site-header',
		));

		$data_attrs = array_map('jayla_attribute_render', array_keys($designer_header), array_values($designer_header));
		echo implode(' ', $data_attrs);
	}
}

if(! function_exists('jayla_woo_custom_woocommerce_locate_template')) {
	/**
	 * custom template
	 */
	function jayla_woo_custom_woocommerce_locate_template($template, $template_name, $template_path) {
		return $template;
	}
}

if(! function_exists('jayla_header_strip')){
	/**
	 * @since 1.0.0
	 * header strip
 	 */
	function jayla_header_strip() {
		$header_builder_data = json_decode(get_theme_mod( 'jayla_header_builder_data' ), true);
		$header_builder_data = apply_filters( 'jayla_header_strip_data_filter', $header_builder_data );

		$header_settings = $header_builder_data['settings'];

		if($header_settings['header_strip_display'] != '1') return;

		$class_key = 'header-strip-wrap-id-' . $header_builder_data['key'];
		$warpper_classes = implode( ' ', array( 'header-strip-wrap', $class_key ) );
		$content_classes = sprintf('container-%s', $header_settings['header_strip_content']);

		$button_design_data = wp_json_encode( array(
			array(
				'name' => __('Header strip button', 'jayla'),
				'selector' => "#page .{$class_key} .button-header-strip",
			),
			array(
				'name' => __('Header strip button (:hover)', 'jayla'),
				'selector' => "#page .{$class_key} .button-header-strip:hover",
			),
		) )
		?>
		<div
			id="theme-extends-header-strip"
			class="<?php echo esc_attr( $warpper_classes ); ?>"
			data-design-name="<?php _e( 'Header strip', 'jayla') ?>"
			data-design-selector="#page .<?php echo esc_attr( 'header-strip-wrap-id-' . $header_builder_data['key'] ); ?>">
			<div class="<?php echo esc_attr($content_classes); ?>">
				<div class="header-strip-content">
					<div class="header-strip-text" data-design-name="<?php _e( 'Strip text', 'jayla' ) ?>" data-design-selector="<?php echo esc_attr( "#page .{$class_key} .header-strip-text" ); ?>" ><?php echo esc_attr($header_settings['header_strip_text']); ?></div>
					<?php if($header_settings['header_strip_button_display'] == '1'){
						echo implode( '', array(
							'<a
								href="'. esc_url( $header_settings['header_strip_link'] ) .'"
								class="button button-header-strip"
								target="_blank"
								data-design-name="'. esc_attr__('Header strip button', 'jayla') .'"
								data-design-selector=\''. $button_design_data .'\'>',
								$header_settings['header_strip_button_text'],
							'</a>',
						) );
					} ?>
				</div>
			</div>
			<?php if($header_settings['header_strip_button_close_display'] == '1'){
				echo '<span class="header-strip-close"><i class="ion-close"></i></span>';
			} ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_post_single_entry_default')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_post_single_entry_default() {
		?>
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

				$content_design_selector = apply_filters( 'jayla_single_content_design_selector', array(
					array(
						'name' => __('Post single content wrap', 'jayla'),
						'selector' => '#page article .post__inner.layout-post .content-text',
					),
					array(
						'name' => __('Post single content link', 'jayla'),
						'selector' => '#page article .post__inner.layout-post .content-text a',
					),
					array(
						'name' => __('Post single content link (:hover)', 'jayla'),
						'selector' => '#page article .post__inner.layout-post .content-text a:hover',
					),
				) );
			?>
			<div
				class="content-text"
				data-design-name="<?php echo esc_attr('Post single content', 'jayla') ?>"
				data-design-selector='<?php echo esc_attr( wp_json_encode( $content_design_selector ) ); ?>'>
				<?php the_content(); ?>
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
		<?php
	}
}

if(! function_exists('jayla_no_post_single_entry_default')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_no_post_single_entry_default() {
		?>
		<div class="col-lg-12 col-md-12">
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
				<?php the_content(); ?>
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
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_settings_inner_general_heading_bar')) {
	/**
	 * @since 1.0.0
	 * Vue template custom heading bar
	 *
	 * @return {html}
	 */
	function jayla_metabox_customize_settings_inner_general_heading_bar() {
		?>
		<!-- custom heading bar -->
		<el-form-item label="<?php _e('Custom Heading Bar', 'jayla') ?>">
			<el-switch
			v-model="form.custom_heading_bar"
			on-text="" off-text=""
			on-value="yes" off-value="no">
			</el-switch>
			<div style="line-height: normal;"><small><?php _e('Enable custom heading bar setting tab.', 'jayla'); ?></small></div>
		</el-form-item>
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_settings_inner_general_header')) {
	/**
	 * @since 1.0.0
	 * Vue template custom header
	 *
	 * @return {html}
	 */
	function jayla_metabox_customize_settings_inner_general_header() {
		?>
		<hr /> <br />
		<!-- custom header -->
		<el-form-item label="<?php esc_attr_e('Custom Header', 'jayla') ?>">
			<el-switch
				v-model="form.custom_header"
				on-text="" off-text=""
				on-value="yes" off-value="no">
			</el-switch>
			<div style="line-height: normal;"><small><?php _e('Enable custom header setting.', 'jayla'); ?></small></div>
		</el-form-item>

		<el-form-item v-show="form.custom_header == 'yes'" label="<?php esc_attr_e('Select Header', 'jayla') ?>">
			<el-select v-model="form.custom_header_layout" placeholder="<?php esc_attr_e( 'Select', 'jayla' ) ?>">
				<el-option
					v-for="item in header_options"
					:key="item.value"
					:label="item.label"
					:value="item.value">
				</el-option>
			</el-select>
			<div style="line-height: normal;"><small><?php _e('Select header.', 'jayla'); ?></small></div>
		</el-form-item>
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_settings_inner_general_footer')) {
	/**
	 * @since 1.0.0
	 * Vue template custom footer
	 *
	 * @return {html}
	 */
	function jayla_metabox_customize_settings_inner_general_footer() {
		?>
		<hr /> <br />
		<!-- custom footer -->
		<el-form-item label="<?php esc_attr_e('Custom Footer', 'jayla') ?>">
			<el-switch
				v-model="form.custom_footer"
				on-text="" off-text=""
				on-value="yes" off-value="no">
			</el-switch>
			<div style="line-height: normal;"><small><?php _e('Enable custom footer setting.', 'jayla'); ?></small></div>
		</el-form-item>

		<el-form-item v-show="form.custom_footer == 'yes'" label="<?php esc_attr_e('Select Footer', 'jayla') ?>">
			<el-select v-model="form.custom_footer_layout" placeholder="<?php esc_attr_e( 'Select', 'jayla' ) ?>">
				<el-option
				v-for="item in footer_options"
				:key="item.value"
				:label="item.label"
				:value="item.value">
				</el-option>
			</el-select>
			<div style="line-height: normal;"><small><?php _e('Select footer.', 'jayla'); ?></small></div>
		</el-form-item>
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_settings_inner_general_layout')) {
	/**
	 * @since 1.0.0
	 * Vue template custom layout
	 *
	 * @return {html}
	 */
	function jayla_metabox_customize_settings_inner_general_layout() {
		?>
		<hr /> <br />
		<!-- custom layout -->
		<el-form-item label="<?php esc_attr_e('Custom Layout', 'jayla') ?>">
			<el-switch
				v-model="form.custom_layout"
				on-text="" off-text=""
				on-value="yes" off-value="no">
			</el-switch>
			<div style="line-height: normal;"><small><?php _e('Enable custom layout setting.', 'jayla'); ?></small></div>
		</el-form-item>

		<div v-show="form.custom_layout == 'yes'">
			<el-form-item label="<?php _e('Select Container Width', 'jayla'); ?>">
				<el-select v-model="form.container_width" placeholder="<?php esc_attr_e('container width', 'jayla'); ?>">
					<!-- fluid - large - medium -->
					<el-option label="<?php esc_attr_e('Container Fluid', 'jayla') ?>" value="fluid"></el-option>
					<el-option label="<?php esc_attr_e('Container Large', 'jayla') ?>" value="large"></el-option>
					<el-option label="<?php esc_attr_e('Container Medium', 'jayla') ?>" value="medium"></el-option>
				</el-select>
			</el-form-item>

			<el-form-item label="<?php esc_attr_e('Select Layout', 'jayla'); ?>">
				<el-select v-model="form.layout" placeholder="<?php esc_attr_e('layout', 'jayla'); ?>">
					<el-option label="<?php esc_attr_e('Default', 'jayla') ?>" value="default"></el-option>
					<el-option label="<?php esc_attr_e('Nav Left', 'jayla') ?>" value="nav-left"></el-option>
					<el-option label="<?php esc_attr_e('Nav Right', 'jayla') ?>" value="nav-right"></el-option>
				</el-select>
			</el-form-item>
		</div>
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_settings_inner_general_sidebar')) {
	/**
	 * @since 1.0.0
	 * Vue template custom sidebar
	 *
	 * @return {html}
	 */
	function jayla_metabox_customize_settings_inner_general_sidebar() {
		?>
		<hr /> <br />
		<!-- custom sidebar -->
		<el-form-item label="<?php esc_attr_e('Custom Sidebar', 'jayla') ?>">
			<el-switch
				v-model="form.custom_sidebar"
				on-text="" off-text=""
				on-value="yes" off-value="no">
			</el-switch>
			<div style="line-height: normal;"><small><?php _e('Enable custom sidebar setting.', 'jayla'); ?></small></div>
		</el-form-item>

		<div v-show="form.custom_sidebar == 'yes'">
			<el-form-item label="<?php esc_attr_e('Select Sidebar Layout', 'jayla'); ?>">
				<el-select v-model="form.sidebar_layout" placeholder="<?php _e('Sidebar Layout', 'jayla'); ?>">
					<el-option label="<?php esc_attr_e('Right Sidebar', 'jayla') ?>" value="right-sidebar"></el-option>
					<el-option label="<?php esc_attr_e('Left Sidebar', 'jayla') ?>" value="left-sidebar"></el-option>
					<el-option label="<?php esc_attr_e('No Sidebar', 'jayla') ?>" value="no-sidebar"></el-option>
				</el-select>
			</el-form-item>

			<el-form-item v-show="['right-sidebar', 'left-sidebar'].indexOf(form.sidebar_layout) >= 0" label="<?php esc_attr_e('Sidebar Sticky', 'jayla') ?>">
				<el-switch
				v-model="form.sidebar_sticky"
				on-text="" off-text=""
				on-value="yes" off-value="no">
				</el-switch>
			</el-form-item>
		</div>
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_heading_bar_settings_panel')) {
	/**
	 * @since 1.0.0
	 * Vue template heading bar setting panel
	 *
	 * @return {html}
	 */
	function jayla_metabox_customize_heading_bar_settings_panel() {
		?>
		<el-tab-pane :disabled="form.custom_heading_bar == 'no'">
			<span slot="label"><i class="fi flaticon-bars"></i> <?php _e('Heading Bar', 'jayla') ?></span>
			<el-form-item label="<?php esc_attr_e('Heading Bar', 'jayla'); ?>">
				<el-switch
				v-model="form.custom_heading_bar_display"
				on-text="" off-text=""
				on-value="true"
				off-value="false"></el-switch>
				<small><?php _e('show/hide heading bar.', 'jayla') ?></small>
			</el-form-item>

			<hr /> <br />

			<transition name="theme-extends-fade">
				<div v-show="(form.custom_heading_bar_display == 'true')">
					<el-form-item label="<?php esc_attr_e('Title Page', 'jayla'); ?>">
						<el-switch
						v-model="form.custom_heading_bar_page_title_display"
						on-text="" off-text=""
						on-value="true"
						off-value="false"></el-switch>
						<small><?php _e('show/hide title Page.', 'jayla') ?></small>
					</el-form-item>

					<el-form-item label="<?php esc_attr_e('Breadcrumb', 'jayla'); ?>">
						<el-switch
						v-model="form.custom_heading_bar_breadcrumb_display"
						on-text="" off-text=""
						on-value="true"
						off-value="false"></el-switch>
						<small><?php _e('show/hide breadcrumb.', 'jayla') ?></small>
					</el-form-item>

					<hr /> <br />

					<el-form-item label="<?php esc_attr_e('Content Alignment', 'jayla'); ?>">
						<el-radio-group v-model="form.custom_heading_bar_content_align">
							<el-radio-button label="text-left"><?php _e('Left', 'jayla'); ?></el-radio-button>
							<el-radio-button label="text-center"><?php _e('Center', 'jayla'); ?></el-radio-button>
							<el-radio-button label="text-right"><?php _e('Right', 'jayla'); ?></el-radio-button>
						</el-radio-group>
						<div style="line-height: normal;"><small><?php _e('choose content alignment.', 'jayla') ?></small></div>
					</el-form-item>

					<hr /> <br />

					<el-form-item label="<?php esc_attr_e('Background Type', 'jayla'); ?>">
						<el-radio-group v-model="form.custom_heading_bar_background_settings.background_type">
							<el-radio-button label="color"><?php _e('Color', 'jayla'); ?></el-radio-button>
							<el-radio-button label="image"><?php _e('Image', 'jayla'); ?></el-radio-button>
							<el-radio-button label="video"><?php _e('Video', 'jayla'); ?></el-radio-button>
						</el-radio-group>
						<div style="line-height: normal;"><small><?php _e('choose background type.', 'jayla') ?></small></div>
					</el-form-item>

					<!-- background color -->
					<div v-show="form.custom_heading_bar_background_settings.background_type == 'color'">
						<el-form-item label="<?php esc_attr_e('Gradient', 'jayla'); ?>">
							<el-switch
								v-model="form.custom_heading_bar_background_settings.background_gradient"
								on-text="" off-text=""
								on-value="true"
								off-value="false"></el-switch>
							<small><?php _e('on/off background gradient.', 'jayla') ?></small>
						</el-form-item>

						<el-form-item label="<?php esc_attr_e('Color', 'jayla'); ?>">
							<el-color-picker v-model="form.custom_heading_bar_background_settings.background_color"></el-color-picker>
							<div style="line-height: normal;"><small><?php _e('choose color.', 'jayla') ?></small></div>
						</el-form-item>

						<el-form-item v-show="form.custom_heading_bar_background_settings.background_gradient == 'true'" label="<?php esc_attr_e('Color 2', 'jayla'); ?>">
							<el-color-picker v-model="form.custom_heading_bar_background_settings.background_color2"></el-color-picker>
							<div style="line-height: normal;"><small><?php _e('choose color 2.', 'jayla') ?></small></div>
						</el-form-item>
					</div>

					<!-- background image -->
					<div v-show="form.custom_heading_bar_background_settings.background_type == 'image'">
						<el-form-item label="<?php esc_attr_e('Select Image', 'jayla'); ?>">
							<div style="max-width: 250px;">
								<wp-media-field :params="wp_media_field_params" name="background_image" :data-map="form.custom_heading_bar_background_settings"></wp-media-field>
							</div>
						</el-form-item>

						<el-form-item label="<?php esc_attr_e('Size', 'jayla'); ?>">
							<el-select v-model="form.custom_heading_bar_background_settings.background_size" placeholder="<?php esc_attr_e('bg size', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
								<el-option
								v-for="s_item in bg_image_size"
								:key="s_item.value"
								:label="s_item.label"
								:value="s_item.value">
								</el-option>
							</el-select>
						</el-form-item>

						<el-form-item label="<?php esc_attr_e('Position', 'jayla'); ?>">
							<el-select v-model="form.custom_heading_bar_background_settings.background_position" placeholder="<?php esc_attr_e('bg position', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
								<el-option
								v-for="p_item in bg_image_position"
								:key="p_item.value"
								:label="p_item.label"
								:value="p_item.value">
								</el-option>
							</el-select>
						</el-form-item>

						<el-form-item label="<?php esc_attr_e('Repeat', 'jayla'); ?>">
							<el-select v-model="form.custom_heading_bar_background_settings.background_repeat" placeholder="<?php esc_attr_e('bg repeat', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
								<el-option
								v-for="r_item in bg_image_repeat"
								:key="r_item.value"
								:label="r_item.label"
								:value="r_item.value">
								</el-option>
							</el-select>
						</el-form-item>

						<el-form-item label="<?php esc_attr_e('Attachment', 'jayla'); ?>">
							<el-select v-model="form.custom_heading_bar_background_settings.background_attachment" placeholder="<?php esc_attr_e('bg attachment', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
								<el-option
								v-for="a_item in bg_image_attachment"
								:key="a_item.value"
								:label="a_item.label"
								:value="a_item.value">
								</el-option>
							</el-select>
						</el-form-item>

						<el-form-item label="<?php esc_attr_e('Parallax Effect', 'jayla'); ?>">
							<el-switch
								v-model="form.custom_heading_bar_background_settings.background_image_parallax"
								on-text="" off-text=""
								on-value="true"
								off-value="false"></el-switch>
							<small><?php _e('on/off background parallax effect.', 'jayla'); ?></small>
						</el-form-item>
					</div>

					<!-- background image -->
					<div v-show="form.custom_heading_bar_background_settings.background_type == 'video'">
						<el-form-item label="<?php esc_attr_e('Video Url', 'jayla'); ?>">
						<el-input placeholder="<?php esc_attr_e( 'https://vimeo.com/110138539', 'jayla' ) ?>" v-model="form.custom_heading_bar_background_settings.background_video_url"></el-input>
						<div style="line-height: normal;"><small><?php echo sprintf(
							'%1$s <el-tooltip content="%4$s" placement="top" popper-class="theme-extends-customize-zindex"><u>Youtube</u></el-tooltip> %2$s <el-tooltip content="%5$s" placement="top" popper-class="theme-extends-customize-zindex"><u>Vimeo</u></el-tooltip> %3$s',
							__('Use video url', 'jayla'),
							__('or', 'jayla'),
							__('for background and parallax effect auto enable.', 'jayla'),
							__('https://www.youtube.com/watch?v=ab0TSkLe-E0', 'jayla'),
							__('https://vimeo.com/110138539', 'jayla')); ?></small></div>
						</el-form-item>
						<br />
					</div>

					<hr /> <br />

					<el-form-item label="<?php esc_attr_e('Background Overlay', 'jayla'); ?>">
						<el-switch
							v-model="form.custom_heading_bar_background_settings.background_overlay_color_display"
							on-text="" off-text=""
							on-value="true"
							off-value="false"></el-switch>
						<small><?php _e('on/off background overlay color.', 'jayla') ?></small>
					</el-form-item>

					<el-form-item v-show="form.custom_heading_bar_background_settings.background_overlay_color_display == 'true'" label="<?php esc_attr_e('Overlay Color', 'jayla'); ?>">
						<el-color-picker v-model="form.custom_heading_bar_background_settings.background_overlay_color" show-alpha></el-color-picker>
						<div style="line-height: normal;"><small><?php _e('choose background overlay color.', 'jayla') ?></small></div>
					</el-form-item>
				</div>
			</transition>
			</el-tab-pane>
		<?php
	}
}

if(! function_exists('jayla_overide_footer_text')) {
	/**
	 * @since 1.0.0
	 * Overide footer right
	 * @param {string} $text
	 *
	 * @return {string}
	 */
	function jayla_overide_footer_text($text) {
		global $jayla_version, $jayla_global;

		return implode(' | ', array(
			$text,
			"⚡ {$jayla_global} {$jayla_version}" . __(', Thank you!', 'jayla'),
		));
	}
}

if(! function_exists('jayla_scroll_top')) {
	/**
	 * @since 1.0.0
	 * Scroll Top template
	 *
	 * @return {html}
	 */
	function jayla_scroll_top() {
		$options = jayla_get_option_type_json('jayla_global_settings', 'jayla_global_settings_default');
		$scrollTop = $options['scroll_top'];
		if($scrollTop['show'] != 'yes') return;

		$design_selector = array(
			array(
				'name' => __('Scroll top wrap', 'jayla'),
				'selector' => '#theme-scroll-top-wrap',
			),
			array(
				'name' => __('Scroll top wrap (:hover)', 'jayla'),
				'selector' => '#theme-scroll-top-wrap:hover',
			),
		);
		?>
		<div id="theme-scroll-top-wrap" data-design-name="<?php echo esc_attr('Scroll Top', 'jayla') ?>" data-design-selector='<?php echo esc_attr(wp_json_encode($design_selector)); ?>'>
			<span class="ion-ios-arrow-up"></span>
		</div>
		<?php
	}
}

if(! function_exists('jayla_furygrid_html_open')) {
	/**
	 * @since 1.0.0
	 * Open furygrid
	 */
	function jayla_furygrid_html_open() {
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		$blog_layout_allow_furygrid = apply_filters( 'jayla_blog_layout_allow_furygrid_filter', array( 'grid' ) );

		$grid_columns = apply_filters( 'jayla_blog_layout_furygrid_opts_filter', array(
			'space' => 36,
			'desktop' => (int) $blog_settings['archive']['layout_grid_col'],
			'tablet' => (int) $blog_settings['archive']['layout_grid_col_tablet'],
			'mobile' => (int) $blog_settings['archive']['layout_grid_col_mobile'],
		) );

		// if ( $blog_settings['archive']['layout'] == 'grid' ) {
		if ( in_array( $blog_settings['archive']['layout'], $blog_layout_allow_furygrid ) ) {
			$grid_opts = json_encode(array(
				'Col' => $grid_columns['desktop'],
				'Space' => $grid_columns['space'],
				'Responsive' => array(
					989 => array(
						'Col' => $grid_columns['tablet'],
					),
					460 => array(
						'Col' => $grid_columns['mobile'],
					)
				)
			));
			?>
			<!-- Open post grid container use system furygrid '.post-grid-container' -->
			<div class="post-grid-container" data-theme-furygrid-options='<?php echo esc_attr($grid_opts); ?>'>
				<div class="furygrid-sizer"></div>
				<div class="furygrid-gutter-sizer"></div>
			<?php
		}
	}
}

if(! function_exists('jayla_furygrid_html_close')) {
	/**
	 * @since 1.0.0
	 * Close furygrid
	 */
	function jayla_furygrid_html_close() {
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		$blog_layout_allow_furygrid = apply_filters( 'jayla_blog_layout_allow_furygrid_filter', array( 'grid' ) );

		// if ( $blog_settings['archive']['layout'] == 'grid' ) {
		if ( in_array( $blog_settings['archive']['layout'], $blog_layout_allow_furygrid ) ) {
			?>
			</div>
			<!-- Close post grid container use system furygrid '.post-grid-container' -->
			<?php
		}
	}
}

if(! function_exists('jayla_post_grid_item_thumbnail_temp')) {
	/**
	 * @since 1.0.0
	 * Post gird thumbnail html
	 *
	 * @return {html}
	 */
	function jayla_post_grid_item_thumbnail_temp() {
		global $post;

		if ( has_post_thumbnail() ) {
			$post_image_src_large = get_the_post_thumbnail_url($post, 'large');
		?>
		<a class="post-thumbnail-entry" href="<?php the_permalink() ?>">
			<?php the_post_thumbnail( 'medium', array(
				'data-themeextends-lazyload-url' => $post_image_src_large,
			) ); ?>
		</a>
		<?php
		}
	}
}

if(! function_exists('jayla_post_grid_item_cat_temp')) {
	/**
	 * @since 1.0.0
	 * Post grid get category
	 *
	 * @return {html}
	 */
	function jayla_post_grid_item_cat_temp() {
		/* translators: used between list items, there is a space after the comma */
		$output = get_the_category_list( ', ' );
		if( ! empty($output) ) {
			$design_selector = wp_json_encode( array(
				array(
					'name' => __('Post grid cat wrap', 'jayla'),
					'selector' => '#page .post-grid-container .furygrid-item .post ._inner .post-item-entry-container .post-cat-entry',
				),
				array(
					'name' => __('Post grid cat item', 'jayla'),
					'selector' => '#page .post-grid-container .furygrid-item .post ._inner .post-item-entry-container .post-cat-entry a',
				),
				array(
					'name' => __('Post grid cat item (:hover)', 'jayla'),
					'selector' => '#page .post-grid-container .furygrid-item .post ._inner .post-item-entry-container .post-cat-entry a:hover',
				),
			) );

			echo implode('', array(
				'<div class="post-cat-entry" data-design-name="'. __('Post grid term', 'jayla') .'" data-design-selector=\''. $design_selector .'\'>',
				$output,
				'</div>' ));
		}
	}
}

if(! function_exists('jayla_post_grid_item_title_temp')) {
	/**
	 * @since 1.0.0
	 * Post grid get title temp
	 *
	 * @return {html}
	 */
	function jayla_post_grid_item_title_temp() {
		$design_selector = wp_json_encode( array(
			array(
				'name' => __('Post grid title', 'jayla'),
				'selector' => '#page .post-grid-container .furygrid-item .post ._inner .post-item-entry-container a.post-title-link',
			),
			array(
				'name' => __('Post grid title (:hover)', 'jayla'),
				'selector' => '#page .post-grid-container .furygrid-item .post ._inner .post-item-entry-container a.post-title-link:hover',
			),
		) );
		?>
		<a class="post-title-link" href="<?php the_permalink() ?>" data-design-name="<?php _e('Post grid title', 'jayla') ?>" data-design-selector='<?php echo esc_attr($design_selector); ?>'>
			<?php the_title(); ?>
		</a>
		<?php
	}
}

if(! function_exists('jayla_post_grid_item_author_temp')) {
	/**
	 * @since 1.0.0
	 * Post grid get author temp
	 *
	 * @return {html}
	 */
	function jayla_post_grid_item_author_temp() {
		$output = get_the_author_link();

		if( ! empty($output) ) {
			echo implode('', array(
				'<div class="post-author-entry">',
				__('Post by', 'jayla'),
				' ',
				get_the_author_posts_link(),
				'</div>' ));
		}
	}
}

if(! function_exists('jayla_post_grid_item_created_temp')) {
	/**
	 * @since 1.0.0
	 * Post grid get post create date temp
	 *
	 * @return {html}
	 */
	function jayla_post_grid_item_created_temp() {
		$output = get_the_date();

		if( ! empty($output) ) {
			echo implode('', array( '<div class="post-created-entry">', $output, '</div>' ));
		}
	}
}

if(! function_exists('jayla_post_grid_item_entry_wrap_open')) {
	/**
	 * @since 1.0.0
	 * Open post grid endtry container
	 */
	function jayla_post_grid_item_entry_wrap_open() {
		?>
		<!-- Open .post-entry-container -->
		<div class="post-item-entry-container" data-design-name="<?php _e('Post grid entry wrap', 'jayla') ?>" data-design-selector='#page .post-grid-container .furygrid-item .post ._inner .post-item-entry-container'>
		<?php
	}
}

if(! function_exists('jayla_post_grid_item_entry_wrap_close')) {
	/**
	 * @since 1.0.0
	 * Close post grid endtry container
	 */
	function jayla_post_grid_item_entry_wrap_close() {
		?>
		</div>
		<!-- Close .post-entry-container -->
		<?php
	}
}

if(! function_exists('jayla_post_grid_item_comment_count_temp')) {
	/**
	 * @since 1.0.0
	 * Comment count post grid item template
	 *
	 * @return {html}
	 */
	function jayla_post_grid_item_comment_count_temp() {
		global $post;
		$comments_count = wp_count_comments($post->ID);
		if($comments_count && (int) $comments_count->total_comments <= 0) return;
		?>
		<div class="post-comment-count" mousetip="" mousetip-pos="top right" mousetip-css-padding="5px 15px" mousetip-css-borderradius="1px" mousetip-css-background="#FFF" mousetip-css-color="#222" mousetip-msg="<?php _e('Comment', 'jayla'); ?>">
			<?php echo sprintf('<span data-toggle="tooltip">%s</span>', $comments_count->total_comments); ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_archive_post_grid_template')) {
	/**
	 * @since 1.0.0
	 * Template blog archive
	 *
	 * @param {html} $output
	 * @return {html}
	 */
	function jayla_archive_post_grid_template($output) {
		global $post;
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		$design_selector = wp_json_encode(array(
			array(
				'name' => __('Post grid item wrap', 'jayla'),
				'selector' => '#page .post-grid-container .furygrid-item .post ._inner',
			),
			array(
				'name' => __('Post grid item wrap (:hover)', 'jayla'),
				'selector' => '#page .post-grid-container .furygrid-item .post ._inner:hover',
			)
		));
		ob_start();
		?>
		<div class="furygrid-item">
			<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-item'); ?> data-theme-extends-scrollreveal>
				<div class="_inner" data-design-name="<?php _e('Post grid item', 'jayla') ?>" data-design-selector='<?php echo esc_attr($design_selector); ?>'>
					<?php
					/**
					 * Hooks
					 * @see  jayla_post_grid_item_thumbnail_temp 		- 20
					 * @see  jayla_post_grid_item_comment_count_temp 	- 20
					 * @see  jayla_post_grid_item_entry_wrap_open 	- 21
					 * @see  jayla_post_grid_item_cat_temp 			- 22
					 * @see  jayla_post_grid_item_title_temp 			- 24
					 * @see  jayla_post_grid_item_author_temp 		- 26
					 * @see  jayla_post_grid_item_created_temp 		- 28
					 * @see  jayla_post_grid_item_entry_wrap_close 	- 30
					 *
					 */
					do_action( 'jayla_post_grid_item_entry' );
					?>
				</div>
			</article>
		</div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_blog_filter_bar_style_inline_html')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_blog_filter_bar_style_inline_html($output, $categories_object) {
		if( empty($categories_object) ) return;
		ob_start();
		$category_queried = get_queried_object();
		$design_selector = wp_json_encode( array(
			array(
				'name' => 'Category filter inline wrap',
				'selector' => '#page .post-category-container.category-filter-inline-ui',
			),
			array(
				'name' => 'Category filter inline item',
				'selector' => '#page .post-category-container.category-filter-inline-ui .cat-item a',
			),
			array(
				'name' => 'Category filter inline item (:hover)',
				'selector' => '#page .post-category-container.category-filter-inline-ui .cat-item a:hover',
			),
			array(
				'name' => 'Category filter inline item (:current)',
				'selector' => '#page .post-category-container.category-filter-inline-ui .cat-item.cat--is-current a',
			),
		) );
		?>
		<div class="post-category-nav-wrap">
			<a href="javascript:" class="post-category--btn-toggle">
				<span class="__icon-toggle-category-nav"></span>
				<?php _e('Category', 'jayla') ?>
			</a>
			<ul class="post-category-container category-filter-inline-ui" data-design-name="<?php _e('Category filter', 'jayla'); ?>" data-design-selector='<?php echo esc_attr($design_selector); ?>'>
				<li class="cat-item <?php echo (empty($category_queried) || !isset($category_queried->term_id)) ? 'cat--is-current' : ''; ?>">
					<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><?php _e('All Articles', 'jayla'); ?></a>
				</li>
				<?php foreach($categories_object as $item) {
					$is_current_class = ($category_queried && $category_queried->term_id && $category_queried->term_id == $item->term_id) ? 'cat--is-current' : '';
					$classes = implode(' ', array(
						'cat-item',
						'cat-id--'. $item->cat_ID,
						'cat--' . $item->slug,
						$is_current_class
					));
					echo apply_filters( 'jayla_blog_category_filter_item', implode('', array(
						'<li class="'. $classes .'">',
							'<a href="'. get_category_link($item->term_id) .'">',
								$item->name,
								' ',
								'<span class="count">'. $item->count .'</span>',
							'</a>',
						'</li>',
					)), $item);
				} ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_blog_filter_bar_style_select_html')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_blog_filter_bar_style_select_html($output, $categories_object) {
		if( empty($categories_object) ) return;
		$category_queried = get_queried_object();
		ob_start();
		$design_selector = wp_json_encode( array(
			array(
				'name' => 'Category filter select wrap',
				'selector' => '#page .post-category-container.category-filter-select-ui',
			),
		) );
		?>
		<div class="post-category-container category-filter-select-ui" data-design-name="<?php _e('Category filter', 'jayla'); ?>" data-design-selector='<?php echo esc_attr($design_selector); ?>'>
			<label>
				<span><?php _e('Filter by', 'jayla'); ?></span>
				<select id="select-filter-post-by-category">
					<option value="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><?php _e('-- Select', 'jayla'); ?></option>
					<?php foreach($categories_object as $item) {
						$selected = ($category_queried && $category_queried->term_id && $category_queried->term_id == $item->term_id) ? 'selected' : '';
						echo '<option '. $selected .' value="'. get_category_link($item->term_id) .'">'. $item->name .' ('. $item->count .')</option>';
					} ?>
				</select>
			</label>
		</div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_furygrid_blog_category_filter_bar')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_furygrid_blog_category_filter_bar() {
		if(! jayla_is_blog()) return;

		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		if($blog_settings['archive']['layout_grid_category_filter_bar'] != 'yes') return;

		$categories_object = get_categories();
		$filter_style = $blog_settings['archive']['layout_grid_category_filter_bar_style'];
		echo apply_filters( 'jayla_blog_filter_bar_style_' . $filter_style, '', $categories_object);
	}
}

if(! function_exists('jayla_single_post_header_temp')) {
	/**
	 * @since 1.0.0
	 * Single post defaut header template
	 *
	 * @return {html}
	 */
	function jayla_single_post_header_temp() {
		$blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
		if($blog_settings['detail']['post_headings'] != 'yes') return;
		?>
		<header class="entry-header">
		<?php
			jayla_posted_on();
			the_title( sprintf(
			'<h2 class="alpha entry-title" data-design-name="%s" data-design-selector="%s"><a href="%s" rel="bookmark">',
			__('Post title', 'jayla'),
			implode(' ', array( '#page', 'article .post__inner.layout-post', '.entry-header', '.entry-title > a' )),
			esc_url( get_permalink() )
			), '</a></h2>' );
		?>
		</header> <!-- .entry-header -->
		<?php
	}
}

if(! function_exists('jayla_post_related_carousel')) {
	/**
	 * @since 1.0.0
	 * Post related carousel template
	 *
	 * @return {html}
	 */
	function jayla_post_related_carousel() {
		get_template_part('templates/post-related/content', 'carousel');
	}
}

if(! function_exists('jayla_related_post_carousel_item_entry')) {
	/**
	 * @since 1.0.0
	 * Post related item entry
	 */
	function jayla_related_post_carousel_item_entry($post_data, $blog_general_options) {
		$thumbnail_html = $term_html = $comment_html = '';
		$post_link = get_the_permalink($post_data);

		// Post thumbnail
		$thumbnail_url = get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg';
		$thumbnail = ($blog_general_options['detail']['post_related_image_placeholder'] == 'yes') ? '<img class="p-thumbnail-placeholder" src="'. esc_url( $thumbnail_url ) .'" alt="'. esc_attr__('related post thumbnail', 'jayla') .'">' : '';
		if(has_post_thumbnail($post_data)) {
			$thumbnail_url = get_the_post_thumbnail_url($post_data, 'large');
			$thumbnail = get_the_post_thumbnail($post_data, 'thumbnail');
		}
		$thumbnail_html = implode('', array(
		'<div class="p-thumbnail-wrap" data-background-image-lazyload-onload="'. esc_attr( $thumbnail_url ) .'" data-hidden-el-onload-success="> a > img">',
			'<a href="'. $post_link .'">', $thumbnail, '</a>',
		'</div>' ));

		// Post term
		$term = get_the_category_list( ', ', '', $post_data->ID );
		$term_link_design_selector = wp_json_encode( array(
			array(
				'name' => __( 'Related post category item link', 'jayla' ),
				'selector' => '#page .post-related-carousel-ui .post-related-item .p-related-entry .p-term-wrap a',
			),
			array(
				'name' => __( 'Related post category item link (:hover)', 'jayla' ),
				'selector' => '#page .post-related-carousel-ui .post-related-item .p-related-entry .p-term-wrap a:hover',
			),
		) );
		if($term) {
			$term_html = implode('', array( '<div class="p-term-wrap" data-design-name="'. __('Related post category link item', 'jayla') .'" data-design-selector=\''. $term_link_design_selector .'\'>', $term, '</div>' ));
		}

		// Post comment
		$comments_count = wp_count_comments($post_data->ID);
		if($comments_count && (int) $comments_count->total_comments > 0) {
			$comment_html = implode('', array(
				'<div class="post-comment-count" mousetip="" mousetip-pos="top right" mousetip-css-padding="5px 15px" mousetip-css-borderradius="1px" mousetip-css-background="#FFF" mousetip-css-color="#222" mousetip-msg="'. __('Comment', 'jayla') .'">',
					'<span data-toggle="tooltip">',
						$comments_count->total_comments,
					'</span>',
				'</div>'
			));
		}

		$title_design_selector = wp_json_encode( array(
			array(
				'name' => __( 'Related post title', 'jayla' ),
				'selector' => '#page .post-related-carousel-ui .post-related-item .p-related-entry a.p-title-link',
			),
			array(
				'name' => __( 'Related post title (:hover)', 'jayla' ),
				'selector' => '#page .post-related-carousel-ui .post-related-item .p-related-entry a.p-title-link:hover',
			),
		) );


		?>
		<div class="_inner">
			<?php echo implode('', array(
				$thumbnail_html,
				$comment_html,
				'<div class="p-related-entry">',
					$term_html,
					'<a class="p-title-link" href="'. $post_link .'" data-design-name="'. __('Related post title', 'jayla') .'" data-design-selector=\''. $title_design_selector .'\'>',
						get_the_title($post_data),
					'</a>',
					'<div class="p-author">',
						__('Post by', 'jayla'), ' ',
						get_the_author_posts_link(),
					'</div>',
				'</div>',
			)); ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_post_loop_search_temp')) {
	/**
	 * @since 1.0.0
	 * Search post item template
	 *
	 * @return {html}
	 */
	function jayla_post_loop_search_temp() {
		get_template_part( 'templates/post/content', 'search' );
	}
}

if(! function_exists('jayla_filter_the_content_is_blog_page')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_filter_the_content_is_blog_page( $content ) {
		global $post;
		if( ! is_page() || ! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) return $content;

		$page_is_blog = carbon_get_post_meta( get_the_ID(), 'page_is_blog' );
		if( $page_is_blog == false ) return $content;

		$blog_custom_layout = carbon_get_post_meta( get_the_ID(), 'blog_custom_layout' );
		add_filter( 'comments_open', '__return_false' );

		ob_start();

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			'post_type' => 'post',
			'paged' => $paged,
		);
		query_posts($args);

		if( ! empty($blog_custom_layout) ){
			do_action( 'jayla_custom_blog_before_loop' );
			do_action( 'jayla_the_content_is_blog_page_layout_' . $blog_custom_layout );
			do_action( 'jayla_custom_blog_after_loop' );

			wp_reset_query();
		} else {

			query_posts($args);
			get_template_part( 'loop' );
			wp_reset_query();
		}

		return ob_get_clean();
	}
}

if(! function_exists('jayla_blog_layout_first_item_full')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_blog_layout_first_item_full() {


		$template = array(
			'first_item' => implode('', array(
				'<article {{article_attr_id}} {{article_attr_class}} data-theme-extends-scrollreveal>',
					'<a class="p-thumbnail" href="{{post_link}}">',
						'{{post_image_html}}',
						'{{comment_count_html}}',
					'</a>',
					'<div class="post-entry">',
						'<div class="p-extra-cat">{{post_cat_html}}</div>',
						'<h3><a class="p-title" href="{{post_link}}">{{post_title}}</a></h3>',
						'<div class="p-des">{{p_des}}</div>',
						'<div class="p-extra-author">',
							'<a class="author-avatar" href="{{post_author_link}}">{{author_avatar_html}}</a>',
							'<div class="author-entry">',
								'<div class="p-date">{{post_date}}</div>',
								'<div class="p-author">'. __('by', 'jayla') .' <a href="{{post_author_link}}">{{post_author_name}}</a></div>',
							'</div>',
						'</div>',
					'</div>',
				'</article>',
			)),
			'other' => implode('', array(
				'<article {{article_attr_id}} {{article_attr_class}} data-theme-extends-scrollreveal>',
					'<a class="p-thumbnail" href="{{post_link}}">',
						'{{post_image_html}}',
						'{{comment_count_html}}',
					'</a>',
					'<div class="post-entry">',
						'<div class="p-extra-cat">{{post_cat_html}}</div>',
						'<h3><a class="p-title" href="{{post_link}}">{{post_title}}</a></h3>',
						'<div class="p-extra-author">',
							'<a class="author-avatar" href="{{post_author_link}}">{{author_avatar_html}}</a>',
							'<div class="author-entry">',
								'<div class="p-date">{{post_date}}</div>',
								'<div class="p-author">'. __('by', 'jayla') .' <a href="{{post_author_link}}">{{post_author_name}}</a></div>',
							'</div>',
						'</div>',
					'</div>',
				'</article>',
			)),
		);

		if ( have_posts() ) :
			$nth = 1;
			$output = array();

			$furygrid_options = wp_json_encode( array(
				'Col' => 3,
				'Space' => 36,
				'Responsive' => array(
					'989' => array(
						'Col' => 2,
					),
					'460' => array(
						'Col' => 1,
					)
				)
			) );

			array_push($output, '<div class="blog-container blog-layout-first-item-full" data-theme-furygrid-options=\''. $furygrid_options .'\'>');
			array_push($output, '<div class="furygrid-sizer"></div>');
			array_push($output, '<div class="furygrid-gutter-sizer"></div>');
			while ( have_posts() ) : the_post();
				$post_class = get_post_class();

				$post_image_html = '<img class="__placeholder-image" src="'. esc_url( get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg' ) .'" alt="'. the_title_attribute( 'echo=0' ) .'" title="'. the_title_attribute( 'echo=0' ) .'">';
				if(has_post_thumbnail()) {
					$post_image_src_large = get_the_post_thumbnail_url(get_the_ID(), 'large');
					$post_image_html = get_the_post_thumbnail( get_the_ID(), 'medium', array(
						'data-themeextends-lazyload-url' => $post_image_src_large,
					) );
				}

				$classes_first_item = ($nth == 1) ? 'p-first-item' : '';

				$comments_count = wp_count_comments( get_the_ID() );
				$comment_count_html = ( ! empty($comments_count->approved) && $comments_count->approved > 0 ) ? '<div class="p-comment-count"><span class="ion-chatbubble"></span> ' . $comments_count->approved . '</div>' : '';

				$variable_replace = array(
					'{{article_attr_id}}' => 'id="'. 'post-' . get_the_ID() .'"',
					'{{article_attr_class}}' => 'class="'. implode(' ', $post_class) . ' ' . $classes_first_item .'"',
					'{{post_image_html}}' => $post_image_html,
					'{{post_link}}' => get_the_permalink(),
					'{{post_title}}' => get_the_title(),
					'{{p_des}}' => jayla_get_excerpt(120),
					'{{post_date}}' => get_the_date(),
					'{{post_cat_html}}' => get_the_category_list(', '),
					'{{author_avatar_html}}' => get_avatar( get_the_author_meta('user_email'), $size = '60'),
					'{{post_author_name}}' => get_the_author(),
					'{{post_author_link}}' => get_author_posts_url( get_the_author_meta('ID') ),
					'{{comment_count_html}}' => $comment_count_html,
				);

				if($nth == 1) {
					array_push($output, implode('', array(
						'<div class="furygrid-item furygrid-grid-first-item">',
							str_replace( array_keys($variable_replace), array_values($variable_replace), $template['first_item'] ),
						'</div>',
					)));
				} else {
					array_push($output, implode('', array(
						'<div class="furygrid-item">',
							str_replace( array_keys($variable_replace), array_values($variable_replace), $template['other'] ),
						'</div>',
					)));
				}

				$nth += 1;
			endwhile;
			array_push($output, '</div>');

			echo implode('', $output);
		else :
			get_template_part( 'content', 'none' );
		endif;
	}
}

if(! function_exists('jayla_blog_layout_featured_post_slide')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_blog_layout_featured_post_slide() {
		$output = array();
		$featured_post_slide = carbon_get_post_meta( get_the_ID(), 'featured_post_slide' );
		$template = array(
			'default' => implode('', array(
				'<article {{article_attr_id}} {{article_attr_class}} data-theme-extends-scrollreveal>',
					'<div class="p-author-meta">',
						'{{author_avatar_html}}',
						'<a class="p-author-link" href="{{post_author_link}}">{{post_author_name}}</a>',
					'</div>',
					'{{comment_count_html}}',
					'<a class="p-thumbnail" href="{{post_link}}">{{post_image_html}}</a>',
					'<div class="p-entry">',
						'<h3><a class="p-title" href="{{post_link}}">{{post_title}}</a></h3>',
						'<div class="p-des">{{p_des}}</div>',
						'<div class="p-extra-meta">',
							'<div class="p-date">{{post_date}}</div>',
							'<div class="p-cat">{{post_cat_html}}</div>',
						'</div>',
					'</div>',
				'</article>',
			))
		);

		array_push($output, '<div class="blog-custom-layout-featured-post-slide">');

		// slide
		array_push($output, jayla_post_slide_by_ids($featured_post_slide));

		// loop
		if ( have_posts() ) :
			array_push($output, '<div class="row justify-content-center">');
			array_push($output, '<div class="col-md-8 ">');
			array_push($output, '<div class="blog-custom-layout-instagram-one-col">');
			while ( have_posts() ) : the_post();
				$post_class = get_post_class();
				$post_class = get_post_class();

				$post_image_html = '<img class="__placeholder-image" src="'. esc_url( get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg' ) .'" alt="'. the_title_attribute( 'echo=0' ) .'" title="'. the_title_attribute( 'echo=0' ) .'">';
				if(has_post_thumbnail()) {
					$post_image_src_large = get_the_post_thumbnail_url(get_the_ID(), 'large');
					$post_image_html = get_the_post_thumbnail( get_the_ID(), 'medium', array(
						'data-themeextends-lazyload-url' => $post_image_src_large,
					) );
				}

				$comments_count = wp_count_comments( get_the_ID() );
				$comment_count_html = ( ! empty($comments_count->approved) && $comments_count->approved > 0 ) ? '<div class="p-comment-count"><span class="ion-chatbubble"></span> ' . $comments_count->approved . '</div>' : '';

				$variable_replace = array(
					'{{article_attr_id}}' => 'id="'. 'post-' . get_the_ID() .'"',
					'{{article_attr_class}}' => 'class="'. implode(' ', $post_class) .'"',
					'{{post_image_html}}' => $post_image_html,
					'{{post_link}}' => get_the_permalink(),
					'{{post_title}}' => get_the_title(),
					'{{p_des}}' => jayla_get_excerpt(120),
					'{{post_date}}' => get_the_date(),
					'{{post_cat_html}}' => get_the_category_list(', '),
					'{{author_avatar_html}}' => get_avatar( get_the_author_meta('user_email'), $size = '60'),
					'{{post_author_name}}' => get_the_author(),
					'{{post_author_link}}' => get_author_posts_url( get_the_author_meta('ID') ),
					'{{comment_count_html}}' => $comment_count_html,
				);

				array_push($output, str_replace( array_keys($variable_replace), array_values($variable_replace), $template['default'] ));
			endwhile;
			array_push($output, '</div>');
			array_push($output, '</div>');
			array_push($output, '</div>');
		endif;

		array_push($output, '</div>');

		echo implode('', $output);
	}
}

if(! function_exists('jayla_post_slide_by_ids')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_post_slide_by_ids($ids = array(), $slide_opts = array()) {
		if( empty($ids) || count($ids) <= 0 ) return;
		$args = array(
			'post_type' => 'post',
			'post__in' => $ids,
		);
		$the_query = new WP_Query( $args );
		$output = array();
		$template = array(
			'default' => implode('', array(
				'<article {{article_attr_id}} {{article_attr_class}}>',
					'<div class="p-extra-cat" data-swiper-parallax="-300" data-swiper-parallax-opacity="0">{{post_cat_html}}</div>',
					'<h3><a class="p-title" href="{{post_link}}" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">{{post_title}}</a></h3>',
					'<a class="p-thumbnail" href="{{post_link}}" data-swiper-parallax-opacity="0" data-background-image-lazyload-onload="{{post_image_large_url}}" data-hidden-el-onload-success="img">',
						'<div class="p-date">{{post_date}}</div>',
						'{{post_image_html}}',
					'</a>',
					'<div class="post-entry" data-swiper-parallax="-100" data-swiper-parallax-opacity="0">',
						'<div class="p-des"><a class="read-more theme-extends-read-more" href="{{post_link}}">Read More <i class="ion-android-arrow-forward"></i></a></div>',
					'</div>',
				'</article>',
			)),
		);

		if ( $the_query->have_posts() ) {
			$swiper_opts = wp_json_encode( array(
				'slidesPerView' => 3,
				'spaceBetween' => 30,
				'loop' => true,
				'pagination' => array(
					'el' => '.__blog-slide-pagination',
					'clickable' => true,
				),
				'navigation' => array(
					'nextEl' => '.__blog-slide-button-next',
					'prevEl' => '.__blog-slide-button-prev',
				),
				'breakpoints' => array(
					960 => array(
						'slidesPerView' => 2,
						'spaceBetween' => 30,
					),
					460 => array(
						'slidesPerView' => 1,
						'spaceBetween' => 30,
					),
				)
				// 'parallax' => true,
				// 'centeredSlides' => true,
			) );

			array_push( $output, '<div class="post-slide-by-ids __layout-default swiper-container" data-themeextends-swiper=\''. $swiper_opts .'\'>' );
			array_push( $output, '<div class="swiper-wrapper">' );
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$post_class = get_post_class();

				$post_image_src_large = get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg';
				$post_image_html = '<img class="__placeholder-image" src="'. esc_url( $post_image_src_large ) .'" alt="'. the_title_attribute( 'echo=0' ) .'" title="'. the_title_attribute( 'echo=0' ) .'">';

				if(has_post_thumbnail()) {
					$post_image_src_large = get_the_post_thumbnail_url(get_the_ID(), 'large');
					$post_image_html = get_the_post_thumbnail( get_the_ID(), 'thumbnail', array(

					) );
				}

				$variable_replace = array(
					'{{article_attr_id}}' => 'id="'. 'post-' . get_the_ID() .'"',
					'{{article_attr_class}}' => 'class="'. implode(' ', $post_class) . '"',
					'{{post_image_html}}' => $post_image_html,
					'{{post_link}}' => get_the_permalink(),
					'{{post_title}}' => get_the_title(),
					'{{p_des}}' => jayla_get_excerpt(120),
					'{{post_date}}' => get_the_date(),
					'{{post_cat_html}}' => get_the_category_list(', '),
					'{{author_avatar_html}}' => get_avatar( get_the_author_meta('user_email'), $size = '60'),
					'{{post_author_name}}' => get_the_author(),
					'{{post_author_link}}' => get_author_posts_url( get_the_author_meta('ID') ),
					'{{post_image_large_url}}' => $post_image_src_large,
				);

				array_push( $output, implode('', array(
					'<div class="swiper-slide p-item">',
						str_replace( array_keys($variable_replace), array_values($variable_replace), $template['default'] ),
					'</div>',
				)) );
			}
			array_push( $output, '</div>' );
			array_push( $output, '<div class="swiper-pagination __blog-slide-pagination"></div>' );
			array_push( $output, '<div class="swiper-button-next __blog-slide-button-next"></div><div class="swiper-button-prev __blog-slide-button-prev"></div>' );
			array_push( $output, '</div>' );
		}

		wp_reset_postdata();
		return implode('', $output);
	}
}

if(! function_exists('jayla_post_single_clean_entry_content')) {
	function jayla_post_single_clean_entry_content() {
		global $post;
		?>
		<div class="col-12">
			<div class="heading-meta-entry"><?php do_action( 'jayla_post_single_clean_meta_entry_top' ); ?></div>
			<div class="entry-content" >
				<?php
					/**
					 * Functions hooked in to jayla_post_content_before action.
					 *
					 * @hooked jayla_post_thumbnail - 10
					 */
					do_action( 'jayla_post_content_before' );

					$content_design_selector = apply_filters( 'jayla_single_content_design_selector', array(
						array(
							'name' => __('Post single content wrap', 'jayla'),
							'selector' => '#page article .post__inner.layout-post .content-text',
						),
						array(
							'name' => __('Post single content link', 'jayla'),
							'selector' => '#page article .post__inner.layout-post .content-text a',
						),
						array(
							'name' => __('Post single content link (:hover)', 'jayla'),
							'selector' => '#page article .post__inner.layout-post .content-text a:hover',
						),
					) );
				?>
				<div
					class="content-text"
					data-design-name="<?php echo esc_attr('Post single content', 'jayla') ?>"
					data-design-selector='<?php echo esc_attr( wp_json_encode( $content_design_selector ) ); ?>'>
					<?php the_content(); ?>
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
		<?php
	}
}

if(! function_exists('jayla_post_single_clean_meta_entry_template')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_post_single_clean_meta_entry_template() {
		global $post;

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( ', ' );
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', ', ' );
		?><aside class="clearn-entry-meta themeextends-post-clearn-entry-meta">
			<div class="post-entry-meta__inner">
				<div class="p-on">
					<?php
						echo get_avatar( get_the_author_meta( 'ID' ), 128 );
						echo jayla_posted_on(__('Posted on %s', 'jayla'));
					?>
					<div class="p-meta-tag">
						<div class="p-author">
							<?php
								echo '<div class="label">' . esc_attr( __( 'by', 'jayla' ) ) . '</div>';
								the_author_posts_link();
							?>
						</div>

						<?php
						if ( $categories_list ) : ?>
							<div class="p-cat-links">
								<?php
								echo '<div class="label" title="'. esc_attr__( 'Posted in', 'jayla' ) .'"><i class="ion-android-folder" aria-hidden="true"></i></div>';
								echo wp_kses_post( $categories_list );
								?>
							</div>
						<?php endif; // End if categories. ?>

						<?php
						if ( $tags_list ) : ?>
							<div class="p-tags-links">
								<?php
								echo '<div class="label" title="'. esc_attr__( 'Tagged', 'jayla' ) .'"><i class="ion-pricetag" aria-hidden="true"></i></div>';
								echo wp_kses_post( $tags_list );
								?>
							</div>
						<?php endif; // End if $tags_list. ?>

						<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
							<span class="p-comments-link"><?php comments_popup_link( __( 'Leave a comment', 'jayla' ), __( '1 Comment', 'jayla' ), __( '% Comments', 'jayla' ) ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</aside><?php
	}
}

if(! function_exists('jayla_post_single_clean_meta_tag_template')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_post_single_clean_meta_tag_template() {
		global $post;
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( ', ' );
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', ', ' );

		// check tag exist
		if( empty($categories_list) && empty($tags_list) ) return;
		?>
		<div class="col-12">
			<div class="themeextends-post-clearn-entry-tag-wrap">
				<?php
				if ( $categories_list ) : ?>
					<div class="p-cat-links">
						<?php
						echo '<div class="label" title="'. esc_attr__( 'Posted in', 'jayla' ) .'"><i class="fa fa-folder-open" aria-hidden="true"></i></div>';
						echo wp_kses_post( $categories_list );
						?>
					</div>
				<?php endif; // End if categories. ?>

				<?php
				if ( $tags_list ) : ?>
					<div class="p-tags-links">
						<?php
						echo '<div class="label" title="'. esc_attr__( 'Tagged', 'jayla' ) .'"><i class="fa fa-hashtag" aria-hidden="true"></i></div>';
						echo wp_kses_post( $tags_list );
						?>
					</div>
				<?php endif; // End if $tags_list. ?>
			</div>
		</div>
		<?php
	}
}

if(! function_exists('jayla_post_added_likes_button')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_post_added_likes_button() {
		global $post;
		$like_count = (int) jayla_get_post_likes( get_the_ID() );
		ob_start();
		?>
		<a
			href="<?php the_permalink(); ?>"
			class="themeextends-like-post-button"
			data-p-id="<?php the_ID(); ?>" title="<?php esc_attr_e('Like', 'jayla'); ?>"
			data-themeextends-button-like-post>
			<span class="ion-ios-heart"></span>
			<div class="count"><?php echo apply_filters( 'jayla_jetpack_portfolio_likes_count_number', $like_count ) ?></div>
		</a>
		<?php
		echo apply_filters( 'jayla_post_added_likes_button_ui', ob_get_clean() );
	}
}

if(! function_exists('jayla_search_icon_svg')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_search_icon_svg( $icon_name ) {
		$svg_icons = apply_filters( 'jayla_search_icon_svg_filter', array(
			'search_basic' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512"> <g> <path d="m495,466.1l-110.1-110.1c31.1-37.7 48-84.6 48-134 0-56.4-21.9-109.3-61.8-149.2-39.8-39.9-92.8-61.8-149.1-61.8-56.3,0-109.3,21.9-149.2,61.8-39.9,39.8-61.8,92.8-61.8,149.2 0,56.3 21.9,109.3 61.8,149.2 39.8,39.8 92.8,61.8 149.2,61.8 49.5,0 96.4-16.9 134-48l110.1,110c8,8 20.9,8 28.9,0 8-8 8-20.9 0-28.9zm-393.3-123.9c-32.2-32.1-49.9-74.8-49.9-120.2 0-45.4 17.7-88.2 49.8-120.3 32.1-32.1 74.8-49.8 120.3-49.8 45.4,0 88.2,17.7 120.3,49.8 32.1,32.1 49.8,74.8 49.8,120.3 0,45.4-17.7,88.2-49.8,120.3-32.1,32.1-74.9,49.8-120.3,49.8-45.4,0-88.1-17.7-120.2-49.9z"/> </g> </svg>',
			'search_2' => '<svg version="1.1" id="jayla_widget_icon_search_layer_search_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 53.627 53.627" style="enable-background:new 0 0 53.627 53.627;" xml:space="preserve"> <path d="M53.627,49.385L37.795,33.553C40.423,30.046,42,25.709,42,21C42,9.42,32.58,0,21,0S0,9.42,0,21s9.42,21,21,21 c4.709,0,9.046-1.577,12.553-4.205l15.832,15.832L53.627,49.385z M2,21C2,10.523,10.523,2,21,2s19,8.523,19,19s-8.523,19-19,19 S2,31.477,2,21z"/> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',
		) );

		return $svg_icons[$icon_name];
	}
}

if(! function_exists('jayla_wishlist_icon_svg')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_wishlist_icon_svg( $icon_name ) {
		$svg_icons = apply_filters( 'jayla_wishlist_icon_svg_filter', array(
			'default' => '<svg version="1.1" id="jayla_widget_icon_heart_default" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 979.494 979.494" style="enable-background:new 0 0 979.494 979.494;" xml:space="preserve"> <g> <g> <path d="M964.616,227.519c-15.63-44.595-43.082-84.824-79.389-116.338c-36.341-31.543-80.051-53.048-126.404-62.188 c-17.464-3.444-35.421-5.19-53.371-5.19c-52.371,0-103.306,14.809-147.296,42.827c-26.482,16.867-49.745,38.022-68.908,62.484 c-19.158-24.415-42.405-45.53-68.859-62.364C376.42,58.773,325.52,43.985,273.189,43.985c-0.003,0,0.001,0-0.001,0 c-43.604,0-87.367,10.77-126.546,31.143c-39.15,20.358-73.104,49.978-98.188,85.658C22.752,197.343,7.096,238.278,1.92,282.453 c-4.532,38.687-1.032,80.217,10.405,123.436c22.656,85.615,72.803,163.707,110.882,214.142 c82.795,109.659,196.636,209.196,348.028,304.301l18.085,11.36l18.086-11.36C693.624,807.35,823.602,683.842,904.764,546.749 c46.678-78.844,70.994-149.084,74.343-214.733C980.972,295.429,976.096,260.271,964.616,227.519z M489.322,855.248 c-135.253-87.096-237.398-177.586-311.846-276.192c-34.407-45.571-79.583-115.623-99.414-190.562 c-9.245-34.937-12.14-67.951-8.604-98.128c3.846-32.824,15.494-63.262,34.623-90.47c18.844-26.803,44.41-49.085,73.932-64.436 c29.533-15.357,62.444-23.474,95.176-23.474c39.377,0,77.654,11.113,110.692,32.136c32.204,20.492,58.094,49.399,74.868,83.596 l30.559,62.292l30.505-62.318c16.759-34.238,42.648-63.183,74.872-83.705c33.057-21.054,71.358-32.182,110.767-32.182 c13.544,0,27.074,1.314,40.216,3.905c34.739,6.85,67.585,23.042,94.986,46.826c27.39,23.774,48.064,54.023,59.79,87.476 c8.547,24.385,12.164,50.811,10.75,78.542c-2.772,54.379-24.017,114.42-64.944,183.553 C773.338,635.262,656.457,747.659,489.322,855.248z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',
		) );

		return $svg_icons[$icon_name];
	}
}

if(! function_exists('jayla_custom_search_template')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_custom_search_template() {
		?>
		<div class="theme-extends-custom-search-wrapper theme-extends-custom-search-ajax-js">
			<div class="custom-search-container">
				<div class="search-form-container">
					<a href="javascript:" class="__close" title="<?php esc_attr_e( 'Close', 'jayla' ); ?>">×</a>
					<?php get_search_form(true); ?>
				</div>
				<div class="result-search-content-wrapper">
					<!-- Ajax result content -->
				</div>
			</div>
		</div>
		<?php
	}
}

if(! function_exists('jayla_item_search_result_template')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_item_search_result_template() {
		global $post;
		$postType = get_post_type_object(get_post_type());
		$thumbnail_html = '';
		$posttype_html = '';

		if( has_post_thumbnail( $post ) ) {
			$thumbnail_html = '<a href="'. get_the_permalink() .'" class="p-thumbnail">'. get_the_post_thumbnail( $post, 'thumbnail', array( 'class' => 'p-thumbnail-image' ) ) .'</a>';
		}
		if( ! empty( $postType ) ) {
			$posttype_html = '<sup class="p-posttype-label">'. $postType->labels->singular_name .'</sup>';
		}
		ob_start();
		?>
		<?php echo "{$thumbnail_html}"; ?>
		<div class="entry-content">
			<a href="<?php the_permalink() ?>" class="title-link">
				<h4 class="title"><?php the_title(); ?> <?php echo "{$posttype_html}"; ?></h4>
			</a>
			<div class="extra-entry-meta">
				<div class="p-author">
					<?php _e( 'by', 'jayla' ) ?> <a href="<?php echo get_author_posts_url( $post->post_author ); ?>"><?php the_author(); ?></a>
				</div>
				<div class="p-date"><?php echo get_the_date(); ?></div>
			</div>
		</div>
		<?php
		echo apply_filters( 'jayla_item_search_result_template_filter', ob_get_clean() );
	}
}

if(! function_exists('jayla_custom_search_before_result')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_custom_search_before_result($query, $data) {
		extract( $data );
		$found_posts = $query->found_posts;
		$result_text = ( 0 >= $found_posts )
			? __( 'Sorry, no results were found.', 'jayla' )
			: sprintf( _n( '%s Result for', '%s Results for:', $found_posts, 'jayla' ) . ' <span class="search-text">%s</span>' . ' │ ' . '<a href="%s">'. __( 'Get All Results', 'jayla' ) .'</a>', $found_posts, $s, get_search_link( $s ) );
		?>
		<div class="theme-extends-header-result-custom-search">
			<i class="fa fa-search" aria-hidden="true"></i> — <?php echo "{$result_text}"; ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_custom_search_after_result')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_custom_search_after_result() {

	}
}

if(! function_exists('jayla_content_search_item_after_meta_tags_post_cat')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_content_search_item_after_meta_tags_post_cat() {
		global $post;
		$posttype = get_post_type( $post );
		if( 'post' != $posttype ) return;
		$cat_list_html = get_the_category_list( __( ', ', 'jayla' ) );
		if( empty( $cat_list_html ) ) return;
		?>
		<div class="p-in-cat">
			<i class="fa fa-folder" aria-hidden="true" title="<?php esc_attr_e( 'Posted in', 'jayla' ) ?>"></i> <?php echo "{$cat_list_html}"; ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_content_search_item_after_meta_tags_post_tag')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_content_search_item_after_meta_tags_post_tag() {
		global $post;
		$posttype = get_post_type( $post );
		if( 'post' != $posttype ) return;
		$tag_list_html = get_the_tag_list( __( ', ', 'jayla' ) );
		if( empty( $tag_list_html ) ) return;
		?>
		<div class="p-tag">
			<i class="fa fa-tag" aria-hidden="true" title="<?php esc_attr_e( 'Tagged', 'jayla' ) ?>"></i> <?php echo get_the_tag_list( '', __( ', ', 'jayla' ) ); ?>
		</div>
		<?php
	}
}