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
   * Header customize function control
   */
  customize_api.themeExtends.customizeHeaderControl = function() {
    return {
      init () {
        this.vue_setup();
      },
      vue_setup () {
        var self = this;

        new Vue({
          el: '#theme-extends-header-configurator',
          store: wp.theme_store,
          data () {
            return {
              header_panel_inner_classes: ['theme-extends-header-panel-inner', 'is-widget-open'],
              header_customize_layout_tab: 'desktop',
              settings_tab: 'header_strip',
              has_edit: false,
            }
          },
          created: function (el) {
            
          },
          watch: {
            header_edit: {
              handler (data, old_data) {
                this.has_edit = (data.key == old_data.key) ? true : false;
              },
              deep: true,
            }
          },
          computed: {
            root_store () {
              return this.$store.state.header;
            },
            header_edit () {
              return this.root_store.layout_edit;
            },
            widget_sortable_data () {
              return {
                group: {
                  name: 'widgets',
                  pull: "clone",
                },
                animation: 150,
                dragoverBubble: true,
                sort: false,
              }
            },
          },
          methods: {
            toggle_class_open_widget () {
              (this.header_panel_inner_classes.indexOf('is-widget-open') == -1)
                ? this.header_panel_inner_classes.push('is-widget-open')
                : this.header_panel_inner_classes.splice(this.header_panel_inner_classes.indexOf('is-widget-open'), 1);
            },
            clear_header_edit () {
              this.root_store.layout_edit = {};
            },
            update_header_edit () {
              $('textarea#theme-extends-header-builder-data-field, textarea#theme-extends-header-builder-layout-field').trigger('change');
              this.clear_header_edit();
            },
            update_data_on_blur(evt, nameStringBinding) {
              if(evt.target.value == this.header_edit.settings[nameStringBinding]) return;
              Vue.set(this.header_edit.settings, nameStringBinding, evt.target.value)
            },
          }
        })

        new Vue({
          el: '#theme-extends-header-action-control',
          store: wp.theme_store,
          data () {
            return {};
          },
          created: function (el) {
            this.set_layout_current_init();
          },
          computed: {
            root_store () {
              return this.$store.state.header;
            },
            header_edit () {
              return this.root_store.layout_edit;
            },
            header_current () {
              return this.root_store.layout_current;
            },
          },
          watch: {
            header_edit (data) {
              if(Object.keys(data).length > 0) self.openPanel();
              else self.closePanel();
            },
            header_current: {
              handler(data, old_data){ 
                if( data.key == old_data.key ) {
                  $('textarea#theme-extends-header-builder-data-field').val(JSON.stringify(data)); // .trigger('change');
                } else {
                  $('textarea#theme-extends-header-builder-data-field').val(JSON.stringify(data)).trigger('change');
                } 

                // do stuff
                // $('textarea#theme-extends-header-builder-data-field').val(JSON.stringify(data)); // .trigger('change');
              },
              deep: true,
            },
            'root_store.layouts': {
              handler (data) {
                $('textarea#theme-extends-header-builder-layout-field').val(JSON.stringify(data)); //.trigger('change');
              },
              deep: true,
            }
          },
          methods: {
            set_layout_current_init () {
              var self = this,
                  jayla_header_builder_data = $('textarea#theme-extends-header-builder-data-field').val();

              this.root_store.layouts.forEach(function(item) {
                if(JSON.stringify(item) == jayla_header_builder_data.trim()) {
                  self.root_store.layout_current = item;
                }
              })
            },
            header_class_list (item) {
              var classes = ['header-item'];

              if(item == this.header_current) {
                classes.push('selected');
              };

              return classes;
            },
            edit_layout_handle (event, item) {
              event.preventDefault();
              this.$store.state.header.layout_edit = item;
            },
            select_layout_handle (event, item) {
              event.preventDefault();
              this.root_store.layout_current = item;
            },
            remove_layout_handle (event, item, index) {

              if(this.header_current == item) {
                this.root_store.layout_current = this.root_store.layouts[0];
              }

              if(this.header_edit == item) {
                this.root_store.layout_edit = {};
              }

              this.root_store.layouts.splice(index, 1);
            },
            new_layout_handle (event) {
              event.preventDefault();
              var new_layout = {
                "key": helpers.random_key('__layout'), //'__layout-' + new Date(),
                "name": "New Layout",
                "style": "nav-top",
                "settings": {
                  "header_strip_display": false,
                  "header_strip_text": '',
                  "header_strip_button_display": true,
                  "header_strip_button_text": "Read More",
                  "header_strip_link": "#",
                  "header_strip_button_close_display": true,
                  "header_strip_content": "large",
                  "header_tablet_mobile_transform_width": 979,
                  "header_sticky": false,
                },
                "header_sticky_data": [
                  {
                    "key": helpers.random_key('row-element'),
                    "element": "rs-row",
                    "children": [
                      {
                        "key": helpers.random_key('col-element'),
                        "element": "rs-col",
                        "params": {
                          "width": 100
                        },
                        "children": []
                      }
                    ],
                  }
                ],
                "header_tablet_mobile_data": [
                  {
                    "key": helpers.random_key('row-element'),
                    "element": "rs-row",
                    "children": [
                      {
                        "key": helpers.random_key('col-element'),
                        "element": "rs-col",
                        "params": {
                          "width": 100
                        },
                        "children": []
                      }
                    ],
                  }
                ],
                "header_data": [
                  {
                    "key": helpers.random_key('row-element'),
                    "element": "rs-row",
                    "children": [
                      {
                        "key": helpers.random_key('col-element'),
                        "element": "rs-col",
                        "params": {
                          "width": 100
                        },
                        "children": []
                      }
                    ],
                  }
                ]
              };

              this.root_store.layouts.push(new_layout);
              this.root_store.layout_edit = new_layout;
            },

          }
        })
      },
      openPanel () {
        $('body').addClass('theme-extends-header-panel-visible');
      },
      closePanel () {
        $('body').removeClass('theme-extends-header-panel-visible');
      },
    }
  }

  /* Customize ready */
  customize_api.themeExtends.customizeHeader = new customize_api.themeExtends.customizeHeaderControl();
  customize_api.themeExtends.customizeHeader.init();

  /**
   * button toogle header customize panel
   */
  $('body').on('click.toggle_customize_header', '.theme-extends-btn-header-open', function(e) {
    e.preventDefault();

    if($(this).hasClass('btn-is-active')) {
      customize_api.themeExtends.customizeHeader.closePanel();
      $(this).removeClass('btn-is-active');
    } else {
      customize_api.themeExtends.customizeHeader.openPanel();
      $(this).addClass('btn-is-active');
    }
  })

};
