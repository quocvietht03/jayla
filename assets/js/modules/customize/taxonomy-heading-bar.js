/**
 * Customize taxonomy heading bar control
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
    customize_api.themeExtends.customizeTaxonomyHeadingBarControl = function() {
        return {
            init () {
                this.vue_setup();
            },
            vue_setup () {
                new Vue({
                    el: '#theme-extends-taxonomy-heading-bar-action-control',
                    store: wp.theme_store,
                    data () {
                        return {
                            edit: '',
                            taxonomies_popover: false,
                            taxonomies_popover_remove_settings: false,
                            wp_media_field_params: {
                                'label': "Select Image",
                                'type': "wp-media",
                            },
                            bg_image_size: [
                                { label: 'Cover', value: 'cover' },
                                { label: 'Contain', value: 'contain' },
                                { label: 'Initial', value: 'initial' },
                            ],
                            bg_image_position: [
                                { label: 'Left', value: 'left' },
                                { label: 'Right', value: 'right' },
                                { label: 'Center', value: 'center' },
                            ],
                            bg_image_repeat: [
                                { label: 'No Repeat', value: 'no-repeat' },
                                { label: 'Tile', value: 'repeat' },
                                { label: 'Tile Horizontally', value: 'repeat-x' },
                                { label: 'Tile Vertically', value: 'repeat-y' },
                            ],
                            bg_image_attachment: [
                                { label: 'Scroll', value: 'scroll' },
                                { label: 'Fixed', value: 'fixed' },
                            ],
                        }
                    },
                    computed: {
                        root_store () {
                            return this.$store.state.taxonomyHeadingBar;
                        },
                        taxonomy_data () {
                            return this.root_store.data.jayla_data_taxonomy;
                        },
                        taxonomy_heading_bar_data () {
                            return this.root_store.data.jayla_heading_bar_settings;
                        },
                        taxonomy_heading_bar_panel_class () {
                            var classes = (this.edit) ? 'is-active' : '';
                            return [classes].join(' ');
                        },
                        taxonomy_current_edit () {
                            if(this.taxonomy_heading_bar_data[this.edit]) return this.taxonomy_heading_bar_data[this.edit];
                        },
                    },
                    watch: {
                        'taxonomy_heading_bar_data': {
                            handler (data) {
                                $('textarea#theme-extends-taxonomy-heading-bar-settings-data-field').val(JSON.stringify(data)).trigger('change');
                            },
                            deep: true,
                        },
                    },
                    methods: {
                        select_taxonomy_options(event, name, options) {
                            this.edit = name;
                        },
                        render_new_options(label_text) {
                            // Clone settings
                            var newSettings = JSON.parse(JSON.stringify(theme_customize_object.jayla_taxonomy_settings_default));
                            
                            // change label
                            newSettings.label = `${label_text}`;

                            return newSettings;
                        },
                        check_taxonomy_options_exist(taxonomy_name) {
                            var taxo_opts_exist = Object.keys(this.taxonomy_heading_bar_data);
                            if($.inArray(taxonomy_name, taxo_opts_exist) >= 0) {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        add_taxonomy_settings(event, taxonomy) {
                            if(this.check_taxonomy_options_exist(taxonomy.name)) {
                                // set current edit
                                this.edit = taxonomy.name;
                                
                                // hidden popover
                                this.taxonomies_popover = false;
                                return;
                            }

                            var newSettings = this.render_new_options(`${taxonomy.label} (${taxonomy.posttype})`);
                            
                            // push new taxonomy options
                            Vue.set(this.taxonomy_heading_bar_data, taxonomy.name, newSettings);

                            // set current edit
                            this.edit = taxonomy.name;

                            // hidden popover
                            this.taxonomies_popover = false;
                        },
                        remove_taxonomy_settings(event, taxonomy_name) {
                            // delete settings from list
                            Vue.delete(this.taxonomy_heading_bar_data, taxonomy_name);

                            // set current edit
                            this.edit = '';

                            // hidden popover
                            this.taxonomies_popover_remove_settings = false;
                        }
                    },
                })
            },
        }
    }

    /* Customize ready */
    customize_api.themeExtends.customizeTaxonomyHeadingBar = new customize_api.themeExtends.customizeTaxonomyHeadingBarControl();
    customize_api.themeExtends.customizeTaxonomyHeadingBar.init();

    /* DOM Ready */
    $(function() {

    })
};
