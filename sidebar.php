<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package jayla
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<div class="<?php do_action('jayla_sidebar_class'); ?>"> <!-- pull-md-9 -->
	<div id="secondary" class="widget-area" role="complementary" <?php do_action('jayla_sidebar_sticky_attr'); ?>>
		<div class="widget-area__inner">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div><!-- #secondary -->
</div>
