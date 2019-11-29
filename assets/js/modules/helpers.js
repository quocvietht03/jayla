/**
 * helper js
 * @version 1.0.0
 *
 * - Random Key
 * - Replace String
 * - WP Media Lightbox
 */

$ = jQuery.noConflict();
const jsesc = require("jsesc");

module.exports = {
  /**
   * make random key
   */
  random_key (prefix) {
    var rand_id = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 15);
    return (prefix) ? prefix + '-' + rand_id : rand_id;;
  },
  /**
   * replace string
   */
  replace_str (str, find, replace) {
    for (var i = 0; i < find.length; i++) {
      str = str.replace(new RegExp(find[i], 'gi'), replace[i]);
    }
    return str;
  },
  /**
   * WP Media lightbox
   * @param [Object] opts
   */
  wp_media (opts) {
    var opts = $.extend({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: false,
    }, opts);

    return wp.media(opts);
  },
  is_json_by_string (str) {
    try { JSON.parse(str); } 
    catch (e) { return false; }

    return true;
  },
  jsesc(value = '', opts = {}) {
    return jsesc(value, opts);
  },
  check_local_fonts( font_families ) { 
    var local_fonts = ['Neue Einstellung', 'Futura', 'Texta'];
    var array_clean = function( arr, delete_value ) {
      for (var i = 0; i < arr.length; i++) {
        if (arr[i] == delete_value) {         
          arr.splice(i, 1); i--;
        }
      }
      return arr;
    },

    font_families = font_families.map( function( font ) {
      var f_segment = font.split(':');
      if( -1 == $.inArray( f_segment[0], local_fonts ) ) { return font; }
    } )

    // remove undefined item
    font_families = array_clean( font_families, undefined );
    return font_families;
  }
};
