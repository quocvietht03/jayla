/**
 * @package team
 * 
 */

!(function($) {
    'use strict';

    var themeextends_team_single_switching = function() {
        var $elem = $( '.themeextends-team-project-switching' );
        if( $elem.length <= 0 ) return;

        var active_default = $elem.find( '.__btn-switch.__is-active' ).data('active-container')

        $elem.on({
            '__open.team_switching' ( e, classes ) {
                $elem.find( '.__inner' ).removeClass('__is-show')
                $elem.find( classes ).addClass('__is-show')
            }
        }).trigger( '__open.team_switching', [active_default] )

        $elem.on('click', 'a.__btn-switch', function(e) {
            e.preventDefault();

            $(this).addClass('__is-active').siblings().removeClass('__is-active')

            var active_class = $(this).data('active-container');
            $elem.trigger( '__open.team_switching', [active_class] )
        })
    } 

    // DOM Ready
    $(function() {
        themeextends_team_single_switching();
    })
})(jQuery)

module.exports = {};