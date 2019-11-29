!( function( w, $ ) {
    'use strict';

    var themeExtendsLoadmoreAjaxPost = function() {
        var $el = $( '.themeextends-scroll-loadmore-post-by-ajax' );

        $el.on({
            '__init.__loadmore_ajax_posts' () {
               $(this).trigger( 'get_next_link.__loadmore_ajax_posts' );
            },
            'get_next_link.__loadmore_ajax_posts' ( e, $content ) {
                var $this_el = $( this );
                $this_el.data( 'next-link', '' );
                
                if( $content ) {
                    var $next_link_el = $content.find( '#post-navigation .next.page-numbers' );
                    if( $next_link_el.length <= 0 ) {
                        $this_el.off( '.__loadmore_ajax_posts' )
                        return;
                    }
                    
                    var next_link_url = $next_link_el.attr( 'href' ); 
                    $this_el.data( 'next-link', next_link_url );
                } else {

                    var $next_link_el = $( '#post-navigation .next.page-numbers' );
                    if( $next_link_el.length <= 0 ) return;

                    var next_link_url = $next_link_el.attr( 'href' );
                    $this_el.data( 'next-link', next_link_url );
                }
            },
            'check_scroll.__loadmore_ajax_posts' () {
                if( $( this ).data( 'event-scroll-disable' ) == true ) return;

                if( ($( w ).scrollTop() + $( w ).height()) > $( this ).offset().top ) {
                    $( this ).trigger( 'loadmore.__loadmore_ajax_posts' );
                }
            },
            'loading.__loadmore_ajax_posts' (e, loading) {
                
                if( true == loading ) {
                    $( this ).addClass( 'is-ajax-loading' )
                } else {
                    $( this ).removeClass( 'is-ajax-loading' )
                }
            },
            'loadmore.__loadmore_ajax_posts' () {
                var $this_el = $( this );
                var next_link = $this_el.data( 'next-link' );
                if( ! next_link ) {
                    $this_el.off( '.__loadmore_ajax_posts' )
                    return;
                }

                // disable event scroll
                $this_el.data( 'event-scroll-disable', true );
                // enable ajax load
                $this_el.trigger( 'loading.__loadmore_ajax_posts', [true] );
                
                $.get( next_link, function( data, status ) {
                    $this_el.trigger( 'loading.__loadmore_ajax_posts', [false] );
                    var $container = $( data );
                    var $filter_elements = $container.find( $this_el.data( 'themeextends-scroll-ajax-element-selector' ) );
                    
                    $this_el.trigger( 'push_content.__loadmore_ajax_posts', [$filter_elements] );
                    $this_el.trigger( 'get_next_link.__loadmore_ajax_posts', [$container] );

                    $this_el.data( 'event-scroll-disable', false );
                } )
            },
            'push_content.__loadmore_ajax_posts' (e, content) {
                var $this_el = $(this);
                var content_selector = $(this).data( 'themeextends-ajax-push-to-element' );

                var $container = $( content_selector );
                $container.append( content );
                
                if( $this_el.data( 'themeextends-scroll-reveal-content-ajax' ) ) {
                    // sr.sync();
                    sr.reveal( $this_el.data( 'themeextends-scroll-reveal-content-ajax' ) );
                    $('body').trigger( '__themeextends_background_image_lazyload.themeextends_lazyload' );
                    $('body').trigger( '__themeextends_image_lazyload_onload.themeextends_lazyload' );
                }
            }
        }).trigger( '__init.__loadmore_ajax_posts' );

        $( w ).on( 'scroll.__loadmore_ajax_posts', function(e) {
            $el.trigger( 'check_scroll.__loadmore_ajax_posts' );
        } )
    }

    $( w ).load( function() {
        themeExtendsLoadmoreAjaxPost();
    } )

} )( window, jQuery )

export default {}