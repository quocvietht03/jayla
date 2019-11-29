<?php
/**
 * Newsletter lightbox - template default
 * @version 1.0.0 
 */

$dnl_heading_text = carbon_get_theme_option( 'dnl_heading_text' );
$dnl_content_text = carbon_get_theme_option( 'dnl_content_text' );
$dnl_layout_photo = carbon_get_theme_option( 'dnl_layout_photo' );

$dnl_show_by = carbon_get_theme_option( 'dnl_show_by' );
$dnl_after_seconds_to_show = carbon_get_theme_option( 'dnl_after_seconds_to_show' );
$dnl_after_scrolldown_to_show = carbon_get_theme_option( 'dnl_after_scrolldown_to_show' );

$dnl_newsletter_image = empty( $dnl_layout_photo ) ? get_template_directory_uri() . '/assets/images/core/newsletter-bg.jpg' : $dnl_layout_photo;
?>
<div 
    id="delipress-newsletter-lightbox-element" 
    class="delipress-newsletter-lightbox-wrap" 
    data-dnl-show-by="<?php echo esc_attr($dnl_show_by); ?>" 
    data-dnl-after-seconds-to-show="<?php echo esc_attr($dnl_after_seconds_to_show); ?>"
    data-dnl-after-scrolldown-to-show="<?php echo esc_attr($dnl_after_scrolldown_to_show); ?>">
    <div class="dnl-newsletter-lightbox-container __layout-default">
        <a href="javascript:" class="__newsletter-lightbox-close"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div class="dnl-entry">
            <h3 class="dnl-heading-text"><?php echo "{$dnl_heading_text}"; ?></h3>
            <div class="dnl-content"><?php echo "{$dnl_content_text}"; ?></div>
            <?php do_action( 'jayla_delipress_newsletter_lightbox_form', 'default' ); ?>
        </div>
        <div class="dnl-image" style="background: url(<?php echo esc_attr($dnl_newsletter_image); ?>)">

        </div>
    </div>
</div>
<a href="<?php echo esc_url( '#' ); ?>" id="delipress-newsletter-lightbox-element__open" class="delipress-newsletter-lightbox__open">
    <img src="<?php echo get_template_directory_uri() . '/assets/images/svg-icons/sent-mail.svg' ?>" alt="<?php esc_attr_e('Open newsletter', 'jayla') ?>" />
</a>