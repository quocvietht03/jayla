/**
 * Customize global control
 */
var helpers = require('../helpers.js');

export default function (wp, $) {
  'use strict';

  if ( ! wp || ! wp.customize ) { return; }

	// Set up our namespace.
	var customize_api = wp.customize;
  customize_api.themeExtends = customize_api.themeExtends || {};

  /**
   * Global customize function control
   */
  customize_api.themeExtends.customizeGlobalControl = function() {
    return {
      init () {
        this.vue_setup();
      },
      vue_setup () {

        new Vue({
          el: '#theme-extends-global-action-control',
          store: wp.theme_store,
          data () {
            return {
              unique_opened: true,
            }
          },
          computed: {
            root_store () {
              return this.$store.state.global;
            },
            data () {
              return this.root_store.data;
            },
            edit () {
              return this.root_store.edit;
            },
          },
          watch: {
            'root_store.data': {
              handler (data) {
                $('textarea#theme-extends-global-settings-field').val( JSON.stringify(data) ).trigger('change');
              },
              deep: true,
            },
          },
          methods: {
            setEdit (data) {
              this.$store.state.global.edit = data;
            },
            disableElement(itemData, disableData) {
              if($.inArray(itemData, disableData) >= 0) {
                return 'theme-extends-element-disable';
              } else {
                return '';
              }
            },
          }
        })
      },
    }
  }

  /* Customize ready */
  customize_api.themeExtends.customizeGlobal = new customize_api.themeExtends.customizeGlobalControl();
  customize_api.themeExtends.customizeGlobal.init();

  /* DOM Ready */
  $(function() {

  })
};
