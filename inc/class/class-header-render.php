<?php
/**
 * Header builder render
 * @author Bearsthemes
 * @version 1.0.0
 */

if(! class_exists('Jayla_Header_Render')) :
  /**
   * @since 1.0.0
   * Header builder render
   * extends Jayla_Customize_Builder_Render  
   */
  class Jayla_Header_Render extends Jayla_Customize_Builder_Render {
    public $header_key, $layout_data, $header_sticky_data, $header_tablet_mobile_data;

    function __construct($data = array()) {
      $this->header_key = $data['key'];
      $this->general_settings = $data['settings'];
      $this->layout_data = $data['header_data'];
      $this->header_sticky_data = $data['header_sticky_data'];
      $this->header_tablet_mobile_data = $data['header_tablet_mobile_data'];
    }

    function render() { 
      $header_desktop = $this->build_output($this->layout_data);
      $header_sticky = ($this->general_settings['header_sticky'] == true) ? $this->build_output($this->header_sticky_data) : '';
      $header_tablet_mobile = $this->build_output($this->header_tablet_mobile_data);

      $header_settings = json_encode(array(
        'header_sticky' => $this->general_settings['header_sticky'],
        'header_tablet_mobile_transform_width' => $this->general_settings['header_tablet_mobile_transform_width'],
      ))
      ?>
      <div class="header-builder-wrap <?php echo esc_attr( $this->header_key ); ?>" data-header-settings='<?php echo esc_attr($header_settings); ?>'>
        <div class="header-builder__main" data-design-name="<?php esc_attr_e('Header Main', 'jayla'); ?>" data-design-selector="#page .<?php echo esc_attr( $this->header_key ); ?> .header-builder__main"><?php echo "{$header_desktop}"; ?></div>
        <?php if($this->general_settings['header_sticky'] == true) { ?>
          <div class="header-builder__sticky" data-design-name="<?php esc_attr_e('Header Sticky', 'jayla'); ?>" data-design-selector="#page .<?php echo esc_attr( $this->header_key ); ?> .header-builder__sticky"><?php echo "{$header_sticky}"; ?></div>
        <?php } ?>
        <div class="header-builder__mobile" data-design-name="<?php esc_attr_e('Header Sticky', 'jayla'); ?>" data-design-selector="#page .<?php echo esc_attr( $this->header_key ); ?> .header-builder__mobile"><?php echo "{$header_tablet_mobile}"; ?></div>
      </div>
      <?php
    }

    function render_css_inline() {
      $output = implode('', array(
        $this->build_style_inline($this->layout_data),
        ($this->general_settings['header_sticky'] == true) ? $this->build_style_inline($this->header_sticky_data) : '',
        $this->build_style_inline($this->header_tablet_mobile_data)
      ));

      /* header transform style */
      $header_tablet_mobile_transform_width = $this->general_settings['header_tablet_mobile_transform_width'];
      $css_selector_class = ".header-builder-wrap.{$this->header_key}";
      $output .= implode(' ', array(
        "@media (max-width: {$header_tablet_mobile_transform_width}px) {",
          "body:not(.theme-extends-layout-nav-left):not(.theme-extends-layout-nav-right) {$css_selector_class} .header-builder__main{ display: none; }",
          "body:not(.theme-extends-layout-nav-left):not(.theme-extends-layout-nav-right) {$css_selector_class} .header-builder__sticky{ display: none; }",
          "body:not(.theme-extends-layout-nav-left):not(.theme-extends-layout-nav-right) {$css_selector_class} .header-builder__mobile{ display:  block; }",
        "} " ));

      return $output;
    }
  }
endif;
