<?php
/**
 * Custom meta box
 * @author Bearsthemes
 * @version 1.0.0
 */

if(! class_exists('Jayla_Custom_Meta_Box')) {
  class Jayla_Custom_Meta_Box {

    /**
     * Constructor.
     */
    public function __construct() {
      Jayla_Custom_Meta_Box::init_metabox();
    }

    /**
     * Meta box initialization.
     */
    public static function init_metabox() {
      add_action( 'admin_enqueue_scripts', array( 'Jayla_Custom_Meta_Box', 'scripts' ) );
      add_action( 'save_post',      array( 'Jayla_Custom_Meta_Box', 'save_metabox' ) );
    }

    public static function scripts() {
      /* vue & vuex */
      wp_enqueue_script( 'vue', get_template_directory_uri() . '/assets/vendors/vue/vue.min.js', array(), '2.4.4' );
      wp_enqueue_script( 'vuex', get_template_directory_uri() . '/assets/vendors/vue/vuex.min.js', array('vue'), '2.4.0' );

      /* element-ui */
      wp_enqueue_style( 'element-ui', get_template_directory_uri() . '/assets/vendors/element-ui/element-ui.css', array(), '1.4.6', 'all' );
      wp_enqueue_script( 'element-ui', get_template_directory_uri() . '/assets/vendors/element-ui/element-ui.js', array('vue'), '1.4.6' );
      wp_enqueue_script( 'element-ui-en', get_template_directory_uri() . '/assets/vendors/element-ui/element-ui-en.js', array('element-ui'), '1.4.6' );
    }

    /**
     * get list metabox for theme
     */
    public static function get_list_metabox() {
      $directory = get_template_directory() . '/inc/meta-box';
      $scanned_directory = array_slice(scandir($directory), 2);

      return apply_filters( 'jayla_list_custom_metabox_filter', $scanned_directory );
    }

    /**
     * Renders the meta box.
     */
    public static function render_metabox( $post ) {
      $post_type = get_post_type($post);
      if( ! in_array( $post_type . '.php', Jayla_Custom_Meta_Box::get_list_metabox() ) ) return;

      $data = apply_filters('jayla_custom_metabox_variable_' . $post_type . '_data', fintotheme_custom_metabox_customize_data(), $post);
      if(empty($data)) return;

      $value = get_post_meta( $post->ID, '_jayla_metabox_custom_settings', true );
      $data_settings = $data['settings'];
      $array_value = ! empty($value) ? json_decode($value, true) : array();
      $data['settings'] = jayla_array_merge_recursive($data_settings, $array_value);

      wp_nonce_field( 'jayla_custom_metabox_nonce_action', 'jayla_custom_metabox_nonce' );
      ?>
      <div class="theme-extends-custom-metabox" data-theme-extends-custom-metabox="<?php echo esc_attr($post_type); ?>">
        <?php require get_template_directory() . '/inc/meta-box/' . $post_type . '.php'; ?>
        <textarea hidden data-custom-metabox-data-field><?php echo esc_attr(json_encode($data)); ?></textarea>
      </div>
      <textarea hidden name="_jayla_metabox_custom_settings" data-custom-metabox-field><?php echo esc_attr( json_encode($data['settings']) ); ?></textarea>
      <?php
    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public static function save_metabox( $post_id ) {
      // Add nonce for security and authentication.
      $nonce_name   = isset( $_POST['jayla_custom_metabox_nonce'] ) ? $_POST['jayla_custom_metabox_nonce'] : '';
      $nonce_action = 'jayla_custom_metabox_nonce_action';

      // Check if nonce is set.
      if ( ! isset( $nonce_name ) ) {
        return;
      }

      // Check if nonce is valid.
      if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
        return;
      }

      // Check if user has permissions to save data.
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
      }

      // Check if not an autosave.
      if ( wp_is_post_autosave( $post_id ) ) {
        return;
      }

      // Check if not a revision.
      if ( wp_is_post_revision( $post_id ) ) {
        return;
      }

      update_post_meta( $post_id, '_jayla_metabox_custom_settings', $_POST['_jayla_metabox_custom_settings'] );
    }
  }
}

return new Jayla_Custom_Meta_Box();
