! ( function( w, $ ) {
    'use strict';

    var theme_validate_element_id = '#theme-purchase-code-validate-js';

    function theme_validate_func( $el ) {
        // var $activate_form = $el.find( 'form.theme-verify-purchase-code-form' );
        // var $activate_form = $el.find( 'form.theme-verify-purchase-code-form' );

        // add trigger handle
        $el.on( {
            '__theme_validate.is_load_ajax' (e, st) {
                if( true == st ) {
                    $(this).addClass( '__ajax_load' );
                } else {
                    $(this).removeClass( '__ajax_load' );
                }
            },
            '__theme_validate.update_form' ( e, content ) {
                $(this).html( content );
            },
            '__theme_validate.show_message' (e, type, content) {
                var temp = `<div class='__theme-verify-message __${type}' style="display: none;">
                    <div class="__inner">
                        ${content}
                    </div>
                </div>`;

                $el.find( '.__theme-verify-message-container' ).html( temp );
                $el.find( '.__theme-verify-message-container' )
                .find( '.__theme-verify-message' )
                .slideDown('slow');
            },
            '__theme_validate.request_deactivate_license' (e) {
                var $self = $(this);
                $self.trigger( '__theme_validate.is_load_ajax', [true] );

                $.ajax({
                    type: 'POST',
                    url: theme_backend_script_object.ajax_url,
                    data: {
                        action: 'jayla_ajax_deactive_license_theme',
                    },
                    success ( res ) {
                        $self.trigger( '__theme_validate.is_load_ajax', [false] );

                        if( ! res.success || 'error' == res.data.st ) { 
                            console.log( res );
                            alert( 'Local error, please try again later or contact us support team.' );
                            return;
                        } 

                        if( res.data && res.data.st == 'success' && res.data.content ) {
                            $el.trigger( '__theme_validate.update_form', [res.data.content] )
                            $el.trigger( '__theme_validate.show_message', [res.data.st, res.data.message] );
                            location.reload();
                        }
                    },
                    error (e) {
                        $self.trigger( '__theme_validate.is_load_ajax', [false] );

                        console.log( e );
                        alert( 'Local error, please try again later or contact us support team.' );
                    },
                })
            },
            '__theme_validate.request_check_purchase_code' ( e, code ) {
                var $self = $(this);
                $self.trigger( '__theme_validate.is_load_ajax', [true] );

                $.ajax({
                    type: 'POST',
                    url: theme_backend_script_object.ajax_url,
                    data: {
                        action: 'jayla_ajax_purchase_code_validate',
                        purchase_code: code,
                    },
                    success ( res ) {
                        $self.trigger( '__theme_validate.is_load_ajax', [false] );

                        if( ! res.success ) { 
                            console.log( res );
                            alert( 'Local error, please try again later or contact us support team.' );
                            return;
                        } else {
                            if( res.data && 'error' == res.data.st ) {
                                $el.trigger( '__theme_validate.show_message', [res.data.st, res.data.message] );
                                return;
                            }
                        }

                        if( res.data && res.data.st == 'success' && res.data.content ) {
                            $el.trigger( '__theme_validate.update_form', [res.data.content] )
                            $el.trigger( '__theme_validate.show_message', [res.data.st, res.data.message] );
                            location.reload();
                        }
                    },
                    error (e) {
                        $self.trigger( '__theme_validate.is_load_ajax', [false] );

                        console.log( e );
                        alert( 'Local error, please try again later or contact us support team.' );
                    },
                })
            }
        } )

        $el.on( 'submit', 'form.theme-verify-purchase-code-form', function( e ) {
            e.preventDefault(); 
            var purchase_code_value = $(this).find( 'input#verifytheme_settings_purchase_code' ).val();
            $el.trigger( '__theme_validate.request_check_purchase_code', [purchase_code_value] );

            return false;
        } )

        $el.on( 'submit', 'form.theme-deactivate-form', function(e) {
            e.preventDefault(); 

            if ( confirm("Are you sure you want to deactivate license now?") ) { 
                $el.trigger( '__theme_validate.request_deactivate_license' );
            } 

            return false;
        } )
    }

    $( w ).load( function() {
        new theme_validate_func( $( theme_validate_element_id ) );
    } )
} )( window, jQuery )

export default {}