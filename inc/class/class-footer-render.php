<?php
/**
 * Footer builder render
 * @author Bearsthemes
 * @version 1.0.0
 */

if(! class_exists('Jayla_Footer_Render')) :
  class Jayla_Footer_Render extends Jayla_Customize_Builder_Render {

    function __construct($data = array()) {
      $this->footer_key = $data['key'];
      $this->layout_data = $data['footer_data'];
    }

    function render() {
      $footer_desktop = $this->build_output($this->layout_data);
      ?>
      <div class="footer-builder-wrap <?php echo esc_attr( $this->footer_key ); ?>">
        <div class="footer-builder__main" data-design-name="<?php esc_attr_e('Footer Main', 'jayla'); ?>" data-design-selector="#page .<?php echo esc_attr( $this->footer_key ); ?> .footer-builder__main"><?php echo "{$footer_desktop}"; ?></div>
      </div>
      <?php
    }

    function render_css_inline() {
      $output = implode('', array(
        $this->build_style_inline($this->layout_data)
      ));

      return $output;
    }
  }
endif;
