!(function(w, $) {
    'use strict';

    var ThemeExtendsAJaxSearch = function($el, options) {
        var opts = $.extend({
            ajax_action: '',
            result_content_class: '.result-search-content-wrapper',
            on_ajax_success_cb () { return; },
            on_ajax_error_cb () { return; },
        }, options)
        
        var self = this;

        // trigger events
        $el.on({
            '__open.ajax_search' (e) {
                $('body').addClass( 'theme-extends-custom-search-is-active' );
                $(this).trigger('__focus_search_field.ajax_search');
            },
            '__close.ajax_search' (e) {
                $('body').removeClass( 'theme-extends-custom-search-is-active' );
            },
            '__focus_search_field.ajax_search' (e) {
                setTimeout( () => {
                    $(this).find('input[type="search"]').focus();
                }, 300 )
            },
            '__search_on_type.ajax_search' (e, search_text) {
                // add ajax loading class
                $el.trigger('__ajax_load.ajax_search', [true]);

                $.ajax({
                    type: 'POST',
                    url: theme_script_object.ajax_url,
                    data: { action: opts.ajax_action, data: { s: search_text } },
                    success (res) {

                        // remove ajax loading class
                        $el.trigger('__ajax_load.ajax_search', [false]);

                        opts.on_ajax_success_cb.call( self, $el, res );
                    },
                    error (e) {
                        // remove ajax loading class
                        $el.trigger('__ajax_load.ajax_search', [false]);

                        opts.on_ajax_error_cb.call( self, $el, e );
                    }
                })
            },
            '__update_result_content.ajax_search' (e, content) {
                $el.find( opts.result_content_class ).html(content);
            },
            '__ajax_load.ajax_search' (e, status) {
                if( true == status ) {
                    $el.addClass( 'is-ajax-load' );
                } else {
                    $el.removeClass( 'is-ajax-load' );
                }
            },
        })

        var timeout = null;
        $el.on('input', 'input[type="search"]', function(e) {
            clearTimeout( timeout );

            let $input = $(this);
            let string = $input.val();

            if( string == '' ) return;

            timeout = setTimeout( () => {
                $el.trigger( '__search_on_type.ajax_search', [string] );
            }, 1000 )
        })

        $el.on( 'click.close_custom_search_lightbox', '.__close', function(e) {
            e.preventDefault();
            $el.trigger( '__close.ajax_search' );
        } )

        this.get_options = function() {
            return opts;
        }
        
        $el.data( 'themeextends-ajax-search-obj', this );
        return $el;
    }

    $( () => {
        var opts = {
            ajax_action: 'jayla_widget_custom_search_ajax_func',
            on_ajax_success_cb ($el, res) {
                if( true == res.success ) {
                    $el.addClass( '__animate_push_content' );
                    $el.trigger( '__update_result_content.ajax_search', [res.data.content] )
                }
            }
        };
        var $AjaxSearchElement = new ThemeExtendsAJaxSearch( $('.theme-extends-custom-search-ajax-js'), opts );

        $( 'body' ).on( 'click.ajax_custom_search', '[data-theme-extends-trigger-ajax-custom-search]', function(e) {
            e.preventDefault();

            $AjaxSearchElement.trigger( '__open.ajax_search' );
        } )
    } )
})(window, jQuery)

export default {}