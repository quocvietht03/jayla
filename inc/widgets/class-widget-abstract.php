<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * abstract Widget
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Widget
 */
abstract class Jayla_Widget_Abstract extends Widget {

    public function widget( $args, $instance ) {
        $this->datastore->import_storage( $instance );
		if ( $this->print_wrappers ) {
			echo implode('', array($args['before_widget']));
        }

        $instance_values = array();
        if(isset($instance['widget-type']) && $instance['widget-type'] == 'customize-builder') {
            $instance_values = $instance;
        } else {
            foreach ( $this->custom_fields as $field ) {
                $clone = clone $field;
                $clone->load();
                $instance_values[ $clone->get_base_name() ] = $clone->get_formatted_value();
            }
        }

        $this->front_end( $args, $instance_values );

		if ( $this->print_wrappers ) {
            echo implode('', array($args['after_widget']));
		}
    }

    public function get_complex_field($field_name, $fields) {
        return isset($fields[$field_name]) ? $fields[$field_name] : $fields["_{$field_name}"];
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {}
}
