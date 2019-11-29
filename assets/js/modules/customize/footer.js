/**
 * Customize footer control
 */
var helpers = require('../helpers.js');

export default function (wp, $) {
  'use strict';

  if ( ! wp || ! wp.customize ) { return; }

	// Set up our namespace.
	var customize_api = wp.customize;
  customize_api.themeExtends = customize_api.themeExtends || {};

  /**
   * Footer customize function control
   */
  customize_api.themeExtends.customizeFooterControl = function() {
    return {
      init () {
        this.vue_setup();
      },
      vue_setup () {
        var self = this;

        new Vue({
          el: '#theme-extends-footer-configurator',
          store: wp.theme_store,
          data () {
            return {
              footer_panel_inner_classes: ['theme-extends-footer-panel-inner', 'is-widget-open'],
              footer_customize_layout_tab: 'desktop',
              settings_tab: 'footer_strip',
              has_edit: false,
            }
          },
          created: function () {

          },
          watch: {
            footer_edit: {
              handler (data, old_data) {
                this.has_edit = (data.key == old_data.key) ? true : false;
              },
              deep: true,
            }
          },
          computed: {
            root_store () {
              return this.$store.state.footer;
            },
            footer_edit () {
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
              (this.footer_panel_inner_classes.indexOf('is-widget-open') == -1)
                ? this.footer_panel_inner_classes.push('is-widget-open')
                : this.footer_panel_inner_classes.splice(this.footer_panel_inner_classes.indexOf('is-widget-open'), 1);
            },
            clear_footer_edit () {
              this.root_store.layout_edit = {};
            },
            update_footer_edit () {
              $('textarea#theme-extends-footer-builder-data-field, textarea#theme-extends-footer-builder-layout-field').trigger('change');
              this.clear_footer_edit();
            },
          }
        })

        new Vue({
          el: '#theme-extends-footer-action-control',
          store: wp.theme_store,
          created: function (el) {
            this.set_layout_current_init();
          },
          computed: {
            root_store () {
              return this.$store.state.footer;
            },
            footer_edit () {
              return this.root_store.layout_edit;
            },
            footer_current () {
              return this.root_store.layout_current;
            },
          },
          watch: {
            footer_edit (data) {
              if(Object.keys(data).length > 0) self.openPanel();
              else self.closePanel();
            },
            footer_current: {
              handler(data, old_data){
                if( data.key == old_data.key ) {
                  $('textarea#theme-extends-footer-builder-data-field').val(JSON.stringify(data)); // .trigger('change');
                } else {
                  $('textarea#theme-extends-footer-builder-data-field').val(JSON.stringify(data)).trigger('change');
                } 

                 // do stuff
                 // $('textarea#theme-extends-footer-builder-data-field').val(JSON.stringify(data)).trigger('change');
              },
              deep: true,
            },
            'root_store.layouts': {
              handler (data) {
                $('textarea#theme-extends-footer-builder-layout-field').val(JSON.stringify(data)); //.trigger('change');
                // $('textarea#theme-extends-footer-builder-layout-field').val(helpers.jsesc(data)).trigger('change');
              },
              deep: true,
            }
          },
          methods: {
            set_layout_current_init () {
              var self = this,
                  jayla_footer_builder_data = $('textarea#theme-extends-footer-builder-data-field').val();

              this.root_store.layouts.forEach(function(item) {
                if(JSON.stringify(item) == jayla_footer_builder_data.trim()) {
                  self.root_store.layout_current = item;
                }
              })
            },
            footer_class_list (item) {
              var classes = ['footer-item'];

              if(item == this.footer_current) {
                classes.push('selected');
              };

              return classes;
            },
            edit_layout_handle (event, item) {
              event.preventDefault();
              this.root_store.layout_edit = item;
            },
            select_layout_handle (event, item) {
              event.preventDefault();
              this.root_store.layout_current = item;
            },
            remove_layout_handle (event, item, index) {

              if(this.footer_current == item) {
                this.root_store.layout_current = this.root_store.layouts[0];
              }

              if(this.footer_edit == item) {
                this.root_store.layout_edit = {};
              }

              this.root_store.layouts.splice(index, 1);
            },
            new_layout_handle (event) {
              event.preventDefault();
              var new_layout = {
                "key": helpers.random_key('__layout'), // new Date(),
                "name": "New Layout",
                "style": "nav-top",
                "settings": {
                  "footer_strip_display": false,
                  "footer_strip_text": '',
                  "footer_strip_button_display": true,
                  "footer_strip_button_text": "Read More",
                  "footer_strip_link": "#",
                  "footer_strip_button_close_display": true,
                  "footer_strip_content": "container",
                  "footer_tablet_mobile_transform_width": 979,
                  "footer_sticky": false,
                },
                "footer_sticky_data": [
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
                "footer_tablet_mobile_data": [
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
                "footer_data": [
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
        $('body').addClass('theme-extends-footer-panel-visible');
      },
      closePanel () {
        $('body').removeClass('theme-extends-footer-panel-visible');
      },
    }
  }

  /* Customize ready */
  customize_api.themeExtends.customizeFooter = new customize_api.themeExtends.customizeFooterControl();
  customize_api.themeExtends.customizeFooter.init();

  /**
   * button toogle footer customize panel
   */
  $('body').on('click.toggle_customize_footer', '.theme-extends-btn-footer-open', function(e) {
    e.preventDefault();

    if($(this).hasClass('btn-is-active')) {
      customize_api.themeExtends.customizeFooter.closePanel();
      $(this).removeClass('btn-is-active');
    } else {
      customize_api.themeExtends.customizeFooter.openPanel();
      $(this).addClass('btn-is-active');
    }
  })

};
