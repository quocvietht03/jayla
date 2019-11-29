! ( function( w, $ ) {
    'use strict';

    /**
     * 
     * @param {*} $el 
     * @param {*} args 
     */
    var themeExtendsCustomSelectUi = function( $el, args ) {
        return $el.each( function() {
            var $select = $(this);
            var $option = $select.find('[data-theme-extends-select-custom-ui-options]');

            // trigger event
            $select.on({
                '__init.custom_select_ui' (e) {
                    $(this).addClass( 'theme-extends-select-custom-ui' );
                },
                '__open.custom_select_ui' (e) {
                    $(this).toggleClass( 'is-active' );
                    
                },
                '__close.custom_select_ui' (e) {
                    $(this).removeClass( 'is-active' );
                },
                '__toggle.custom_select_ui' (e) {
                    if( $(this).hasClass('is-active') ) {
                        $(this).trigger( '__close.custom_select_ui' );
                    } else {
                        $(this).trigger( '__open.custom_select_ui' );
                    }
                }
            }).trigger( '__init.custom_select_ui' )

            $select.on( 'click.custom_select_ui', function(e) {
                // e.preventDefault();
                e.stopPropagation();
                
                $(this).trigger( '__toggle.custom_select_ui' );
            } )

            $('body').on( 'click.close_custom_select_ui', function(e) {
                if( ! $(e.target).hasClass( 'theme-extends-select-custom-ui' ) ) {
                    $('body')
                        .find( '[data-theme-extends-select-custom-ui-options]' )
                        .trigger( '__close.custom_select_ui' );
                }
            } )

            return $select;
        } )
    }

    /**
     * 
     * @param {*} $el 
     * @param {*} args 
     */
    var themeExtendsMenuMegaDropdown = function($el, args) {
        return $el.each( function() {
            var $selectMenu = $(this);

            $selectMenu.on({
                '__init.menu_mega_dropdown' (e) {
                    $(this).trigger( '__clone_options_offcanvas_ui.menu_mega_dropdown' );
                },
                '__responsive.menu_mega_dropdown' (e) {
                    var browser_width = $( w ).innerWidth();
                    
                    if( 1020 >= browser_width ) {
                        $selectMenu.addClass( '__is-menu-offcanvas-style' );
                    } else {
                        $selectMenu.removeClass( '__is-menu-offcanvas-style' );
                    }
                },
                '__clone_options_offcanvas_ui.menu_mega_dropdown' (e) {
                    var $options_clone = $(this).find('.__options-ui').clone();
                    
                    $selectMenu.$offcanvas_container = $('<div class="widget-mm-dropdown-offcanvas-container"><div class="__inner-container"></div></div>');
                    $selectMenu.$offcanvas_container.find('.__inner-container').append( $options_clone );
                    $selectMenu.$offcanvas_container.on({
                        '__open.menu_mega_dropdown_offcanvas' (e) {
                            $( 'body' ).addClass( '__is_menu_mega_dropdown_offcanvas_open' );
                            $selectMenu.$offcanvas_container.addClass( '__is_show' );
                        },
                        '__close.menu_mega_dropdown_offcanvas' (e) {
                            $( 'body' ).removeClass( '__is_menu_mega_dropdown_offcanvas_open' );
                            $selectMenu.$offcanvas_container.removeClass( '__is_show' );
                        }
                    })

                    $selectMenu.$offcanvas_container.on( 'click.menu_mega_dropdown_offcanvas', 'li.mm-has-submenu > a', function(e) {
                        e.preventDefault();
                        $(this).parent().children( '.__sub-menu' ).stop( true, false ).slideToggle( 'slow' );
                    } )

                    $selectMenu.$offcanvas_container.on( 'click.menu_mega_dropdown_offcanvas_close', function(e) {
                        if( $(e.target).hasClass( '__is_show' ) ) {
                            $selectMenu.$offcanvas_container.trigger( '__close.menu_mega_dropdown_offcanvas' );
                        }
                    } )

                    $('body').append( $selectMenu.$offcanvas_container );
                }
            }).trigger( '__init.menu_mega_dropdown' )  

            $selectMenu.on( 'click.menu_mega_dropdown_offcanvas_ui', '.__select-ui', function(e) {
                e.preventDefault();

                if( ! $selectMenu.hasClass( '__is-menu-offcanvas-style' ) ) return;
                $selectMenu.$offcanvas_container.trigger( '__open.menu_mega_dropdown_offcanvas' );
            } )

            $selectMenu.on( 'click.menu_mega_dropdown_open_menu_on_click', '.__select-ui', function(e) {
                if( ! $selectMenu.hasClass( '__open_menu_on_event_click' ) ) return;
                if( $selectMenu.hasClass( '__is-menu-offcanvas-style' ) ) return;

                $selectMenu.toggleClass( '__is-active' )
            } )

            var timeout_id = null;
            $(w).on( 'resize.widget_menu_mega_dropdown', function(e) {
                clearTimeout( timeout_id );

                timeout_id = setTimeout( function() {
                    $selectMenu.trigger( '__responsive.menu_mega_dropdown' );
                }, 300 );
            } ).trigger( 'resize.widget_menu_mega_dropdown' )
        } )
    }

    /**
     * Widget cat list accordion ui
     * 
     */
    var themeExtendsCatListAccordion = function( $el ) {
        return $el.each( function() {
            var $self = $( this );
            $self.on( 'click', '.__toggle-accordion', function(e) {
                e.preventDefault();
                
                $(this).closest( '.cat-parent' ).toggleClass( '__is-open-accordion' );
                if( $(this).closest( '.cat-parent' ).hasClass( '__is-open-accordion' ) ) {
                    $(this).closest( '.cat-parent' ).children( '.children' ).stop(true, true).slideDown( 'slow', function() {
                        $(w).trigger( 'resize' )
                    } );
                } else {
                    $(this).closest( '.cat-parent' ).children( '.children' ).stop(true, true).slideUp( 'slow', function() {
                        $(w).trigger( 'resize' )
                    } );
                }
                // .children( '.children' ).toogle
            } )
        } )
    }

    var themeExtendsShopArchiverFilterToggle = function() {
        $( 'body' ).on( 'click._shop-archive-filter', '[data-shop-archive-filter-toggle-button]', function(e) {
            e.preventDefault();
            var $self = $(this);
            var layout = $self.data( 'shop-archive-filter-toggle-button' );

            switch( layout ) {
                case 'default':
                    $self.toggleClass( '__is-active' );
                    if( $self.hasClass( '__is-active' ) ) {
                        $('.jayla-archive-filter-tool-bar').stop(true, false).slideDown('slow', function() {
                            $(w).trigger('resize');
                            $(this).find( '.themeextends-apply-smooth-scrollbar-js' ).each(function() {
                                var ss_obj = $(this).data('themeextends-ss-obj');
                                if( ss_obj ) { ss_obj.update() }
                            })
                            // $(this).find.data( 'themeextends-ss-obj', ss_obj );
                            // $(this).find('[data-scrollbar] .scroll-content').scrollTop(0);
                        });
                    } else {
                        $('.jayla-archive-filter-tool-bar').stop(true, false).slideUp('slow', function() {
                            $(w).trigger('resize')
                        });
                    }
                    break;

                case 'off-canvas':
                    $('.jayla-archive-filter-tool-bar').toggleClass( '__is-showing' );
                    break;
            }
        } )

        $( 'body' ).on( 'click.__shop-archive-filter-offcanvas-close', function(e) {
            if( $(e.target).hasClass( '__is-showing' ) ) {
                $(e.target).removeClass( '__is-showing' )
            }
        } )
    }

    $( () => {
        // Custom select ui
        new themeExtendsCustomSelectUi( $('[data-theme-extends-select-custom-ui]') );
        new themeExtendsCatListAccordion( $('ul.__cat-toggle-ui') )

        themeExtendsShopArchiverFilterToggle();
    } )

    $( w ).load( function() {
        // menu mega dropdown
        new themeExtendsMenuMegaDropdown( $('.theme-extends-menu-mega-select-ui') );
    } )

} )( window, jQuery )

export default {}