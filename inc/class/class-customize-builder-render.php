<?php
/**
 * Customize builder render
 * @author Bearsthemes
 * @version 1.0.0
 */

if(! class_exists('Jayla_Customize_Builder_Render')) :
  class Jayla_Customize_Builder_Render {
    public $footer_key, $layout_data;

    public static $element_maps = array(
      'rs-row'      => 'jayla_rs_row_element',
      'rs-col'      => 'jayla_rs_col_element',
      'widget'      => 'jayla_widget_element',
      'wp-widget'   => 'jayla_wp_widget_element',
    );

    public static function build_output($layout_data) {

      if(empty($layout_data) || ! is_array($layout_data)) return;

      $output = '';

      foreach($layout_data as $item) :
        $_fn = Jayla_Customize_Builder_Render::$element_maps[$item['element']];

        /* set params item default */
        $item = array_merge(array('params' => array()), $item);

        $result = call_user_func_array($_fn, array($item));
        $output .= implode('', array(
          $result['start'],
          (isset($result['content_before'])) ? $result['content_before'] : '',
          (isset($item['children']) && count($item['children']) > 0)
            ? Jayla_Customize_Builder_Render::build_output($item['children'])
            : '',
          (isset($result['content_after'])) ? $result['content_after'] : '',
          $result['end'],
        ));
      endforeach;

      return $output;
    }

    public static function build_style_inline($layout_data = array()) {

      if(empty($layout_data) || ! is_array($layout_data)) return;

      $output = '';

      foreach($layout_data as $item) :
        $params = (isset($item['params'])) ? $item['params'] : array();
        $class_name = '.element-' . $item['key'];

        switch ($item['element']) {
          case 'rs-row':
            $style = implode('; ', array(
              (isset($params['padding']) && !empty($params['padding']))   ?   "padding: {$params['padding']}"   : '',
              (isset($params['margin']) && !empty($params['margin']))     ?   "margin: {$params['margin']}"     : '',
            ));

            $output .= implode('', array( $class_name, '{' , $style, '}' ));
            break;

          case 'rs-col':
            $style = implode('; ', array(
              (isset($params['width']) && !empty($params['width']))       ?   "width: {$params['width']}%"      : '',
              (isset($params['padding']) && !empty($params['padding']))   ?   "padding: {$params['padding']}"   : '',
              (isset($params['margin']) && !empty($params['margin']))     ?   "margin: {$params['margin']}"     : '',
            ));

            $output .= implode('', array( $class_name, '{' , $style, '}' ));
            break;

          case 'widget':
            $style = implode('; ', array(
              (isset($params['padding']) && !empty($params['padding']))   ?   "padding: {$params['padding']}"   : '',
              (isset($params['margin']) && !empty($params['margin']))    ?   "margin: {$params['margin']}"     : '',
            ));

            $output .= implode('', array( $class_name, '{' , $style, '}' ));
            break;
        }

        $output .= Jayla_Customize_Builder_Render::build_style_responsive_inline($class_name, $params);
      
        if(isset($item['children']) && count($item['children']) > 0) {
          $output .= Jayla_Customize_Builder_Render::build_style_inline($item['children']);
        }
      endforeach;

      return $output;
    }

    public static function build_style_responsive_inline($classes, $params) {
      $medium_device_css = '';
      $small_device_css = '';
      $extra_small_device_css = '';

      $_style_string = implode('', array(
        '@media (max-width: 992px) { %medium_device_css% }',
        '@media (max-width: 680px) { %small_device_css% }',
        '@media (max-width: 400px) { %extra_small_device_css% }',
      ));

      $_alignment_css = array(
        'theme-extends-align-left' => 'text-align: left',
        'theme-extends-align-right' => 'text-align: right',
        'theme-extends-align-center' => 'text-align: center',
      );

      // medium
      if( isset($params['medium_device']) && $params['medium_device'] == 'on' ) {
        if( isset($params['medium_device_width']) && ! empty($params['medium_device_width']) )
          $medium_device_css .= $classes . '{ width: '. $params['medium_device_width'] .'%; }';

        if( isset($params['medium_device_align']) && ! empty($params['medium_device_align']) )
          $medium_device_css .= $classes . '{ '. $_alignment_css[$params['medium_device_align']] .'; }';
      }

      // small
      if( isset($params['small_device']) && $params['small_device'] == 'on' ) {
        if( isset($params['small_device_width']) && ! empty($params['small_device_width']) )
          $small_device_css .= $classes . '{ width: '. $params['small_device_width'] .'%; }';

        if( isset($params['small_device_align']) && ! empty($params['small_device_align']) )
          $small_device_css .= $classes . '{ '. $_alignment_css[$params['small_device_align']] .'; }';
      }

      // extra small
      if( isset($params['extra_small_device']) && $params['extra_small_device'] == 'on' ) {
        if( isset($params['extra_small_device_width']) && ! empty($params['extra_small_device_width']) )
          $extra_small_device_css .= $classes . '{ width: '. $params['extra_small_device_width'] .'%; }';

        if( isset($params['extra_small_device_align']) && ! empty($params['extra_small_device_align']) )
          $extra_small_device_css .= $classes . '{ '. $_alignment_css[$params['extra_small_device_align']] .'; }';
      }
      
      $replace_arr = array( 
        '%medium_device_css%' => $medium_device_css,
        '%small_device_css%' => $small_device_css,
        '%extra_small_device_css%' => $extra_small_device_css,
      );

      return str_replace( array_keys($replace_arr), array_values($replace_arr), $_style_string );
    }

    function render() {}

    function render_css_inline() {}
  }
endif;
