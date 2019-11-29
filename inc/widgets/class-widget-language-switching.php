<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Product search
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Language_Switching extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_language_switching',
            __('Theme Widget - Language Switching', 'jayla'),
            __('Displays language switching', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )
                    ->set_default_value( __('Language Switching', 'jayla') ),
                Field::make( 'complex', 'language_switching_data' )
                    ->add_fields( array(
                        Field::make( 'text', 'lan_label', __( 'Label', 'jayla' ) )
                            ->set_required( true ),
                        Field::make( 'text', 'lan_direct_url', __( 'Direct Url', 'jayla' ) )
                            ->set_required( true ),
                    ) )
                    ->set_default_value( array(
                        array(
                            'lan_label' => __('English', 'jayla'),
                            'lan_direct_url' => '#'
                        ),
                        array(
                            'lan_label' => __('România', 'jayla'),
                            'lan_direct_url' => '#'
                        ),
                    ) )
                    ->set_collapsed( true )
                    ->set_header_template('
                    <% if (lan_label) { %>
                        <%- lan_label %>
                    <% } %>'),
                Field::make( 'select', 'layout', __( 'Layout', 'jayla' ) )
                    ->add_options( apply_filters( 'jayla_widget_search_layout_filter', array(
                        'default' => __('Default', 'jayla')
                    ) ) )
                    ->set_default_value( 'default' ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value( '' ),
        ) );
    }

    public function _render_layout_default($instance) {
        $language_switching_data = $instance['language_switching_data'];
        if( empty( $language_switching_data ) || count( $language_switching_data ) <= 0 ) return;

        ob_start();
		$classes = array( 'theme-widget-language-switching' );
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <!-- <pre><?php print_r($instance['language_switching_data']); ?></pre> -->
            <div 
                class="language-select-ui" 
                data-theme-extends-select-custom-ui>
                <span class="__icon">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                </span>
                <span class="__label"><?php _e( 'Language', 'jayla' ); ?></span>

                <div class="language-select-ui__options language-options-container" data-theme-extends-select-custom-ui-options>
                    <?php foreach( $language_switching_data as $item ) {
                    ?>
                    <a class="switching-language-item" href="<?php echo esc_url( $item['lan_direct_url'] ); ?>" data-href="<?php echo esc_attr( $item['lan_direct_url'] ); ?>"><span><?php echo "{$item['lan_label']}" ?></span></a>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
		<?php
        return ob_get_clean();
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        $classes = implode( ' ', array(
            'theme-extends-widget-language-switching',
            $instance['class_custom_design'],
            '_layout-' . $instance['layout'],
        ) );

        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-language-switching.' . $instance['class_custom_design'];
            $custom_design_selector = wp_json_encode( array(
                array(
                    'name' => __('Widget search wrap', 'jayla'),
                    'selector' => $_root_classes
                ),
            ) );

            $custom_design_name_attr = 'data-design-name="'. __('Widget Search', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. $custom_design_selector .'\'';
        }

        $layouts = apply_filters( 'jayla_widget_custom_search_layout_filter', array(
            'default' => $this->_render_layout_default( $instance ),
        ), $instance );

        $content = $layouts[$instance['layout']];
        ?>
        <div 
            class="<?php echo esc_attr( $classes ); ?>"
            <?php echo "{$custom_design_name_attr}" ?>
            <?php echo "{$custom_design_selector_attr}" ?>>
            <div class="__inner">
                <?php
                    echo "{$content}";
                ?>
            </div>
        </div>
        <?php
    }
}
