<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Branding Gallery
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Branding extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_branding',
            __('Theme Widget - Branding Gallery', 'jayla'),
            __('Displays a grid brading gallery 1-4 columns', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )->set_default_value( __('Branding', 'jayla') ) ,
                Field::make( 'complex', 'branding_gallery_data', 'Branding Gallery' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( array(
                    Field::make( 'image', 'image', __('Image', 'jayla') ),
                    Field::make( 'text', 'name', __('Name', 'jayla') ),
                    Field::make( 'text', 'url', __('Url', 'jayla') ),
                ) ),
                Field::make( 'select', 'branding_gallery_column', __('Column(s)', 'jayla') )
                ->add_options( array(
                    '1' => __('1 Column', 'jayla'),
                    '2' => __('2 Columns', 'jayla'),
                    '3' => __('3 Columns', 'jayla'),
                    '4' => __('4 Columns', 'jayla'),
                ) )
                ->set_default_value( '2' ),
                Field::make( 'checkbox', 'open_on_new_window', __('Open on new window', 'jayla') ),
        ) );
    }


    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo implode('', array($args['before_title'], $instance['title'], $args['after_title']));

        $branding_gallery_data = $instance['branding_gallery_data'];
        if( empty($branding_gallery_data) || count($branding_gallery_data) == 0 ) return;

        $grid_opts = wp_json_encode( array(
            'Col' => (int) $instance['branding_gallery_column'],
            'Space' => 10,
            'Responsive' => array(
                '300' => array(
                    'Col' => 1,
                )
            )
        ) );

        $open_new_tab = ($instance['open_on_new_window'] == true) ? 'target="_blank"' : '';
        ?>
        <div class="theme-extends-widget-branding">
            <div class="__inner" data-theme-furygrid-options='<?php echo esc_attr($grid_opts); ?>'>
                <div class="furygrid-sizer"></div>
                <div class="furygrid-gutter-sizer"></div>
                <?php

                foreach($branding_gallery_data as $item) {
                    // image default
                    $image_src = get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg';

                    $attachment_data = wp_get_attachment_image_src( $this->get_complex_field('image', $item), 'large' );
                    if(! empty($attachment_data)) { $image_src = $attachment_data[0]; }

                    echo implode('', array(
                        '<div class="furygrid-item">',
                            '<a class="branding-item" href="'. esc_url( $this->get_complex_field('url', $item) ) .'" '. $open_new_tab .'>',
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
