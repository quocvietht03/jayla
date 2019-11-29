/**
 * theme customize live preview
 */

import designer_helpers from './modules/designer_helpers';

! (function(wp, $){
  'use strict';

  var _ThemeHelpers = require('./modules/helpers.js');

  /**
   * header
   */
	wp.customize('jayla_header_builder_data', function(value) {
		value.bind(function(newval) {
			console.log(newval);
		});
	});

  /**
   * designer
   */
  wp.customize('jayla_designer_settings', function(value) {
    var designer_helpers_object = new designer_helpers({
      styleElemId: 'jayla-designer-inline-css',
    });

    value.bind(function(newval) {
			if(! newval) return;
      var obj_value = JSON.parse(newval);
      designer_helpers_object.render(obj_value);
		});
  })

  /**
   * designer google fonts
   */
  var theme_extends_render_data_font = function(google_fonts) {
    if(Object.keys(google_fonts).length <= 0) return;
    var result = [];

    $.each(google_fonts, function(font, variant) {
      var item = font;
      if(variant.length > 0) { item += ':' + variant.join(','); }
      result.push(item);
    })

    return result;
  }
  wp.customize('jayla_designer_google_fonts', function(value) {
    value.bind(function(newval) {
      if(! newval) return;
      var obj_value = JSON.parse(newval);

			var font_families = theme_extends_render_data_font(obj_value);
      if(typeof font_families == 'undefined' || !$.isArray(font_families) || font_families.length <= 0) return;

      var font_families = _ThemeHelpers.check_local_fonts( font_families );    
      if( 0 == font_families.length ) return;

      WebFont.load({
        google: {
          families: font_families,
        }
      });
		});
  })

})(window.wp, jQuery);
