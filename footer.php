<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package jayla
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'jayla_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo" data-design-name="<?php esc_attr_e('Footer', 'jayla'); ?>" data-design-selector="#page .site-footer">
		<div class="col-full">
			<?php
			/**
			 * Functions hooked in to jayla_footer action
			 *
			 * @hooked jayla_footer_builder - 10
			 * @hooked jayla_credit         - 20
			 */
			do_action( 'jayla_footer' ); ?>
		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'jayla_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
