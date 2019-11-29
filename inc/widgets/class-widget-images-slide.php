<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Images Slide
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Images_Slide extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_images_slide',
            __('Theme Widget - Images Slide', 'jayla'),
            __('Displays a images slide (banners)', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )->set_default_value( __('Banner', 'jayla') ) ,
                Field::make( 'complex', 'images_slide_data', 'Images Slide' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( array(
                    Field::make( 'image', 'image', __('Image', 'jayla') ),
                    Field::make( 'text', 'name', __('Name', 'jayla') ),
                    Field::make( 'text', 'url', __('Url', 'jayla') ),
                ) ),
                Field::make( 'checkbox', 'slide_auto_play', __('Slide auto play', 'jayla') ),
                Field::make( 'checkbox', 'open_on_new_window', __('Open on new window', 'jayla') ),
        ) );
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo implode('', array($args['before_title'], $instance['title'], $args['after_title']));

        $images_slide_data = $instance['images_slide_data'];
        if( empty($images_slide_data) || count($images_slide_data) == 0 ) return;

        $slide_opts = wp_json_encode( array(
            'infinite' => true,
            'slidesToShow' => 1,
            'slidesToScroll' => 1,
            'dots' => true,
            'arrows' => false,
            'autoplay' => (int) $instance['slide_auto_play'],
            'autoplaySpeed' => 2000,
        ) );
        $open_new_tab = ($instance['open_on_new_window'] == true) ? 'target="_blank"' : '';
        ?>
        <div class="theme-extends-widget-images-slide">
            <div class="__inner" data-theme-extends-slick-carousel='<?php echo esc_attr($slide_opts); ?>'>
                <?php
                foreach($images_slide_data as $item) {
                    // image default
                    $image_src = get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg';

                    $attachment_data = wp_get_attachment_image_src($this->get_complex_field('image', $item), 'large');
                    if(! empty($attachment_data)) { $image_src = $attachment_data[0]; }

                    echo implode('', array(
                        '<div class="__item">',
                            '<a href="'. esc_url( $this->get_complex_field('url', $item) ) .'" '. $open_new_tab .'>',
                                '<img src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $this->get_complex_field('name', $item) ) .'" title="'. esc_attr( $this->get_complex_field('name', $item) ) .'">',
                            '</a>',
                        '</div>'
                    ));
                }
                ?>
            </div>
        </div>
        <?php
    }
}
