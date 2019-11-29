/**
 * Customize blog control
 */
var helpers = require('../helpers.js');

export default function (wp, $) {
    'use strict';

    if ( ! wp || ! wp.customize ) { return; }

	// Set up our namespace.
	var customize_api = wp.customize;
    customize_api.themeExtends = customize_api.themeExtends || {};

    /**
     * Blog customize function control
     */
    customize_api.themeExtends.customizeBlogControl = function() {
        return {
            init () {
                if($('#theme-extends-blog-action-control').length <= 0) return;
                this.vue_setup();
            },
            vue_setup () {

                new Vue({
                    el: '#theme-extends-blog-action-control',
                    store: wp.theme_store,
                    data () {
                        return {

                        }
                    },
                    computed: {
                        root_store () {
                            return this.$store.state.blog;
                        },

                    },
                    watch: {
                        'root_store.data': {
                            handler (data) {
                                // console.log(data);
                                $('textarea#theme-extends-blog-settings-field').val( JSON.stringify(data) ).trigger('change');
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
    customize_api.themeExtends.customizeBlog = new customize_api.themeExtends.customizeBlogControl();
    customize_api.themeExtends.customizeBlog.init();

    /* DOM Ready */
    $(function() {

    })
};
