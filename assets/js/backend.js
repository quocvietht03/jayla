/**
 * @package theme backend script
 * @author bearsthemes
 * @version 1.0.0
 */

import MetaBoxCustomizeOverride from './modules/custom-metabox/customize-override';
import ThemeSetup from './modules/setup';
import ThemePurchaseCodeValidate from './modules/theme_validate';

! (function(wp, $) {
  'use strict';

  ELEMENT.locale(ELEMENT.lang.en);

  var ThemeExtendsBackend = wp.themeExtendsBackend || {};
  var metaBoxScripts = {
    customizeOverride: MetaBoxCustomizeOverride,
  };

  /* vue component */
  Vue.component( 'wp-media-field', require('./modules/components/fields/vue-wp-media-field') );

  /**
   * custom metabox script
   */
  ThemeExtendsBackend.customMetaboxHandle = function() {
    var postype_support = theme_backend_script_object.metabox_posttype_support;
   
    $('[data-theme-extends-custom-metabox]').each(function() {
      var type          = $(this).data('theme-extends-custom-metabox'),
          fieldData     = $(this).find('textarea[data-custom-metabox-data-field]'),
          fieldSaving   = $(this).parent().find('textarea[data-custom-metabox-field]');

      if(postype_support[type]){
        metaBoxScripts[postype_support[type]]({
          el: this,
          fieldData: fieldData,
          fieldSaving: fieldSaving,
        });
      }

    })
  }

   /* DOM Ready */
   $(function() {

    ThemeSetup();
   })

   $(window).load(function() {
     ThemeExtendsBackend.customMetaboxHandle();
   })
 })(window.wp, jQuery)
