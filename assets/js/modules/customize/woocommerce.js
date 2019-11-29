/**
 * Customize woocommerce control
 */
var helpers = require('../helpers.js');

export default function (wp, $) {
  'use strict';

  if ( ! wp || ! wp.customize ) { return; }

	// Set up our namespace.
	var customize_api = wp.customize;
  customize_api.themeExtends = customize_api.themeExtends || {};

  /**
   * WooCommerce customize function control
   */
  customize_api.themeExtends.customizeWooCommerceControl = function() {
    return {
      init () {
        if($('#theme-extends-woocommerce-action-control').length <= 0) return;
        this.vue_setup();
      },
      vue_setup () {

        new Vue({
          el: '#theme-extends-woocommerce-action-control',
          store: wp.theme_store,
          data () {
            return {

            }
          },
          computed: {
            root_store () {
              return this.$store.state.woocommerce;
            },
          },
          watch: {
            'root_store.data': {
              handler (data) {
                // console.log(data);
                $('textarea#theme-extends-woocommerce-settings-field').val( JSON.stringify(data) ).trigger('change');
              },
              deep: true,
            },
          },
          methods: {

          }
        })

      },
    }
  }

  /* Customize ready */
  customize_api.themeExtends.customizeWooCommerce = new customize_api.themeExtends.customizeWooCommerceControl();
  customize_api.themeExtends.customizeWooCommerce.init();

  /* DOM Ready */
  $(function() {

  })
};
