/**
 * @package designer frontend
 * @author bearsthemes
 * @version 1.0.0
 */

import designer_helpers from './modules/designer_helpers';

require('brace');
import editor from 'vue2-ace';
import 'brace/mode/css'; import 'brace/theme/monokai';

import { Chrome } from 'vue-color';

!(function(w, d, $) {
  'use strict';

  var _ThemeHelpers = require('./modules/helpers.js');

  ELEMENT.locale(ELEMENT.lang.en);

  var designer_helpers_object = new designer_helpers({
    styleElemId: 'jayla-designer-current-page-inline-css',
  });

  w._designer_frontend_data = $.extend({
    css_inline: '',
    design_data: [],
    // google_fonts: '{}',
  }, (theme_extends_designer_frontend_object.designer_frontend) ? theme_extends_designer_frontend_object.designer_frontend : {});

  /* store */
  const moduleDesignerFrontend   = require('./modules/store/module-designer-frontend.js');
  w.theme_store_frontend = new Vuex.Store({
    modules: {
      designer  : moduleDesignerFrontend,
    }
  });



  /* Vue draggable */
  Vue.directive('draggable-element',      require('./modules/directives/draggable-element') );

  /* Vue field */
  Vue.component( 'input-field',           require('./modules/components/fields/vue-input-field') );
  Vue.component( 'color-picker-field',    require('./modules/components/fields/vue-color-picker-field') );
  Vue.component( 'select-field',          require('./modules/components/fields/vue-select-field') );
  Vue.component( 'wp-widget-fields',      require('./modules/components/fields/vue-wp-widget-fields') );
  Vue.component( 'wp-media-field',        require('./modules/components/fields/vue-wp-media-field') );
  Vue.component( 'typography-field',      require('./modules/components/fields/vue-typography-field') );
  Vue.component( 'design-group-fields',   require('./modules/components/fields/vue-design-group-fields') );
  Vue.component( 'editor',                editor );

  Vue.component(
    "chrome-color-picker-field",  
    Chrome,
  );
  Vue.component(
    "bears-color-picker-field",
    require("./modules/components/fields/vue-bears-color-picker-field.js"),
  );

  /* Vue component */
  Vue.component( 'designer-frontend',     require('./modules/components/vue-designer-frontend-element') );

  /* Designer frontend func */
  var themeExtendsDesignerFrontend = function( params ) {
    this.params = $.extend({
      targetEl: '',
      containerId: 'theme_extends_designer_frontend',
    }, params);

    this.appendController = function() {
      var controllerElem = $('<div>', { id: this.params.containerId, html: '<designer-frontend v-show="designer_enable"></designer-frontend>' });
      $('body').append(controllerElem);

      /* call apply vue */
      this.applyVue();
    }

    this.applyVue = function() {
      new Vue({
        el: document.getElementById(this.params.containerId),
        store: w.theme_store_frontend,
        data: {
          designer_enable     : false,
          element_target_list : [],
          loading: {
            active: false,
            loading_text: 'Saving...',
          },
        },
        created (el) {
          this.enableDesigner();
          this.$on('Event:AddDesignElement', this.addDesignElement);
          this.$on('Event:SaveData', this.saveData);
          this.$on('Event:DisableDesiner', this.disableDesiner);
        },
        // components: { theme_extends_editor },
        computed: {
          designer_store () {
            return this.$store.state.designer;
          },
        },
        mounted () {

        },
        watch: {
          designer_enable (data) {
            this.selectorElementHandle(data);
            this.customHtmlTagClass(data);
            if( data == true && typeof WebFont !== 'function' ) this.loadWebfontScript();
          },
          'designer_store.data': {
            handler (data) {
              this.googleFontsSaving(data);
              designer_helpers_object.render(data, this.designer_store.css_inline);
            },
            deep: true,
          },
          'designer_store.css_inline' (data) {
            designer_helpers_object.render(this.designer_store.data, data);
          },
          'designer_store.google_fonts': {
            handler (data) {
              this.renderDataFonts(data);
            },
            deep: true,
          }
        },
        methods: {
          customHtmlTagClass (data) {
            if(data == true) {
              $('html').addClass('theme-extends-designer-frontend-mode');
            } else {
              $('html').removeClass('theme-extends-designer-frontend-mode');
            }
          },
          saveData () {
            var self = this;

            self.loading.active = true;
            $.ajax({
              type: 'POST',
              url: theme_extends_designer_frontend_object.ajax_url,
              data: {
                action: 'jayla_save_design_frontend_data',
                post_id: theme_extends_designer_frontend_object.post_id,
                data: JSON.stringify(
                  {
                    design_data: this.designer_store.data,
                    google_fonts: JSON.stringify(this.designer_store.google_fonts),
                    css_inline: this.designer_store.css_inline,
                  }
                ),
              },
              success (result) {
                console.log(result);
                self.loading.active = false;
              },
              error (e) {
                console.log(e);
              }
            })
          },
          editorCssUpdate (data) {
            this.designer_store.css_inline = data;
          },
          renderDataFonts (google_fonts) {
            if(Object.keys(google_fonts).length <= 0) return;
            var font_families = [];

            $.each(google_fonts, function(font, variant) {
              var item = font;
              if(variant.length > 0) { item += ':' + variant.join(','); }
              font_families.push(item);
            })

            if(typeof font_families == 'undefined' || !$.isArray(font_families) || font_families.length <= 0) return;
            this.loadWebFont(font_families);
          },
          loadWebFont(font_families) {
            var font_families = _ThemeHelpers.check_local_fonts( font_families );    
            if( 0 == font_families.length ) return;
            
            WebFont.load({
              google: {
                families: font_families,
              }
            });
          },
          loadWebfontScript () {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = 'https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
          },
          googleFontsSaving (data) {
            var self = this;
            var fonts = {};
            if(data.length <= 0) return fonts;

            var typography_block = [];
            $.each(data, function(index, item) {
              var style = item.group_style.filter(item => {
                return 'typography' == item.type;
              })

              if(style.length > 0) typography_block.push(style[0].properties);
            })

            if(typography_block.length > 0) {
              $.each(typography_block, function(index, item) {
                var typography = item.typography;
                if(typography.font_family == '') return;

                if(! fonts[typography.font_family]) {
                  fonts[typography.font_family] = (typography.font_variant && typography.font_variant != 'regular') ? [typography.font_variant] : [];
                } else {
                  if($.inArray(typography.font_variant, fonts[typography.font_family]) == -1 && 'regular' != typography.font_variant){
                    fonts[typography.font_family].push(typography.font_variant);
                  }
                }
              })
            }
            this.designer_store.google_fonts = fonts;
            // Vue.set(this.designer_store, 'google_fonts', fonts);
          },
          selectorElementHandle (type) {
            var self = this;

            if(type == true) {

              $('body')
              .find('[data-design-selector]')
              .off('.designer')
              .on({
                'mouseover.designer' (e) {

                  $(this).addClass('is-mouse-hover');
                  e.stopPropagation();
                },
                'mouseout.designer' (e) {

                  $(this).removeClass('is-mouse-hover');
                  e.stopPropagation();
                },
                'click.designer' (e) {
                  e.preventDefault();
                  e.stopPropagation();

                  var design_name = $(this).data('design-name'),
                      design_css_selector = $(this).data('design-selector');

                  if(typeof design_css_selector == 'object') {
                    self.element_target_list = design_css_selector;
                    self.designer_store.data_edit = {};
                  } else {
                    self.addDesignElement(design_name, design_css_selector);
                  }
                },
              })
            } else {
              $('body').find('[data-design-selector]')
              .removeClass('is-mouse-hover')
              .off('.designer');
            }
          },
          enableDesigner () {
            var self = this;
            $('body').on('click', '#wp-admin-bar-designer_current_page > a', function(e) {
              e.preventDefault();
              self.designer_enable = true;
            })
          },
          disableDesiner () {
            this.designer_enable = false;
          },
          addDesignElement (name, selector) {
            var self = this;
            var element_added = self.element_design_exist(selector);

            if(element_added) {
              self.designer_store.data_edit = element_added;
            } else {
              var new_element = {
                name: name,
                css_selector: selector,
                group_style: [],
              };

              this.designer_store.data.push(new_element);
              this.designer_store.data_edit = new_element;
            }
          },
          element_design_exist (css_selector) {

            var element_added = this.designer_store.data.find( item => {
              return css_selector == item.css_selector;
            });

            return element_added;
          }
        }
      })
    }

    this.init = function() {
      this.appendController();
    }

    this.init();
    return this;
  }

  /* Load complete */
  $(w).load( () => {
    // console.log(theme_extends_designer_frontend_object);
    var designerObj = new themeExtendsDesignerFrontend( {
      targetEl: 'li#wp-admin-bar-designer_current_page > a',
    } );
  } )

})(window, document, jQuery)
