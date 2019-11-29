/**
 * Customize header control
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
  customize_api.themeExtends.customizeDesignerControl = function() {
    return {
      init () {
        this.vue_setup();
      },
      vue_setup () {

        new Vue({
          el: '#theme-extends-designer-action-control',
          store: wp.theme_store,
          data () {
            return {
              group_style_visible : false,
              stylelist_visible   : false,
              element_target      : false,
              element_target_list : [],
            }
          },
          created: function (el) {

          },
          computed: {
            designer_store () {
              return this.$store.state.designer;
            },
            design_panel_class () {
              return (Object.keys(this.designer_store.data_edit).length > 0) ? 'is-active' : '';
            },
          },
          watch: {
            'designer_store.data': {
              handler (data) {
                this.google_fonts_saving(data);
                $('textarea#theme-extends-design-data-field').val(JSON.stringify(data)).trigger('change');
              },
              deep: true,
            },
            'designer_store.google_fonts': {
              handler (data) {
                $('textarea#theme-extends-design-google-fonts-data-field').val(JSON.stringify(data)).trigger('change');
              },
              deep: true,
            },
            'element_target' (data) {
              this.element_selector_design_handle(data);
            },
          },
          methods: {
            description_element_item_text (item) {
              if(! item.description) return;

              var replace_map = {
                '%group_default%': (item.group_default) ? item.group_default.join(', ') : '',
              };

              return helpers.replace_str(item.description, Object.keys(replace_map), Object.values(replace_map));
            },
            edit_element (item) {
              this.designer_store.data_edit = item;
            },
            clear_edit () {
              this.designer_store.data_edit = {};
            },
            add_block_style (item) {
              var new_block_style = {
                type: item.base_id,
                properties: JSON.parse(JSON.stringify(item.data_map)),
              };

              this.designer_store.data_edit.group_style.push(new_block_style);
              this.group_style_visible = false;
            },
            element_design_exist (css_selector) {
              var element_added = this.designer_store.data.find( item => {
                return css_selector == item.css_selector;
              });

              return element_added;
            },
            add_design_element (item) {
              var css_selector = item.css_selector;
              var element_added = this.element_design_exist(css_selector);

              if(element_added) {
                this.designer_store.data_edit = element_added;
              } else {
                var new_element = {
                  name: item.name,
                  css_selector: item.css_selector,
                  group_style: [],
                };

                this.designer_store.data.push(new_element);
                this.designer_store.data_edit = new_element;
              }

              this.stylelist_visible = false;
            },
            add_design_target_element (event) {
              event.preventDefault();
              this.element_target = ! this.element_target;
            },
            remove_design_element (event) {
              event.preventDefault();

              var index = this.designer_store.data.indexOf(this.designer_store.data_edit);
              this.designer_store.data.splice(index, 1);
              this.clear_edit();
            },
            google_fonts_saving (data) {
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

              Vue.set(this.designer_store, 'google_fonts', fonts);
            },
            get_customize_iframe () {
              return $('#customize-preview').find('iframe')[0].contentWindow.document;
            },
            element_selector_design_handle (type) {
              var self = this;
              var customize_iframe = this.get_customize_iframe();

              if(type == true) {

                $(customize_iframe)
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
                      self.element_target = false;
                    } else {
                      self.add_design_element(design_name, design_css_selector);
                    }
                  },
                })
              } else {

                $(customize_iframe).find('[data-design-selector]')
                .removeClass('is-mouse-hover')
                .off('.designer');
              }
            },
            select_element_default_list (design_name, design_css_selector) {
              var self = this;

              if(typeof design_css_selector == 'object') {
                self.element_target_list = design_css_selector;
                self.stylelist_visible = false;
              } else {
                self.add_design_element(design_name, design_css_selector);
              }
            },
            add_design_element (name, selector) {
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

                self.designer_store.data.push(new_element);
                self.designer_store.data_edit = new_element;
              }

              self.element_target = false;
              self.stylelist_visible = false;
            },
          }
        })

      },
    }
  }

  /* Customize ready */
  customize_api.themeExtends.customizeDesigner = new customize_api.themeExtends.customizeDesignerControl();
  customize_api.themeExtends.customizeDesigner.init();

  /* DOM Ready */
  $(function() {

  })
};
