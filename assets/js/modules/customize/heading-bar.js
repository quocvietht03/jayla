/**
 * Customize heading bar control
 */
var helpers = require('../helpers.js');

export default function (wp, $) {
  'use strict';

  if ( ! wp || ! wp.customize ) { return; }

	// Set up our namespace.
	var customize_api = wp.customize;
  customize_api.themeExtends = customize_api.themeExtends || {};

  /**
   * Designer customize function control
   */
  customize_api.themeExtends.customizeHeadingBarControl = function() {
    return {
      init () {
        this.vue_setup();
      },
      vue_setup () {

        new Vue({
          el: '#theme-extends-heading-bar-action-control',
          store: wp.theme_store,
          data () {
            return {
              wp_media_field_params: {
                'label': "Select Image",
                'type': "wp-media"
              },
              bg_image_size: [
                { label: 'Cover', value: 'cover' },
                { label: 'Contain', value: 'contain' },
                { label: 'Initial', value: 'initial' },
              ],
              bg_image_position: [
                { label: 'Left', value: 'left' },
                { label: 'Right', value: 'right' },
                { label: 'Center', value: 'center' },
              ],
              bg_image_repeat: [
                { label: 'No Repeat', value: 'no-repeat' },
                { label: 'Tile', value: 'repeat' },
                { label: 'Tile Horizontally', value: 'repeat-x' },
                { label: 'Tile Vertically', value: 'repeat-y' },
              ],
              bg_image_attachment: [
                { label: 'Scroll', value: 'scroll' },
                { label: 'Fixed', value: 'fixed' },
              ],
            }
          },
          computed: {
            headingBarStore () {
              return this.$store.state.headingBar;
            }
          },
          watch: {
            'headingBarStore.data.jayla_heading_bar_display' (data) {
              $('input#theme-extends-heading-bar-title-bar-display-data-field').val(data).trigger('change');
            },
            'headingBarStore.data.jayla_heading_bar_page_title_display' (data) {
              $('input#theme-extends-heading-bar-page-title-display-data-field').val(data).trigger('change');
            },
            'headingBarStore.data.jayla_heading_bar_breadcrumb_display' (data) {
              $('input#theme-extends-heading-bar-breadcrumb-display-data-field').val(data).trigger('change');
            },
            'headingBarStore.data.jayla_heading_bar_content_align' (data) {
              $('input#theme-extends-heading-bar-content-align-data-field').val(data).trigger('change');
            },
            'headingBarStore.data.jayla_heading_bar_background_settings': {
              handler (data) {
                $('textarea#theme-extends-heading-bar-background-setings-data-field').val(JSON.stringify(data)).trigger('change');
              },
              deep: true,
            }
          }
        })
      },
    }
  }

  /* Customize ready */
  customize_api.themeExtends.customizeHeadingBar = new customize_api.themeExtends.customizeHeadingBarControl();
  customize_api.themeExtends.customizeHeadingBar.init();

  /* DOM Ready */
  $(function() {

  })
};
