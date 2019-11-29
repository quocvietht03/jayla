<?php
/**
 * @since       1.0.0
 * Widget Main Class
 *
 * @package     Jayla
 * @author      Bearsthemes
 * @version     1.0.0
 */
class Jayla_Widgets {

    public $widgets_class = array();

    public function __construct() {
        if(! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) return;

        $this->inc();
        $this->hooks();
    }

    public function inc() {
        include get_template_directory() . '/inc/widgets/class-widget-abstract.php';
    }

    public function register_widgets() {
        $root_path = get_template_directory() . '/inc/widgets';
        return  apply_filters( 'jayla_register_wp_widgets_filter', array(
            'Jayla_Widget_Branding'                   => $root_path . '/class-widget-branding.php',
            'Jayla_Widget_Images_Slide'               => $root_path . '/class-widget-images-slide.php',
            'Jayla_Widget_Recent_Posts'               => $root_path . '/class-widget-recent-posts.php',
            'Jayla_Widget_instagram_gallery_grid'     => $root_path . '/class-widget-instagram-gallery-grid.php',
            'Jayla_Widget_Featured_Box_Slide'         => $root_path . '/class-widget-feature-box-slide.php',
            'Jayla_Widget_Instagram_Slide'            => $root_path . '/class-widget-instagram-slide.php',
            'Jayla_Widget_Custom_Menu'                => $root_path . '/class-widget-custom-menu.php',
            'Jayla_Widget_Search'                     => $root_path . '/class-widget-search.php',
            'Jayla_Widget_Button'                     => $root_path . '/class-widget-button.php',
            'Jayla_Widget_Language_Switching'         => $root_path . '/class-widget-language-switching.php',
            'Jayla_Widget_Menu_Mega_Dropdown'         => $root_path . '/class-widget-menu-mega-dropdown.php',
        ) );
    }

    public function inc_widgets() {
        $widgets = $this->register_widgets();
        if(empty($widgets) || count($widgets) == 0) return;

        foreach($widgets as $widget_class_name => $widget_path_file) {
            if( ! file_exists($widget_path_file) ) continue;
            include $widget_path_file;

            if( class_exists($widget_class_name) ) {
                register_widget( $widget_class_name );
            }
        }

        return $widgets;
    }

    public function hooks() {
        add_action( 'widgets_init', array($this, 'inc_widgets') );

    }
}

return new Jayla_Widgets();
