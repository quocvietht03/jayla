/**
 * @package jayla 
 *
 */

!( function( w, $ ) {
    'use strict';
    var $body = $('body');

    var ShoppingContentCartOffCanvas_Func = function( $el, params ) {
        $el.on({
            '__open.shopping_content_cart_offcanvas' (e) {
                $body.addClass('shopping-content-cart-offcanvas-is-open');
            },
            '__close.shopping_content_cart_offcanvas' (e) {
                $body.removeClass('shopping-content-cart-offcanvas-is-open');
            },
        })

        $el.on('click.shopping_content_cart_offcanvas', '.__close', function(e) {
            e.preventDefault();
            $el.trigger( '__close.shopping_content_cart_offcanvas' )
        })

        $el.on('click.close_shopping_content_cart_offcanvas', function(e) {
            if( $(e.target).hasClass('theme-extends-shopping-content-cart-offcanvas') ) {
                $el.trigger( '__close.shopping_content_cart_offcanvas' )
            }
        })

        return $el;
    }

    $( () => {
        var $ShoppingContentCartOffcanvas = ShoppingContentCartOffCanvas_Func( $('.theme-extends-shopping-content-cart-offcanvas') );
        
        $('body').on('click.trigger_shopping_content_cart_offcanvas', '[data-theme-extends-trigger-shopping-content-cart-offcanvas]', function(e) {
            e.preventDefault();
            $ShoppingContentCartOffcanvas.trigger( '__open.shopping_content_cart_offcanvas' );
        })

        $('body').on('added_to_cart', () => {
            if( $('[data-theme-extends-trigger-shopping-content-cart-offcanvas]').length > 0 ) {
                $ShoppingContentCartOffcanvas.trigger( '__open.shopping_content_cart_offcanvas' );
            }
        })
    } )

} )( window, jQuery )

export default {};