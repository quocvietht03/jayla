/** 
 * @since 1.1.2
 * Product sticky bar handle script
 *  
 */
!(function(w, $) {
    'use strict';

    var $body = $('body');

    var woo_sticky_product_bar_func = function( $elem, opts ) {
        var self = this;
        this.opts = $.extend({
            classes_target_scroll_selector: '.single_add_to_cart_button',
        }, opts);

        var $productContainerWrapElem = $('#themeextends-woo-product-inner-container');

        // target scroll element
        var $targetScrollElem = $(this.opts.classes_target_scroll_selector);
        $targetScrollElem.on({
            getPos(e) {
                return {
                    // left: $(this).offset().left,
                    top: $(this).offset().top,
                    height: $(this).innerHeight(),
                    // width: $(this).innerWidth(),
                }
            },
        })

        // add trigger event
        $elem.on({
            'focus_product_detail_screen.sticky_product_bar' (e) {
                $('body, html').stop(true, true).animate({
                    scrollTop: $productContainerWrapElem.offset().top - 130
                }, 'slow')
            }
        })

        $elem.on('click.sticky_product_bar_add_to_cart', '.sticky-product-add-to-cart-shortcode-custom-class .button', function(e) {
            var ajax_add_to_cart = $(this).hasClass('ajax_add_to_cart');
            var product_type_external = $(this).hasClass('product_type_external');

            if( ajax_add_to_cart != true && product_type_external == false ) {
                e.preventDefault();
                e.stopPropagation();

                $elem.trigger( 'focus_product_detail_screen.sticky_product_bar' )
            }
        })

        var targetPos = {};
        var scrollTop = 0;

        // scroll event
        $(w).on('scroll.sticky_product_bar', function(e) {
            targetPos = $targetScrollElem.triggerHandler('getPos');
            scrollTop = $(this).scrollTop();

            // bottoming out
            if( scrollTop + $(this).innerHeight() >= $('html').innerHeight() ) {
                $body.addClass('sticky-product-bar-bottoming-out');
            } else {
                $body.removeClass('sticky-product-bar-bottoming-out');
            }

            if( scrollTop > targetPos.top ) {
                $body.addClass('sticky-product-bar-is-active');
            } else {
                $body.removeClass('sticky-product-bar-is-active');
            }
        })

        self.getElem = function() {
            return $elem;
        }

        return this; 
    }

    // Dom ready
    $(function() {
        var $elem = $('.themeextend-sticky-product-bar');
        if( $elem.length > 0 ) {
            new woo_sticky_product_bar_func( $elem );
        }
    })

    // Browser load complete
    $(window).load(function() {

    })
})(window, jQuery)

module.exports = {};