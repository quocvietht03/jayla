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
class Jayla_Widget_Product_Custom_Search extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_product_custom_search',
            __('Theme Widget - Product Search', 'jayla'),
            __('Displays a search field search products', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )
                    ->set_default_value( __('Products Search', 'jayla') ),
                Field::make( 'checkbox', 'suggestions_product', __('On/Off Suggestions Product', 'jayla') )
                    ->set_default_value( false ),
                Field::make( 'textarea', 'suggestions_product_short_desc', 'Suggestions Product Short Descriptions' )
                    ->set_rows( 4 )
                    ->set_conditional_logic( array(
                        array(
                            'field' => 'suggestions_product',
                            'value' => true,
                        )
                    ) )
                    ->set_default_value( __('Our featured products', 'jayla') ),
                Field::make( 'select', 'layout', __( 'Layout', 'jayla' ) )
                    ->add_options( apply_filters( 'jayla_widget_product_custom_search_layout_filter', array(
                        'default' => __('Default', 'jayla'),
                        'popup' => __('Popup', 'jayla'),
                    ) ) )
                    ->set_default_value( 'default' ),
                Field::make( "multiselect", "suggestions_product_data", __("Suggestions Products", 'jayla') )
                    ->set_conditional_logic( array(
                        array(
                            'field' => 'suggestions_product',
                            'value' => true,
                        )
                    ) )
                    ->add_options( jayla_woo_widget_get_product_options( array( '' => __('- Select Product -', 'jayla') ) ) ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value( '' ),
        ) );
    }

    /**
     * @since 1.0.0
     */
    public function _template($temp = 'default') {
        $template = array(
            'default' => implode('', array(
                '<form class="theme-extends-custom-product-search woocommerce-product-search" method="get" action="'. get_site_url() .'" role="search" data-woo-widget-custom-product-search-form>',
                    '<input type="search" class="search-field product-search-field" placeholder="{{placeholder_text}}" value="" name="s" autocomplete="off">',
                    '{{by_category_filter_html}}',
                    '<button type="submit" value="Search">{{button_submit_text}}</button>',
                    '<input type="hidden" name="post_type" value="product">',
                    '{{suggestions_product_html}}',
                '</form>',
            )),
            'popup' => $this->jayla_widget_product_custom_search_layout_popup(),
        );
        $template = apply_filters( 'jayla_widget_product_custom_search_layouts', $template );
        return $template[$temp];
    }

    public function jayla_widget_product_custom_search_layout_popup(){
        $layout = implode('', array(
            '<div class="_icon-search">'. jayla_search_icon_svg( 'search_basic' ) .'</div>',
            '<div class="theme-extends-product-custom-search-wrapper theme-extends-product-custom-search-ajax-js">',
        			'<div class="product-custom-search-container">',
        				'<div class="search-form-container">',
        					'<a href="javascript:" class="__close" title="'. esc_attr__( 'Close', 'jayla' ) .'">×</a>',
                  '<form class="theme-extends-custom-product-search woocommerce-product-search" method="get" action="'. get_site_url() .'" role="search" data-woo-widget-custom-product-search-form>',
                      '<input type="search" class="search-field product-search-field" placeholder="{{placeholder_text}}" value="" name="s" autocomplete="off">',
                      '{{by_category_filter_html}}',
                      '<button type="submit" value="Search">{{button_submit_text}}</button>',
                      '<input type="hidden" name="post_type" value="product">',
                      '{{suggestions_product_html}}',
                  '</form>',
                '</div>',
              '</div>',
            '</div>',
          )
        );
        return $layout;
    }

    public function get_product_cat() {
        /* Do Query
        ----------------*/
        $term_args = array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'fields'     => 'all',
            'count'      => true,
        );

        $term_query = new WP_Term_Query( $term_args );

        /* Do we have any terms?
        -----------------------------*/
        if( empty( $term_query->terms ) ){
            return false;
        }

        /* Get the terms :)
        ------------------------*/
        return $term_query->terms;
    }

    /**
     * Build product cat filter html select
     * @since 1.0.0
     */
    public function category_filter_html() {
        $p_term = $this->get_product_cat();
        if( $p_term == false ) return;
        // echo '<pre>'; print_r($p_term); echo '</pre>';

        $output = array('<div class="theme-extends-filter-product-by-cat">');
        array_push($output, '<label><span class="__cat_label_display">'. __('Select Category', 'jayla') .'</span></label>');
        array_push($output, '<ul class="p-cat-list">');
        array_push($output, '<li class="_p-all"><a href="#" data-pcat-slug="" data-pcat-name="'. esc_attr__('Select Category', 'jayla') .'">'. __('Select Category', 'jayla') .'</a></li>');

        foreach($p_term as $item) {
            $term_item_link = get_term_link( $item->term_id, 'product_cat' );
            array_push($output, implode('', array(
                '<li>',
                    '<a href="'. esc_url( $term_item_link ) .'" data-pcat-slug="'. esc_attr( $item->slug ) .'" data-pcat-name="'. esc_attr( $item->name ) .'">'. $item->name . '<sup class="count">'. $item->count .'</sup>' .'</a>',
                '</li>'
            )));
        }
        array_push($output, '</ul>');
        array_push($output, '<input type="hidden" name="taxonomy" value="product_cat">');
        array_push($output, '<input type="hidden" name="term" value="">');
        array_push($output, '</div>');

        return implode('', $output);
    }

    public function suggestions_product_html( $short_descriptions = '', $product_data = array() ) {
        $result_products = array();
        if( ! $product_data || count($product_data) < 0 ) return;

        $args = array(
            'post_type' => 'product',
            'post__in' => $product_data,
            'orderby' => 'post__in'
        );
        $posts = get_posts($args);
        if( empty($posts) ) return;

        foreach($posts as $p) {
            $product = wc_get_product($p->ID);
            array_push($result_products, jayla_woo_product_item_widget_search_temp($product));
        }

        $output = array(
            '<div class="theme-extends-widget-product-search-result-container">',
                '<div class="__inner">',
                    ! empty($short_descriptions) ? '<div class="suggestions-short-desc">'. $short_descriptions .'</div>' : '',
                    '<div class="p-result-items temp__horizontal">'. implode('', $result_products) .'</div>',
                '</div>',
            '</div>'
        );

        return implode('', $output);
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';

        $layout = isset($instance['layout']) ? $instance['layout'] : 'default';
        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-product-custom-search.' . $instance['class_custom_design'];
            $design_selector = array();
            if($layout == 'popup'){
              $design_selector[] = array(
                'name' => __('Icon Search','jayla'),
                'selector' => $_root_classes.' ._icon-search svg'
              );
            }
            $custom_design_selector = wp_json_encode( $design_selector );
            $custom_design_name_attr = 'data-design-name="'. __('Products search form', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. $custom_design_selector .'\'';
        }

        $replace_variables = array(
            '{{placeholder_text}}' => __('Search products…', 'jayla'),
            '{{by_category_filter_html}}' => $this->category_filter_html(),
            '{{button_submit_text}}' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512"> <g> <path d="m495,466.1l-110.1-110.1c31.1-37.7 48-84.6 48-134 0-56.4-21.9-109.3-61.8-149.2-39.8-39.9-92.8-61.8-149.1-61.8-56.3,0-109.3,21.9-149.2,61.8-39.9,39.8-61.8,92.8-61.8,149.2 0,56.3 21.9,109.3 61.8,149.2 39.8,39.8 92.8,61.8 149.2,61.8 49.5,0 96.4-16.9 134-48l110.1,110c8,8 20.9,8 28.9,0 8-8 8-20.9 0-28.9zm-393.3-123.9c-32.2-32.1-49.9-74.8-49.9-120.2 0-45.4 17.7-88.2 49.8-120.3 32.1-32.1 74.8-49.8 120.3-49.8 45.4,0 88.2,17.7 120.3,49.8 32.1,32.1 49.8,74.8 49.8,120.3 0,45.4-17.7,88.2-49.8,120.3-32.1,32.1-74.9,49.8-120.3,49.8-45.4,0-88.1-17.7-120.2-49.9z"></path> </g> </svg>',
            '{{suggestions_product_html}}' => ($instance['suggestions_product'] == true) ? $this->suggestions_product_html( $instance['suggestions_product_short_desc'], $instance['suggestions_product_data'] ) : '',
        );
        ?>
        <div
            class="theme-extends-widget-product-custom-search <?php echo esc_attr($instance['class_custom_design']); ?> _layout-<?php echo esc_attr($layout); ?>"
            <?php echo apply_filters( 'jayla_widget_product_search_form_design_name_attr', $custom_design_name_attr ); ?>
            <?php echo apply_filters( 'jayla_widget_product_search_form_design_selector_attr', $custom_design_selector_attr ); ?>>
            <div class="__inner">
                <?php echo str_replace( array_keys($replace_variables), array_values($replace_variables), $this->_template( $layout ) ); ?>
            </div>
        </div>
        <?php
    }
}
