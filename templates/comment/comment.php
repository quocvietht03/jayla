<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package jayla
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<section
  id="comments"
  class="comments-area theme-extends-comments-area comments-template-default"
  aria-label="<?php esc_html_e( 'Post Comments', 'jayla' ); ?>"
  data-design-name="<?php esc_attr_e( 'Comments area', 'jayla' ) ?>"
  data-design-selector="#page .theme-extends-comments-area.comments-template-default">

	<?php
	if ( have_comments() ) : ?>
		<h2
      class="comments-title"
      data-design-name="<?php esc_attr_e( 'Comment title', 'jayla' ) ?>"
      data-design-selector="<?php echo esc_attr( '#page .theme-extends-comments-area.comments-template-default .comments-title' ); ?>">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'jayla' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation" aria-label="<?php esc_html_e( 'Comment Navigation Above', 'jayla' ); ?>">
			<span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'jayla' ); ?></span>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'jayla' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'jayla' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback'   => 'jayla_comment',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation" aria-label="<?php esc_html_e( 'Comment Navigation Below', 'jayla' ); ?>">
			<span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'jayla' ); ?></span>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'jayla' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'jayla' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation.

	endif;

	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'jayla' ); ?></p>
	<?php endif;

	$args = apply_filters( 'jayla_comment_form_args', array(
		'title_reply_before' => '<span id="reply-title" class="gamma comment-reply-title" data-design-name="'. __('Title reply', 'jayla') .'" data-design-selector="#page .comment-respond .comment-reply-title">',
		'title_reply_after'  => '</span>',
	) );

	comment_form( $args ); ?>

</section><!-- #comments -->
