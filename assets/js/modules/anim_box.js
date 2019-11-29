/**
 * @package animBox
 * @author Bearsthemes
 * @version 1.0.0
 */

import _ThemeAnime from 'animejs';
$ = jQuery.noConflict();

!(function(w, $) {
  'use strict';

  var _AnimBoxTimeout = '';
  $(window).off('.anim-box')
  .on({
    '_AnimboxClose.anim-box' (e, triggerType) {
      clearTimeout(_AnimBoxTimeout);

      if(triggerType == 'scroll') {
        _AnimBoxTimeout = setTimeout(function() {
          if($('html').hasClass('theme-extends-designer-frontend-mode')) return;
          // $('*[data-anim-box].__is-active').trigger('_close_on_scroll');
          // $('*[data-anim-box].__is-active').trigger('_close');
        }, 100)
      } else {
        _AnimBoxTimeout = setTimeout(function() {
          if($('html').hasClass('theme-extends-designer-frontend-mode')) return;

          // disable event on mobile with touch event
          var eventType = $('*[data-anim-box].__is-active').data('display-by-event'); 
          if( $.inArray(eventType, ['touchend', 'touchstart']) >= 0 ) return;

          $('*[data-anim-box].__is-active').trigger('_close');
        }, 100)
      }
    },
    'click.anim-box' (e) {
      $(this).trigger('_AnimboxClose.anim-box');
    },
    'scroll.anim-box' (e) {
      $(this).trigger('_AnimboxClose.anim-box', 'scroll');
    },
    'resize.anim-box' (e) {
      $(this).trigger('_AnimboxClose.anim-box', 'resize');
    }
  })
})(window, jQuery)

export default function(params) {
  var params = $.extend({
    el    : '',
    pos   : { top: 0, left: 0 },

    /* callback func */
    onInit (animBoxObj) {
      return;
    },
    onOpen (animBoxObj, anim) {
      var $inner = animBoxObj.getElem('inner');
      $inner.addClass('__is-active-inner-items');
    },
    onClose (animBoxObj, anim) {
      animBoxObj.$el.removeClass('__is-active');
      return;
    },
    onBeforeClose (animBoxObj) {
      var $inner = animBoxObj.getElem('inner');
      $inner.removeClass('__is-active-inner-items');  
      return;
    }
  }, params);

  this.$el          = params.el;
  var $_background  = this.$el.find('.__background-layout'),
      $_inner       = this.$el.find('.__inner');

  /* self */
  var self = this;

  /* in animation */
  var isAnim = false;

  /* set pos */
  var setPosition = function(pos) {
    if(pos.left) self.$el.css('left', pos.left);
    if(pos.top) self.$el.css('top', pos.top);
  }
  setPosition(params.pos);

  /* update pos */
  this.updatePosition = setPosition;

  /**
   * get params
   */
  this.getParams = function() {
    return params;
  }

  /**
   * get element Object
   */
  this.getElem = function(elType) {
    var elObj = {
      'background'  : $_background,
      'inner'       : $_inner,
      'animBox'     : self.$el,
    };

    return elObj[elType];
  }

  /**
   * trigger event
   */
  this.$el.on({
    '_init.anim-box' (e) {
      /* callback func 'onInit' */
      params.onInit.call(this, self);

      var $thisEl = $(this);
      $(this).on('click', '[data-anim-box-close]', function(e) {
        e.preventDefault();
        $thisEl.trigger('_close.anim-box');
      })
    },
    'click.anim-box' (e) {
      e.stopPropagation();
    },
    'touchend.anim-box touchstart.anim-box' (e) {
      e.stopPropagation();
    },
    '_open.anim-box' (e, evt) {

      /* return on 'isAnim' == true */
      if(isAnim == true ) return;
      isAnim = true;

      self.$el.addClass('__is-active');

      _ThemeAnime({
        targets   : $_background[0],
        height    : '100%',
        easing    : 'easeInOutExpo',
        duration  : 600,
        complete (anim) {

          /* callback func 'onOpen' */
          params.onOpen.call(this, self, anim);
          isAnim = false;
        },
      });
    },
    '_close.anim-box' (e) {
      /* return on 'isAnim' == true */
      if(isAnim == true ) return;
      isAnim = true;

      /* callback func 'onBeforeClose' */
      params.onBeforeClose.call(this, self);

      _ThemeAnime({
        targets   : $_background[0],
        height    : 0,
        easing    : 'easeInOutExpo',
        delay     : 600,
        duration  : 600,
        complete (anim) {

          /* callback func 'onClose' */
          params.onClose.call(this, self, anim);
          isAnim = false;
        },
      });
    },
    '_close_on_scroll.anim-box' (e) {
      if($(window).scrollTop() >= $(this).offset().top) {
        $(this).trigger('_close.anim-box');
      }
    },
    '_IsOpen.anim-box' (e) {
      return $(this).hasClass('__is-active');
    },
    '_toggle.anim-box' (e, evt) {
      var $thisEl = $(this),
          IsOpen = $thisEl.triggerHandler('_IsOpen.anim-box');

      if( IsOpen ) {
        $thisEl.trigger('_close.anim-box', [evt]);
      } else {
        $thisEl.trigger('_open.anim-box', [evt]);
      }
    }
  }).trigger('_init.anim-box');

  return this;
}
