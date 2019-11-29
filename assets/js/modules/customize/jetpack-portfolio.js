/**
 * Customize jetpack-portfolio control
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
  customize_api.themeExtends.customizeJetpackPortfolioControl = function() {
    return {
      init () {
        if($('#theme-extends-jetpack-portfolio-action-control').length <= 0) return;
        this.vue_setup();
      },
      vue_setup () {

        new Vue({
          el: '#theme-extends-jetpack-portfolio-action-control',
          store: wp.theme_store,
          data () {
            return {

            }
          },
          computed: {
            root_store () {
              return this.$store.state.jetpack_portfolio;
            },
          },
          watch: {
            'root_store.data': {
              handler (data) {
                $('textarea#theme-extends-jetpack-portfolio-settings-field').val( JSON.stringify(data) ).trigger('change');
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
  customize_api.themeExtends.customizeJetpackPortfolio = new customize_api.themeExtends.customizeJetpackPortfolioControl();
  customize_api.themeExtends.customizeJetpackPortfolio.init();

  /* DOM Ready */
  $(function() {

  })
};
