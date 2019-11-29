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
class Jayla_Widget_Menu_Mega_Dropdown extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_Menu_mega_dropdown',
            __('Theme Widget - Menu Mega Dropdown', 'jayla'),
            __('Displays menu mega dropdown', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )
                    ->set_default_value( __('Menu Mega Dropdown', 'jayla') ),
                Field::make( 'select', 'layout', __( 'Layout', 'jayla' ) )
                    ->add_options( apply_filters( 'jayla_widget_menu_mega_dropdown_layout_filter', array(
                        'default' => __('Default', 'jayla'),
                        'minimal' => __('Minimal', 'jayla')
                    ) ) )
                    ->set_default_value( 'default' ),
                Field::make( 'text', 'select_name', __('Label', 'jayla') )
                    ->set_default_value( __('Quick Links', 'jayla') ),
                Field::make( 'select', 'open_menu_on_event', __( 'Open Menu On', 'jayla' ) )
                    ->add_options( array(
                        'hover' => 'Mouse Hover',
                        'click' => 'Mouse Click',
                    ) )
                    ->set_default_value( 'hover' ),
                Field::make( 'checkbox', 'menu_open', __( 'Menu Open', 'jayla' ) )
                    ->set_default_value( true )
                    ->set_conditional_logic( array(
                        array(
                            'field' => 'open_menu_on_event',
                            'value' => 'click',
                        )
                    ) ),
                Field::make( 'complex', 'menu_data' )
                    ->set_collapsed( true )
                    ->add_fields( array(
                        Field::make( 'text', 'label', __( 'Label', 'jayla' ) )
                            ->set_default_value( __( 'Menu Item', 'jayla' ) ),
                        Field::make( 'select', 'icon_type', __('Icon Type', 'jayla') )
                            ->add_options( array(
                                'icon_image' => __( 'Icon Image', 'jayla' ),
                                'icon_font' => __( 'Icon Font', 'jayla' ),
                            ) )
                            ->set_default_value( 'image' ),
                        Field::make( 'text', 'icon_font', __( 'Icon Font — Classes', 'jayla' ) )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'icon_type',
                                    'value' => 'icon_font',
                                )
                            ) ),
                        Field::make( 'image', 'icon_image', __( 'Select Image', 'jayla' ) )
                            ->set_value_type( 'url' )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'icon_type',
                                    'value' => 'icon_image',
                                )
                            ) ),
                        Field::make( 'text', 'url', __( 'Url', 'jayla' ) )
                            ->set_default_value( '#' ),
                        Field::make( 'select', 'menu_style', __('Menu Style', 'jayla') )
                            ->add_options( array(
                                'default' => __( 'Default', 'jayla' ),
                                // 'menu_inner' => __( 'Menu Inner', 'jayla' ),
                                'menu_mega_multiple_columns' => __( 'Menu Mega Multiple Columns — Light', 'jayla' ),
                                'menu_mega_multiple_columns_dark' => __( 'Menu Mega Multiple Columns — Dark', 'jayla' ),
                            ) )
                            ->set_default_value( 'menu_inner' ),
                        Field::make( 'select', 'menu_inner', __('Sub — Menu', 'jayla') )
                            ->add_options( 'jayla_widget_get_list_menu_options' )
                            ->set_default_value('')
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'menu_style',
                                    'value' => 'default',
                                )
                            ) ),
                        Field::make( 'image', 'menu_item_background_image', __( 'Sub — Background Image', 'jayla' ) )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'menu_style',
                                    'value' => array('menu_mega_multiple_columns', 'menu_mega_multiple_columns_dark'),
                                    'compare' => 'IN',
                                )
                            ) ),
                        Field::make( 'select', 'menu_mega_columns', __('Sub — Menu Mega Columns', 'jayla') )
                            ->add_options( array(
                                2 => __( '2 Columns', 'jayla' ),
                                3 => __( '3 Columns', 'jayla' ),
                                4 => __( '4 Columns', 'jayla' ),
                            ) )
                            ->set_default_value( 4 )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'menu_style',
                                    'value' => array('menu_mega_multiple_columns', 'menu_mega_multiple_columns_dark'),
                                    'compare' => 'IN',
                                )
                            ) ),
                        Field::make( 'complex', 'menu_mega', __( 'Sub — Menu Mega Data', 'jayla' ) )
                            ->set_collapsed( true )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'menu_style',
                                    'value' => array('menu_mega_multiple_columns', 'menu_mega_multiple_columns_dark'),
                                    'compare' => 'IN',
                                )
                            ) )
                            ->add_fields( array(
                                Field::make( 'image', 'menu_item_image', __( 'Menu Item Image', 'jayla' ) ),
                                Field::make( 'select', 'menu_inner', __('Menu', 'jayla') )
                                    ->add_options( 'jayla_widget_get_list_menu_options' )
                                    ->set_default_value('')
                                    ->set_conditional_logic( array(
                                        array(
                                            'field' => 'menu_style',
                                            'value' => 'menu_inner',
                                        )
                                    ) ),
                            ) )
                    ) )
                    ->set_header_template( '
                    <% if (label) { %>
                        <%- label %>
                    <% } else { %>
                        <%- $_index %>    
                    <% } %>' ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value( '' ),
        ) );
    }

    public function _render_menu_options($instance, $echo = true) {
        $menu_data = $instance['menu_data'];
        if( empty( $menu_data ) || count( $menu_data ) <= 0 ) return;
        ob_start();
        echo '<ul class="menu-mega-ul">';
        foreach( $menu_data as $item ) {
            $icon_temp = array(
                'icon_image' => ! empty( $item['icon_image'] ) ? '<img class="__menu-icon __icon-image" src="'. esc_url( $item['icon_image'] ) .'" alt="'. esc_attr( 'image', 'jayla' ) .'">' : '',
                'icon_font' => ! empty( $item['icon_font'] ) ? '<span class="__menu-icon __icon-font"><i class="'. esc_attr( $item['icon_font'] ) .'"></i></span>' : '',
            );

            ob_start();
            /**
             * hook jayla_widget_menu_mega_dropdown_submenu_html. 
             * 
             * @see jayla_widget_menu_mega_dropdown_submenu_default - 20 
             */
            do_action( 'jayla_widget_menu_mega_dropdown_submenu_html', $item, $instance ); 
            $submenu_html = ob_get_clean();

            $classes = array( 'mm-item', 'mm-item-type-' . $item['menu_style'] );
            if( ! empty( $submenu_html ) ) {
                array_push( $classes, 'mm-has-submenu' );
            }
            ?>
            <li class="<?php echo implode( ' ', $classes ); ?>">
                <a class="mm-item-link" href="<?php echo esc_url( $item['url'] ); ?>">
                    <?php echo "{$icon_temp[$item['icon_type']]}"; ?>
                    <span class="__menu-name"><?php echo "{$item['label']}"; ?></span>
                </a>
                <?php 
                    echo "{$submenu_html}";
                ?>
            </li>
            <?php
        }
        echo '</ul>';
        $output = ob_get_clean();

        if( $echo == true ) {
            echo "{$output}";
        } else {
            return $output;
        }
    }

    public function _render_layout_default($instance) {
        ob_start();
		$classes = array( 
            'theme-widget-menu-mega-dropdown-container',
        );

        $select_ui_class = array(
            'theme-extends-menu-mega-select-ui',
            '__open_menu_on_event_' . $instance['open_menu_on_event'],
            ( 'click' == $instance['open_menu_on_event'] && true == $instance['menu_open'] ) ? '__is-active' : '',
        );
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <div class="<?php echo esc_attr( implode( ' ', $select_ui_class ) ); ?>">
                <div class="__select-ui">
                    <span class="__icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 334.367 334.367" style="enable-background:new 0 0 334.367 334.367;" xml:space="preserve"> <g> <g> <g> <path d="M10.449,52.245h313.469c5.771,0,10.449-4.678,10.449-10.449s-4.678-10.449-10.449-10.449H10.449 C4.678,31.347,0,36.025,0,41.796S4.678,52.245,10.449,52.245z"/> <path d="M10.449,135.837h219.429c5.771,0,10.449-4.678,10.449-10.449c0-5.771-4.678-10.449-10.449-10.449H10.449 C4.678,114.939,0,119.617,0,125.388C0,131.159,4.678,135.837,10.449,135.837z"/> <path d="M323.918,198.531H10.449C4.678,198.531,0,203.209,0,208.98s4.678,10.449,10.449,10.449h313.469 c5.771,0,10.449-4.678,10.449-10.449S329.689,198.531,323.918,198.531z"/> <path d="M151.51,282.122H10.449C4.678,282.122,0,286.801,0,292.571s4.678,10.449,10.449,10.449H151.51 c5.771,0,10.449-4.678,10.449-10.449S157.281,282.122,151.51,282.122z"/> </g> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                    </span>
                    <span class="__select-title"><?php echo esc_attr( $instance['select_name'] ) ?></span>
                    <i class="__arrow ion-ios-arrow-down"></i>
                </div>
                <div class="__options-ui wg-mm-dropdown-options-ui">
                    <?php $this->_render_menu_options( $instance ); ?>
                </div>
            </div>
            <!-- <pre><?php // print_r( $instance ); ?></pre> -->
        </div>
		<?php
        return ob_get_clean();
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        $classes = implode( ' ', array(
            'theme-extends-widget-menu-mega-dropdown',
            $instance['class_custom_design'],
            '_layout-' . $instance['layout'],
        ) );

        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-menu-mega-dropdown.' . $instance['class_custom_design'];
            $custom_design_selector = array(
                array(
                    'name' => __('Widget menu mega dropdown wrap', 'jayla'),
                    'selector' => $_root_classes
                ),
            );

            $custom_design_name_attr = 'data-design-name="'. __('Widget Menu Mega Dropdown', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. wp_json_encode( $custom_design_selector ) .'\'';
        }

        $layouts = apply_filters( 'jayla_widget_menu_mega_dropdown_layout_filter', array(
            'default' => $this->_render_layout_default( $instance ),
            'minimal' => $this->_render_layout_default( $instance ),
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

if(! function_exists('jayla_widget_menu_mega_dropdown_submenu_default')) {
    /**
     * @since 1.0.0
     * 
     * @param [array] $data
     * @param [array] $instance
     */
    function jayla_widget_menu_mega_dropdown_submenu_default($data, $instance) {
        if( 'default' != $data['menu_style'] || empty( $data['menu_inner'] ) ) return;

        $args = array(
            'menu' => $data['menu_inner'],
            'container_class' => 'mm-dropdown-menu widget-mm-dropdown-menu',
        );

        $classes = apply_filters( 'jayla_widget_menu_mega_dropdown_submenu_default_classes', array(
            '__sub-menu', 
            '__mm-submenu-type-' . $data['menu_style'],
        ) );
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <div class="__inner">
                <?php wp_nav_menu( $args ) ?>
            </div>
        </div>
        <?php
    }
    add_action( 'jayla_widget_menu_mega_dropdown_submenu_html', 'jayla_widget_menu_mega_dropdown_submenu_default', 20, 2 );
}

if(! function_exists('jayla_widget_menu_mega_dropdown_submenu_multiple_columns')) {
    /**
     * @since 1.0.0
     *  
     * @param [array] $data
     * @param [array] $instance
     */
    function jayla_widget_menu_mega_dropdown_submenu_multiple_columns( $data, $instance ) {
        if( ! in_array( $data['menu_style'], array( 'menu_mega_multiple_columns_dark', 'menu_mega_multiple_columns' ) ) || count( $data['menu_mega'] ) <= 0 ) return;
        $classes = apply_filters( 'jayla_widget_menu_mega_dropdown_submenu_default_classes', array(
            '__sub-menu', 
            '__mm-submenu-type-' . $data['menu_style'],
        ) );

        $style_background_image = '';
        if( ! empty( $data['menu_item_background_image'] ) ) {
            $bg_image_large_data = wp_get_attachment_image_src( (int) $data['menu_item_background_image'], 'large' );
            if( $bg_image_large_data ) {
                $style_background_image = 'background: url('. $bg_image_large_data[0] .') no-repeat center center / cover;';
            }
        }

        $col_classes = array(
            1 => 'col-12',
            2 => 'col-6',
            3 => 'col-4',
            4 => 'col-3',
        );
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <?php if( ! empty( $style_background_image ) ) {
                echo sprintf( '<div class="mm-background-image-elem" style="%s"></div>', $style_background_image );
            } ?>
            <div class="__inner __mm-col-<?php echo esc_attr( $data['menu_mega_columns'] ); ?>">
                <div class="row">
                    <?php foreach( $data['menu_mega'] as $item ) {
                        $heading_image_html = '';
                        if( ! empty( $item['menu_item_image'] ) ) {
                            $image_large_data = wp_get_attachment_image_src( (int) $item['menu_item_image'], 'large' );
                            if( $image_large_data ) {
                                $heading_image_html = wp_get_attachment_image( (int) $item['menu_item_image'], 'medium', false, array(
                                    'class' => 'mm-item-heading-image',
                                    'data-themeextends-lazyload-url' => $image_large_data[0],
                                ) );
                            }
                        }

                        $args = array(
                            'menu' => $item['menu_inner'],
                            'container_class' => 'mm-dropdown-menu-multiple-col widget-mm-dropdown-menu',
                        );
                    ?>
                    <div class="<?php echo esc_attr( $col_classes[$data['menu_mega_columns']] ) ?>">
                        <div class="mm-item-nav">
                            <?php echo "{$heading_image_html}"; ?>
                            <?php wp_nav_menu( $args ); ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }
    add_action( 'jayla_widget_menu_mega_dropdown_submenu_html', 'jayla_widget_menu_mega_dropdown_submenu_multiple_columns', 20, 2 );
}
