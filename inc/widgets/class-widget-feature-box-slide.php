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
class Jayla_Widget_Featured_Box_Slide extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_featured_box_slide',
            __('Theme Widget - Featured Box Slide', 'jayla'),
            __('Displays featured box slide', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )->set_default_value( __('Our Services', 'jayla') ),
                Field::make( 'complex', 'featured_box_slide_data', 'Images Slide' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( array(
                    Field::make( 'select', 'icon_type', 'Text alignment' )
                        ->add_options( array(
                            'icon_font' => __('Icon Font - Classes', 'jayla'),
                            'image' => 'Image from Gallery',
                        ) )
                        ->set_default_value( 'icon_font' )
                        ->set_help_text( __('Note: for Icon Font type you can use Fontawesome 4.x, Ionicon, Dashion.', 'jayla') ),
                    Field::make( 'image', 'icon_image', __('Icon', 'jayla') )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'icon_type',
                                'value' => 'image',
                            )
                        ) )
                        ->set_type( array( 'image' ) ),
                    Field::make( 'text', 'icon_font', __('Icon', 'jayla') )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'icon_type',
                                'value' => 'icon_font',
                            )
                        ) )
                        ->set_default_value( 'fa fa-bookmark-o' ),
                    Field::make( 'text', 'name', __('Name', 'jayla') ),
                    Field::make( 'rich_text', 'descriptions', __('Descriptions', 'jayla') ),
                ) ),
                Field::make( 'checkbox', 'slide_auto_play', __('Slide auto play', 'jayla') ),
                Field::make( 'text', 'columns', __('Columns', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 1 )
                    ->set_attribute( 'max', 6 )
                    ->set_default_value( 1 )
                    ->set_help_text( __('Input number columns for slide.', 'jayla') ),
                Field::make( 'text', 'columns_on_tablet', __('Columns on Tablet', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 1 )
                    ->set_attribute( 'max', 6 )
                    ->set_default_value( 1 )
                    ->set_help_text( __('Input number columns on tablet for slide.', 'jayla') ),
                Field::make( 'text', 'columns_on_mobile', __('Columns on Mobile', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 1 )
                    ->set_attribute( 'max', 6 )
                    ->set_default_value( 1 )
                    ->set_help_text( __('Input number columns on mobile for slide.', 'jayla') ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value(''),
        ) );
    }

    function _render_icon_html($args = array()) {
        // print_r($args);
        $image_data = wp_get_attachment_image_src( $this->get_complex_field('icon_image', $args), 'full' );
        $template = array(
            'icon_font' => '<div class="fbox-icon icon-type-icon_font"><span class="'. $this->get_complex_field('icon_font', $args) .'"></span></div>',
            'image' => '<div class="fbox-icon icon-type-icon_image"><img src="'. esc_url( $image_data[0] ) .'" alt="'. esc_attr('image', 'jayla') .'"></div>',
        );

        return $template[$this->get_complex_field('icon_type', $args)];
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) { 
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        $featured_box_slide_data = $instance['featured_box_slide_data'];
        if( empty($featured_box_slide_data) || count($featured_box_slide_data) == 0 ) return;

        $layout = 'default';
        $template = array(
            'default' => implode('', array(
                '<div class="swiper-slide fbox-item">',
                    '<div class="__inner">',
                        '{{icon_html}}',
                        '<div class="fbox-entry">',
                            '<div class="fbox-title">{{name}}</div>',
                            '<div class="fbox-des">{{descriptions}}</div>',
                        '</div>',
                    '</div>',
                '</div>',
            ))
        );

        $widget_slide_opts = array(
            'slidesPerView' => (int) $instance['columns'],
            'spaceBetween' => 30,
            'loop' => true,
            'breakpoints' => array(
                968 => array( 'slidesPerView' => (int) $instance['columns_on_tablet'] ),
                640 => array( 'slidesPerView' => (int) $instance['columns_on_mobile'] ),
                320 => array( 'slidesPerView' => 1 )
            ),
        );

        if( $instance['slide_auto_play'] == true ) {
            $widget_slide_opts['autoplay'] = array(
                'delay' => 2500
            );
        }

        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-featured-box-slide.' . $instance['class_custom_design'];
            $custom_design_selector = wp_json_encode( array(
                array(
                    'name' => __('Featured box item wrap', 'jayla'),
                    'selector' => $_root_classes . ' .fbox-item .__inner',
                ),
                array(
                    'name' => __('Featured box - Icon', 'jayla'),
                    'selector' => $_root_classes . ' .fbox-item .__inner .fbox-icon',
                ),
                array(
                    'name' => __('Featured box - Title', 'jayla'),
                    'selector' => $_root_classes . ' .fbox-item .__inner .fbox-entry .fbox-title',
                ),
                array(
                    'name' => __('Featured box - Descriptions', 'jayla'),
                    'selector' => $_root_classes . ' .fbox-item .__inner .fbox-entry .fbox-des',
                ),
            ) );

            $custom_design_name_attr = 'data-design-name="'. __('Featured Box', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. $custom_design_selector .'\'';
        }

        $widget_slide_opts = wp_json_encode( $widget_slide_opts );
        ?>
        <div 
            class="theme-extends-widget-featured-box-slide <?php echo esc_attr($instance['class_custom_design']); ?> _layout-<?php echo esc_attr($layout); ?>" 
            <?php echo apply_filters( 'jayla_widget_featured_box_design_name_attr', $custom_design_name_attr ); ?> 
            <?php echo apply_filters( 'jayla_widget_featured_box_design_selector_attr', $custom_design_selector_attr ); ?>>
            <div class="swiper-container" data-themeextends-swiper='<?php echo esc_attr($widget_slide_opts); ?>'>
                <div class="swiper-wrapper">
                    <?php foreach($featured_box_slide_data as $item) {
                        $replace_variables = array(
                            '{{icon_html}}' => $this->_render_icon_html( $item ),
                            '{{name}}' => $this->get_complex_field('name', $item),
                            '{{descriptions}}' => $this->get_complex_field('descriptions', $item),
                        );
                        echo str_replace( array_keys($replace_variables), array_values($replace_variables), $template[$layout] );
                    } ?>
                </div>
                <!-- Add Pagination -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
        <?php
    }
}
