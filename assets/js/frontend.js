/**
 * @name    ThemeScript
 * @author  Bearsthemes
 *
 * Main script
 *
 * @version 1.0.0
 */

import _ThemeAnime from 'animejs';
import _ThemeNprogress from 'nprogress';
import _ThemeScrollReveal from 'scrollreveal';
import _ThemeSwiper from 'swiper';
import _ThemeZooming from 'zooming';
import _ThemeLightGallery from 'lightgallery.js';
import _ThemeLightGallery_addon_Video from '../vendors/lightgallery/addon/lg-video.min.js';
import _ThemeMouseTip from './modules/mousetip.min';
import _ThemeAnimBox from './modules/anim_box';
import './modules/zoomove.js';
import _ThemeFuryGrid from '../vendors/furygrid/jquery.furygrid.js';
import _ThemePlyr from 'Plyr';
import _ThemeScrollbar from 'smooth-scrollbar';
require('./modules/delipress_newsletter_lightbox.js');
require('./modules/jetpack-portfolio.js');
require('./modules/team.js');
require('./modules/scroll_loadmore_ajax_posts.js');

! (function(w, d, $) {
  'use strict';

  /**
   * Global variable
   */
  var _themeGlobalVariable = {};
  _themeGlobalVariable.StickySidebarObject = [];

  /**
   * @since 1.0.0
   * Progress page loading
   */
  var _themeProgressHandle = function() {
    if(! $('body').hasClass('_page-loading-active')) return;

    _ThemeNprogress.configure({ easing: 'ease', speed: 800, parent: '#page' });

    // Enable progress page loading bar
    _ThemeNprogress.start();

    $(w).load(function() {
      // set loading bar 100%
      _ThemeNprogress.done();
      $('body').removeClass('_page-loading-active');
    })
  }
  _themeProgressHandle();

  // var ElementQueries = require('css-element-queries/src/ElementQueries');

  /* jparallax */
  require('jarallax');
  require('jarallax/dist/jarallax-video.min');
  require('jarallax/dist/jarallax-element.min');

  /* sticky sidebar */
  require('sticky-sidebar');

  var _ThemeHelpers = require('./modules/helpers.js');

  var _ThemeZoomingObject = new _ThemeZooming();

  /* lightslider js */
  require('./modules/lightslider.js');

  /* WooCommerce Script */
  require( './modules/woo_add_to_cart_event_handle.js' );
  require( './modules/woo_product_sticky_bar.js' );

  /* search ajax api */
  require( './modules/search_ajax.js' );
  
  /* widgets script */
  require( './modules/widgets.js' );

  /**
   * load webfont script
   * @since 1.0.0
   */
  var _loadWebfontScript = function() {
    var wf = d.createElement('script'), s = d.scripts[0];
    wf.src = 'https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js';
    wf.async = true;
    s.parentNode.insertBefore(wf, s);
  }

  /**
   * Theme script api main function
   * @since 1.0.0
   *
   * load google fonts
   */
  var themeScriptApi = function() {

    /**
     * load google font
     * @since 1.0.0
     */
    this.loadGoogleFonts = function(font_families) {
      
      var font_families = _ThemeHelpers.check_local_fonts( font_families );
      if( 0 == font_families.length ) return;
      
      w.WebFontConfig = {
        google: {
          families: font_families
        },
        timeout: 1000 // Set the timeout to two seconds
      };
    }

    this.headerHandleScript = function($header_elem) {
      $header_elem.each(function() {
        var $header = $(this),
            opts = $header.data('header-settings');

        var headerSticky = function() {
          var headerStickyElem = $header.find('.header-builder__sticky');
          
          /* event mousewheel */
          $(w).on('wheel.HeaderStickyScroll', function( e ) {
            if( ! e.originalEvent || ! e.originalEvent.deltaY ) return;
            if(e.originalEvent.deltaY < 0) {
              // console.log('scrolling up !');
              if( (e.originalEvent.deltaY * -1) >= 10 ) {
                $header.addClass( '__sticky-showing' );
              }
            }
            else{
              // console.log('scrolling down !');
              if( e.originalEvent.deltaY >= 10 ) {
                $header.removeClass( '__sticky-showing' );
              }
            }
          })

          /* scroll handle */
          $(w).on('scroll.HeaderStickyScroll', function(e) {

            if(($header.find('.header-builder__main').innerHeight() * 2) <= $(this).scrollTop()) {
              /* enable sticky */
              $header.addClass('sticky-on');
            } else {
              /* disable sticky */
              $header.removeClass('sticky-on');
            }
          })
        }

        if(opts.header_sticky == true) headerSticky();
      })
    }

    this.sticky_element = function() {
      var $el = $('[data-sticky-element]');

      $el.each(function() {
        var $this = $(this),
            opts = $this.data('sticky-element');

        var StickySidebarObject = new w.StickySidebar(this, opts);
        _themeGlobalVariable.StickySidebarObject.push( StickySidebarObject );

        $this.data('sticky-sidebar-object', StickySidebarObject);

        $this.on({
          '_update.sticky-sidebar' (e) {
            var ss_object = $(this).data('sticky-sidebar-object');
            if(! ss_object) return;

            ss_object.updateSticky();
          },
        })

        var _loopInterVal = '';
        $this.bind("DOMSubtreeModified",function(){
          /* clear loop interVal */
          if(_loopInterVal) clearInterval(_loopInterVal);

          _loopInterVal = setInterval(function() {
            $this.trigger('_update.sticky-sidebar');
            clearInterval(_loopInterVal);
          }, 1000)
        });
      })

      $(document).ajaxComplete(function() {
        setTimeout(function() {
          $('[data-sticky-element]').trigger('_update.sticky-sidebar');
        }, 1000)
      });
    }

    this.loadGoogleFontsCurrentPage = function() {
      if(! theme_script_object.designer_frontend_google_font_families) return;

      var font_families = _ThemeHelpers.check_local_fonts( theme_script_object.designer_frontend_google_font_families );
      if( 0 == font_families.length ) return;

      WebFont.load({
        google: {
          families: font_families, // theme_script_object.designer_frontend_google_font_families,
        }
      });
    } 

    this.loadEmojiScript = function() {
      w._wpemojiSettings = {"baseUrl":"http://s.w.org/images/core/emoji/72x72/","ext":".png","source":{"concatemoji": theme_script_object.site_url +"/wp-includes/js/wp-emoji-release.min.js"}};
      !function(a,b,c){function d(a){var c=b.createElement("canvas"),d=c.getContext&&c.getContext("2d");return d&&d.fillText?(d.textBaseline="top",d.font="600 32px Arial","flag"===a?(d.fillText(String.fromCharCode(55356,56812,55356,56807),0,0),c.toDataURL().length>3e3):(d.fillText(String.fromCharCode(55357,56835),0,0),0!==d.getImageData(16,16,1,1).data[0])):!1}function e(a){var c=b.createElement("script");c.src=a,c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f;c.supports={simple:d("simple"),flag:d("flag")},c.supports.simple&&c.supports.flag||(f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
    }

    /**
     * Menu accordion
     */
    this.menuAccordion = function($el) {
      $el.each(function() {
        var $thisEl = $(this);

        /* append toggle button */
        this.appendToggleButton = function() {
          var toogleBtn = $('<span>', {
            class: 'theme-extends-nav-button-toggle-sub',
            html: '<i class="ion-plus"></i>',
          })

          toogleBtn.on({
            '_open' () {
              $(this)
              .addClass('_is_open')
              .html('<i class="ion-minus"></i>');

              $(this).parent().find('> ul.sub-menu, > section.bmm-megamenu-section').slideDown('slow');
            },
            '_close' () {
              $(this)
              .removeClass('_is_open')
              .html('<i class="ion-plus"></i>');

              $(this).parent().find('> ul.sub-menu, > section.bmm-megamenu-section').slideUp('slow');
            },
            '_is' (e, st) {
              if(st == 'open') {
                if($(this).hasClass('_is_open')) return true;
                else return false;
              } else if(st == 'close') {
                if(! $(this).hasClass('_is_open')) return true;
                else return false;
              }
            },
            '_toggle' () {
              var st = $(this).triggerHandler('_is', ['open']);
              if(st == true) $(this).trigger('_close');
              else $(this).trigger('_open');
            },
          });

          $thisEl.find('.menu-item.menu-item-has-children').append(toogleBtn);
        }
        this.appendToggleButton();

        /* button toggle handle */
        this.toggleButtonClickHandle = function() {
          $thisEl.on('click.nav-toogle-submenu', '.theme-extends-nav-button-toggle-sub', function(e) {
            e.preventDefault();
            $(this).trigger('_toggle');
          })
        }
        this.toggleButtonClickHandle();
      })
    }

    /* control toggle class */
    this.clickToggleClass = function($controlEl, $targetEl, $classToggle, callback) {
      $controlEl.on('click', function(e) {
        e.preventDefault();
        $targetEl.toggleClass($classToggle);

        if(callback) callback.call(this, $controlEl, $targetEl);
      })
    }

    this.eventUpDownInputNumber = function($el) {
      $el.off('.eventUpDownInputNumber').on({
        '_getParams.eventUpDownInputNumber' (e) {
          return {
            value : parseFloat(this.value)  || 0,
            min   : parseFloat(this.min)    || 0,
            max   : parseFloat(this.max)    || 999999999,
            step  : parseFloat(this.step)   || 1,
          };
        },
        '_up.eventUpDownInputNumber' (e) {
          var data = $(this).triggerHandler('_getParams.eventUpDownInputNumber'),
              newNumber = data.value + data.step;

          if(newNumber >= data.max) return;
          this.value = newNumber;
        },
        '_down.eventUpDownInputNumber' (e) {
          var data = $(this).triggerHandler('_getParams.eventUpDownInputNumber'),
              newNumber = data.value - data.step;

          if(newNumber <= data.min) {
            this.value = data.min;
            return;
          }

          this.value = newNumber;
        }
      })
    }

    /* product qty button up/down handle */
    this.productQtyButtonHandle = function() {
      var self = this;
      $('body').on('click', '.theme-extends-woo-custom-quantity > .theme-extends-woo-qty', function(e) {
        e.preventDefault();
        var $this = $(this),
            $input = $this.parent().find('input[type="number"]');

        /* add event */
        self.eventUpDownInputNumber($input);

        if($this.hasClass('button-minus')) {
          /* down number */
          $input.trigger('_down.eventUpDownInputNumber');
        } else {
          /* increase number */
          $input.trigger('_up.eventUpDownInputNumber');
        }

        $input.trigger('change');
      })
    }

    this.navSlide = function() {
      $('[data-nav-slide]').each(function(e) {
        var self = this,
            $thisEl = $(this),
            $elWrap = $('<div>', { class: 'theme-extends-nav-slide-wrap nav-slide-wrap' });

        self.opts = $.extend({
          selector: '',
          step: 200,
        }, {
          selector: $thisEl.data('nav-slide-selector'),
          step: $thisEl.data('nav-slide-step') || 200,
        })

        self.info = {
          wrapWidth: 0,
          allItemWidth: 0,
        };
        self.setInfo = function() {
          self.info.wrapWidth = $thisEl.innerWidth();
          self.info.allItemWidth = 0;
          $thisEl.find(self.opts.selector).each(function() {
            var $itemEl = $(this);
            self.info.allItemWidth += $itemEl.innerWidth() + parseFloat($itemEl.css('margin-left')) + parseFloat($itemEl.css('margin-right')) + 4;
          })
        }

        $thisEl
        .wrap($elWrap)
        .wrap('<div class="__inner"></div>');

        $thisEl.parent().before('<span class="nav-item nav-left-handle"><i class="fa fa-angle-left" aria-hidden="true"></i></span>');
        $thisEl.parent().after('<span class="nav-item nav-right-handle"><i class="fa fa-angle-right" aria-hidden="true"></i></span>');

        var $parentEl = $(this).closest('.nav-slide-wrap');

        $thisEl.on({
          '_init.nav-slide' () {
            self.setInfo();
            if(self.info.allItemWidth >= $parentEl.innerWidth()) {
              $parentEl.addClass('_active-nav-slide');
            } else {
              $parentEl.removeClass('_active-nav-slide');
            }
          },
          '_info.nav-slide' (e) {
            return {
              wrapWidth     : $parentEl.innerWidth(),
              innerWidth    : $parentEl.find('.__inner').width(),
              allItemWidth  : self.info.allItemWidth,
              marginLeft    : parseFloat($thisEl.css('margin-left')),
            };
          },
          '_next.nav-slide' (e) {
            var currentInfo = $(this).triggerHandler('_info.nav-slide'),
                newPos = currentInfo.innerWidth + (currentInfo.marginLeft * -1) + self.opts.step;

            if(newPos >= currentInfo.allItemWidth) {
              newPos = currentInfo.allItemWidth - currentInfo.innerWidth;
            }

            $thisEl.stop(true, false).animate({
              marginLeft: newPos * -1,
            }, 'slow')

          },
          '_prev.nav-slide' (e) {
            var currentInfo = $(this).triggerHandler('_info.nav-slide'),
                newPos = (currentInfo.marginLeft * -1) - self.opts.step;

            if(newPos <= 0) {
              newPos = 0;
            }

            $thisEl.stop(true, false).animate({
              marginLeft: newPos * -1,
            }, 'slow')
          },
        }).trigger('_init.nav-slide')

        $parentEl
        .on('click.nav-slide', '.nav-item', function(e) {
          e.preventDefault();

          if($(this).hasClass('nav-left-handle'))
            $thisEl.trigger('_prev.nav-slide')
          else
            $thisEl.trigger('_next.nav-slide')
        })

        $thisEl.css('min-width', self.info.allItemWidth);
        $thisEl.data('nav-slide-object', this);
      })

      $(w).on('resize', function() {
        $('[data-nav-slide]').trigger('_init.nav-slide');
      })
    }

    this.searchForm = function($el) {
      var _doAnime = {
        'open' (params) {

          var elBackground = $el.find('.__background-layout');
              // elContent = $el.find('.__inner');

          if(params.pos.right) $el.css('right', params.pos.right);
          if(params.pos.top) $el.css('top', params.pos.top);

          var animData = {
            targets: elBackground[0],
            // width: '100%',
            height: '100%',
            easing: 'easeInOutExpo',
            duration: 600,
            complete (anim) {
              if(params.complete) params.complete.call(this, anim);
            },
          };

          _ThemeAnime(animData);
        },
        'close' (params) {

          /* close background layout */
          var elBackground = $el.find('.__background-layout');
              // elContent = $el.find('.__inner');

          params = $.extend({
            targets: elBackground[0],
            // width: 0,
            height: 0,
            easing: 'easeInOutExpo',
            delay: 600,
            duration: 600,
            complete (anim) {
              if(params.complete) params.complete.call(this, anim);
            },
          }, params);

          _ThemeAnime(params);
        },
      }

      $el.on({
        '_open.search-form' (e, params) {
          $('body').addClass('is-search-form-active');

          var self = this;
          _doAnime.open({
            pos: params,
            complete(anim) {
              $(self).find('.__inner').addClass('active-item-anim');
            },
          });
        },
        '_close.search-form' (e, params) {
          var self = this;
          $(self).find('.__inner').removeClass('active-item-anim');

          _doAnime.close({
            complete (anim) {
              $('body').removeClass('is-search-form-active');
            },
          });
        },
        '_toggle.search-form' (e, params) {
          if($('body').hasClass('is-search-form-active')) {
            $(this).trigger('_close.search-form', params);
          } else {
            $(this).trigger('_open.search-form', params);
          }
        },
        '_loadData.search-form' (e, data, callback) {
          $.ajax({
            type: 'POST',
            url: theme_script_object.ajax_url,
            data: {action: 'jayla_search_form_ajax_load_data', s: data},
            success (result) {
              if(callback) callback.call(this, result);
            },
            error (e) { console.log(e); }
          })
        },
        '_updateResult.search-form' (e, content) {
          // .result-content
          $(this).find('.result-content').empty().append(content);

          if(!content) return;
          /* anim */
          anime({
            targets: document.querySelectorAll('#theme-extends-widget-search-form .result-item'),
            opacity: 1,
            easing: 'easeInOutExpo',
            delay: function(el, i, l) {
              return i * 100;
            }
          });
        },
        '_searchHandle.search-form' (e) {
          var $thisEl = $(this);
          $(this).find('input.search-field').on('input', function(e) {
            var $input = $(this),
                s = $input.val();

            if(! s) return;

            $thisEl.trigger('_loadData.search-form', [s, function(result) {
              if(result.s != $input.val()) return;
              $thisEl.trigger('_updateResult.search-form', result.content);
            }])
          })
        },
      }).trigger('_searchHandle.search-form');

      $el.on('click touchstart touchend', function(e) {
        e.stopPropagation();
        if(e.gesture) e.gesture.stopPropagation();
      })

      $el.find('.search-form-close').on('click touchend', function(e) {
        e.preventDefault();
        $el.trigger('_close.search-form');
      })

      /* close on click */
      $('body').on('click', function(e) {
        $el.trigger('_close.search-form');
      })

      /* close seach form on resize */
      var resizeTimeout = '';
      $(w).on('resize.search-form', function(e) {
        // console.log($el.data('display-by-event'), '1');

        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
          resizeTimeout = '';
          $el.trigger('_close.search-form');
        }, 200)
      })

      return $el;
    }

    /**
     * @since 1.0.0
     * Heade strip script
     */
    this.headerStripHandle = function () {
      $('body').on('click.header-strip', '.header-strip-close', function(e) {
        e.preventDefault();
        $(this).parents('#theme-extends-header-strip').slideUp('slow', function() {
          $(w).trigger('resize');
        });
      })
    }

    // Scroll top
    this.ScrollTop = function() {
      if($('#theme-scroll-top-wrap').length <= 0) return;

      $('#theme-scroll-top-wrap')
      $('body').on('click', '#theme-scroll-top-wrap', function(e) {
        e.preventDefault();
        $('body, html').animate({
          scrollTop: 0
        }, 'slow')
      })

      $(w).on('scroll._handle_scroll_top', function() {
        if($(this).scrollTop() > $(w).height()) {
          if(! $('body').hasClass('scroll-top-active'))
            $('body').addClass('scroll-top-active')
        }else {
          if($('body').hasClass('scroll-top-active'))
            $('body').removeClass('scroll-top-active')
        }
      })
    }

    // background image lazyload
    this.backgroundImageLazyload = function() {

      $( 'body' ).on({
        '__themeextends_background_image_lazyload.themeextends_lazyload' () {
          $('body').off('.background_image_lazyload').on('mouseover.background_image_lazyload touchstart.background_image_lazyload', '*[data-background-image-lazyload]', function(e) {
            e.preventDefault();
            if($(this).hasClass('_is-loader')) return;
    
            var $thisEl = $(this),
                imageUrl = $thisEl.data('background-image-lazyload');
    
            if(! imageUrl) { $thisEl.remove(); return; }
    
            var ImageLazyLoad = new Image();
            ImageLazyLoad.onload = function() {
              $thisEl
              .addClass('_is-loader')
              .css('background-image', `url(${imageUrl})`);
            }
            ImageLazyLoad.src = imageUrl;
          })
        },
        '__themeextends_image_lazyload_onload.themeextends_lazyload' () {
          $('[data-background-image-lazyload-onload]').each(function() {
            if($(this).hasClass('_is-loader')) return;
    
            var $thisEl = $(this),
                imageUrl = $thisEl.data('background-image-lazyload-onload');
    
            if(! imageUrl) { return; }
    
            var ImageLazyLoad = new Image();
            ImageLazyLoad.onload = function() {
              $thisEl
              .addClass('_is-loader')
              .css('background-image', `url(${imageUrl})`);
    
              if( $thisEl.data('hidden-el-onload-success') ) {
                $thisEl.find( $thisEl.data('hidden-el-onload-success') ).css('opacity', 0);
              }
            }
            ImageLazyLoad.src = imageUrl;
          })
        }
      })

      $('body').trigger( '__themeextends_background_image_lazyload.themeextends_lazyload' );
      $('body').trigger( '__themeextends_image_lazyload_onload.themeextends_lazyload' );
    }

    this.themeExtendsLazyLoad = function() {
      $('img[data-themeextends-lazyload-url]').each(function() {
        var $img = $(this),
            imageUrl = $img.data('themeextends-lazyload-url');

        // var $wrap = $img.parent('[data-themeextends-lazyload-wrap]');

        var _image = new Image();
        _image.onload = function() {
          $img.attr('src', imageUrl);
          $img.removeAttr('srcset');
          $img.removeAttr('width');
          $img.removeAttr('height');
        }
        _image.src = imageUrl;
      })
    }

    this.imageMediumZoom = function() {
      _ThemeZoomingObject.listen('[data-themeextends-mediumzoom]');
    }

    this.themeExtendsSwiper = function() {
      $('[data-themeextends-swiper]').each(function() {
        var $this = $(this),
            opts = $.extend({

            }, $this.data('themeextends-swiper'));

        $this.data('themeextends-swiper-object', new _ThemeSwiper(this, opts));
      })
    }

    this.themeExtendsSwiperCustomControl = function() {
      $('[data-themeextends-swiper-custom-control]').each(function() {
        var $this = $(this),
            MainSlide = $this.find('[data-themeextends-swiper-slide]'),
            NavSlide = $this.find('[data-themeextends-swiper-slide-nav]');

        if(MainSlide.length <= 0) return;

        if(NavSlide.length > 0) {
          var MainControl = MainSlide.data('themeextends-swiper-object');
          var NavControl = NavSlide.data('themeextends-swiper-object');

          MainControl.controller.control = NavControl;
          NavControl.controller.control = MainControl;
        }
      })
    }

    this.FuryGrid = function() {
      $('*[data-theme-furygrid-options]').each(function() {
        var $thisEl = $(this),
            opts = $.extend({
              El        : this,
              Col 			: 4,
			        Space 		: 24,
            }, $thisEl.data('theme-furygrid-options'));

        if($thisEl.data('custom-furygrid-col')) opts.Col = parseInt($thisEl.data('custom-furygrid-col'));
        if($thisEl.data('custom-furygrid-space')) opts.Space = parseInt($thisEl.data('custom-furygrid-space'));

        new _ThemeFuryGrid(opts);
      })
    }

    // Blog filter by cat
    this.blogFilterByCatSelect = function() {
      $('select#select-filter-post-by-category').on('change', function(e) {
        e.preventDefault();
        var directLink = this.value;
        // console.log(directLink);
        window.location = directLink;
      })
    }

    // Custom slick slide
    this.customSlickSlide = function() {
      $('*[data-theme-extends-slick-carousel]').each(function() {
        var $thisEl = $(this),
            options = $thisEl.data('theme-extends-slick-carousel');

        options.nextArrow = '<div class="custom-slick-next"><img src="'+ theme_script_object.images.arrow_next +'" alt="'+ theme_script_object.language.TEXT_NEXT +'"></div>';
        options.prevArrow = '<div class="custom-slick-prev"><img src="'+ theme_script_object.images.arrow_prev +'" alt="'+ theme_script_object.language.TEXT_PREV +'"></div>';

        // add slick slide
        var SlickObject = $thisEl.slick(options);
      })
    }

    // Zoomove
    this.zoomove = function() {
      $('[data-themeextends-zoomove]').ZooMove();
    }

    // Lightgallery
    this.lightGallery = function() {
      $('[data-theme-extends-lightgallery]').each(function() {
        var $this = $(this),
            opts = $this.data('');

        var _opts = $.extend({
          selector: '[data-lightgallery-item]'
        }, opts);

        w.lightGallery(this, _opts);

      })
    }

    // Lightgallery trigger open
    this.lightGalleryTriggerOpen = function() {
      $('body').on('click', '[data-theme-extends-lightgallery-open]', function(e) {
        e.preventDefault();

        var $this = $(this),
            $gallery = $( $this.data('theme-extends-lightgallery-open') );

        // check gallery element exist
        if( $gallery.length <= 0 ) return;

        // trigger click first item
        $gallery.find('[data-lightgallery-item]').first().trigger('click');
      })
    }

    // Delipress widget custom form
    this.DelipressWidgetCustomFormSubmit = function() {
      $('[data-theme-extends-delipress-custom-form]').each(function() {
        var $form = $(this);

        $form.on({
          'on_ajax_load'() {
            $(this).addClass('__form-ajax-load')
          },
          'on_ajax_load_complete'() {
            $(this).removeClass('__form-ajax-load')
            $(this).closest('.delipress-custom-form').addClass('__subscribed-successfully')
            $(this).trigger('on_reset_form');

            // callback on success
            var callback = $form.data('on-subscribed-successfully')
            if( callback ) callback.call(this, $form);
          },
          'on_error'() {
            $(this).removeClass('__form-ajax-load')
            $(this).closest('.delipress-custom-form').addClass('__subscribed-error')
            $(this).trigger('on_reset_form');

            // callback on error
            var callback = $form.data('on-subscribed-error')
            if( callback ) callback.call(this, $form);
          },
          'on_reset_form'() {
            $(this).find('input[type="text"], input[type="email"]').val('');
          },
          'submit'(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $form.trigger('on_ajax_load');

            $.ajax({
              type: 'POST',
              url: theme_script_object.ajax_url,
              data: 'action=jayla_delipress_submit_custom_form_handle&' + data,
              success(res) {
                if(res.success == true) {
                  $form.trigger('on_ajax_load_complete');
                } else {
                  console.log(res);
                  $form.trigger('on_error');
                }
              },
              error(e) {
                console.log(e);
                $form.trigger('on_error');
              }
            })
          }
        })

      })
    }

    this.lightslider = function() {
      $('[data-themesextends-lightslider]').each(function() {
        var $el = $(this),
            opts = $.extend({

            }, $el.data('themesextends-lightslider'))

        var SlideObject = $el.lightSlider(opts);
        $el.data('lightslider-object', SlideObject);
      })
    }

    this.likePost = function() {
      // localStorage.removeItem('themeextends_post_likes_data');

      var get_themeextends_post_likes_data = function() {
        var themeextends_post_likes_data = localStorage.getItem('themeextends_post_likes_data');
        return (themeextends_post_likes_data) ? JSON.parse( themeextends_post_likes_data ) : [];
      }

      var set_themeextends_post_likes_data = function(data) {
        return localStorage.setItem('themeextends_post_likes_data', JSON.stringify(data));
      }

      var push_item_themeextends_post_likes_data = function(pid) {
        var data = get_themeextends_post_likes_data();
        // console.log(data, 'push_item_themeextends_post_likes_data');
        data.push(pid);

        set_themeextends_post_likes_data(data);
      }

      var remove_item_themeextends_post_likes_data = function(pid) {
        var data = get_themeextends_post_likes_data();
        var index = data.indexOf(pid);
        if( index != -1 ){ data.splice( index, 1 ); }

        set_themeextends_post_likes_data(data);
      }

      var init_active_button_likes_post = function() {
        var pdata = get_themeextends_post_likes_data();
        if( pdata.length <= 0 ) return;

        pdata.forEach(function(pid) {
          $('[data-themeextends-button-like-post][data-p-id="' + pid + '"]').addClass('active');
        })
      }
      init_active_button_likes_post();

      $('body').on('click', '[data-themeextends-button-like-post]', function(e) {
        e.preventDefault();
        var $thisEl = $(this);
        var pid = $thisEl.data('p-id');
        var increase = ( $thisEl.hasClass('active') ) ? 0 : 1;

        $thisEl.addClass( '_ajax-handle' );

        $.ajax({
          type: 'POST',
          url: theme_script_object.ajax_url,
          data: { action: 'jayla_post_likes_handle', data: { pid: pid, inc: increase } },
          success (res) {
            $thisEl.removeClass( '_ajax-handle' );
            if(res.success == true) {
              var data = res.data;
              if(data.success) {
                $thisEl.find('.count').html(data.likes);
                if( false == data.inc ) {
                  $thisEl.removeClass('active');
                  remove_item_themeextends_post_likes_data( pid );
                } else {
                  $thisEl.addClass('active');
                  push_item_themeextends_post_likes_data( pid );
                }
              }
            }
          },
          error (e) {
            console.log(e);
          }
        })
      })
    }

    this.playerPlyr = function() {
      var themeExtendsParseVideo = function (url) {
        // - Supported YouTube URL formats:
        //   - http://www.youtube.com/watch?v=My2FRPA3Gf8
        //   - http://youtu.be/My2FRPA3Gf8
        //   - https://youtube.googleapis.com/v/My2FRPA3Gf8
        // - Supported Vimeo URL formats:
        //   - http://vimeo.com/25451551
        //   - http://player.vimeo.com/video/25451551
        // - Also supports relative URLs:
        //   - //player.vimeo.com/video/25451551

        url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

        if (RegExp.$3.indexOf('youtu') > -1) {
            var type = 'youtube';
        } else if (RegExp.$3.indexOf('vimeo') > -1) {
            var type = 'vimeo';
        }

        return {
            type: type,
            id: RegExp.$6
        };
      }

      $('[data-themeextends-player-plyr]').each(function() {
        var $thisEl = $(this);
        var opts = $.extend({
          'type' : 'video',
          'video_type' : 'external_video', // external_video or html5_video
          'video_link' : '',
          'video_poster' : '',
        }, $thisEl.data('themeextends-player-plyr'))

        if( 'external_video' == opts.video_type ) {
          var video_data = themeExtendsParseVideo(opts.video_link);
          if( video_data && video_data.id && video_data.type ) {

            $thisEl.attr('data-plyr-provider', video_data.type);
            $thisEl.attr('data-plyr-embed-id', video_data.id);

            var playerObject = new _ThemePlyr(this);
            if( opts.video_poster ) playerObject.poster = opts.video_poster;

            $thisEl.data('player-plyr-object', playerObject);
          }
        } else {
          var playerObject = new _ThemePlyr(this);
          if( opts.video_poster ) playerObject.poster = opts.video_poster;

          $thisEl.data('player-plyr-object', playerObject);
        }
      })
    }

    this.smoothScrollbar = function() {
      $('[data-themeextends-smooth-scrollbar]').each( function() {
        var opts = $.extend( {}, $(this).data( 'themeextends-smooth-scrollbar' ) );
        var ss_obj = _ThemeScrollbar.init( this, opts );

        $(this).addClass('themeextends-apply-smooth-scrollbar-js').data( 'themeextends-ss-obj', ss_obj );
      } )

      /* add element smooth scrollbar fixed */
      $('.jayla-archive-filter-tool-bar.__layout-default .widget .__widget-inner > *:not(.widget-title)').each(function() {
        var ss_obj = _ThemeScrollbar.init( this, {
          alwaysShowTracks: true,
          continuousScrolling: false,
        } );

        $(this).addClass('themeextends-apply-smooth-scrollbar-js').data( 'themeextends-ss-obj', ss_obj );
      })
    }

    this.ThemeAccordionCustomUi = function() {
      var $elem = $('.themeextends-accordion-ui');
      
      $('body').on('click.__theme_accordion_custom_ui', '.themeextends-accordion-ui .themeextends-accordion-ui-item .themeextends-accordion-ui-title', function( e ) {
        e.preventDefault();
        var $acco_item_wrap = $(this).parent();
        var $acco_item_title = $(this);

        if( $acco_item_wrap.hasClass( '__is-active' ) ) {
          $acco_item_wrap.find('.themeextends-accordion-ui-container').slideUp('slow', function() {
            $acco_item_wrap.removeClass( '__is-active' );
          })
        } else {
          $acco_item_wrap.parent().find('.__is-active').each(function() {
            var $this_item_is_active = $(this);
            $this_item_is_active.find('.themeextends-accordion-ui-container').slideUp('slow', function() {
              $this_item_is_active.removeClass( '__is-active' );
            })
          })

          $acco_item_wrap.find('.themeextends-accordion-ui-container').slideDown('slow', function() {
            $acco_item_wrap.addClass( '__is-active' );
          })
        }
      })
    }

    return this;
  }

  w.themeScriptApi = w.themeScriptApi || new themeScriptApi();

  /* load designer google fonts */
  if(theme_script_object.designer_google_font_families) {
    w.themeScriptApi.loadGoogleFonts(theme_script_object.designer_google_font_families);
  }
  _loadWebfontScript();

  /* fix vc content on product descriptions */
  var fix_vc_content_on_product_descriptions = function() {
    $('body').on('click', '#tab-title-description a', function(e) {
      setTimeout(function() {
        $(window).trigger('resize');
      }, 100)
    })
  }
  fix_vc_content_on_product_descriptions();

  /* DOM ready */
  $(function() {
    w.themeScriptApi.loadEmojiScript();
    w.themeScriptApi.ScrollTop();
    w.themeScriptApi.FuryGrid();
    w.themeScriptApi.blogFilterByCatSelect();
    w.themeScriptApi.customSlickSlide();
    w.themeScriptApi.backgroundImageLazyload();
    w.themeScriptApi.DelipressWidgetCustomFormSubmit();
    w.themeScriptApi.likePost();
    w.themeScriptApi.playerPlyr();

    /* scrollreveal */
    // w._ThemeScrollReveal = _ThemeScrollReveal;
    w.sr = _ThemeScrollReveal();
    if( $('[data-theme-extends-scrollreveal]').length ) {
      sr.reveal('[data-theme-extends-scrollreveal]');
    }
  })

  /* Browser load complete */
  $(w).load(function() {
    /* header builder */
    w.themeScriptApi.headerHandleScript($('.header-builder-wrap'));

    /* load google font currnet page */
    w.themeScriptApi.loadGoogleFontsCurrentPage();

    /* product qty button up/down handle */
    w.themeScriptApi.productQtyButtonHandle();

    /* header strip */
    w.themeScriptApi.headerStripHandle();

    /* Lightslider */
    w.themeScriptApi.lightslider();

    /* lazy load */
    w.themeScriptApi.themeExtendsLazyLoad();

    /* lightgallery & lightGallery trigger open */
    w.themeScriptApi.lightGallery();
    w.themeScriptApi.lightGalleryTriggerOpen();

    /* swiper */
    w.themeScriptApi.themeExtendsSwiper();

    /* swiper custom control */
    w.themeScriptApi.themeExtendsSwiperCustomControl();

    /* image medium zoom */
    w.themeScriptApi.imageMediumZoom();

    /* Zoomove */
    w.themeScriptApi.zoomove();

    /* smooth scrollbar  */
    w.themeScriptApi.smoothScrollbar();

    /* theme custom accordion ui */
    w.themeScriptApi.ThemeAccordionCustomUi();

    var woo_product_review_forcus = function() {
      $('body').on( 'click', '.__woo-product-gallery-custom-layout-product-entry-accordion .woocommerce-review-link', function( e ) {
        e.preventDefault();

        var $review_acco_item = $('#tab-title-reviews').parent();
        if( ! $review_acco_item.hasClass( '__is-active' ) ) {
          $review_acco_item.find('#tab-title-reviews').trigger( 'click' );
        }
        
        $('body, html').animate({
          scrollTop: $('#tab-title-reviews').offset().top - 50,
        }, 'slow')
      } )
    }
    woo_product_review_forcus();

    /* search box */
    var searchBox = function() {
      if($('#theme-extends-widget-search-form').length <= 0) return;

      new _ThemeAnimBox({
        el: $('#theme-extends-widget-search-form'),
        onInit (ab_object) {

          /* trigger event search on type */
          ab_object.$el.on({
            '_loadData.search-form' (e, data, callback) {
              $.ajax({
                type: 'POST',
                url: theme_script_object.ajax_url,
                data: {action: 'jayla_search_form_ajax_load_data', s: data},
                success (result) {
                  if(callback) callback.call(this, result);
                },
                error (e) { console.log(e); }
              })
            },
            '_updateResult.search-form' (e, content) {
              // .result-content
              $(this).find('.result-content').empty().append(content);
              if(!content) return;

              /* anim */
              _ThemeAnime({
                targets: ab_object.$el[0].querySelectorAll('.result-item'),
                opacity: 1,
                marginLeft: 0,
                easing: 'easeInOutExpo',
                duration: function(el, i, l) {
                  return 500 + (i * 100);
                }
              });
            },
            '_searchHandle.search-form' (e) {

              var $thisEl = $(this);
              $(this).find('input.search-field').on('input', function(e) {
                if(ab_object.search_ajax && ab_object.search_ajax == 'no') return;

                var $input = $(this),
                    s = $input.val();

                if(! s) return;

                $thisEl.trigger('_loadData.search-form', [s, function(result) {
                  if(result.s != $input.val()) return;
                  $thisEl.trigger('_updateResult.search-form', result.content);
                }])
              })
            },
          }).trigger('_searchHandle.search-form');

          /* click handle */
          $('body').on('click touchend', '[data-theme-open-widget-search-form]', function(e) {
            e.preventDefault();
            var searchAjax = $(this).data('search-form-ajax'),
                pos = $(this).data('search-form-pos'),
                left = 0;

            /* set 'search_ajax' */
            ab_object.search_ajax = searchAjax;

            if(pos == 'left') {
              left = $(this).offset().left + $(this).innerWidth() - 500;
            } else if( pos == 'right') {
              left = $(this).offset().left;
            }

            /* update position */
            var pos = { left: left, top: $(this).offset().top + $(this).innerHeight() + 20 };
            ab_object.updatePosition(pos);

            ab_object.$el.data('display-by-event', e.type);
            // console.log( ab_object.$el.data('display-by-event') );

            /* toggle animBox */
            ab_object.$el.trigger('_toggle');
          })
        }
      })
    }
    searchBox();

    /* Woo miniCart */
    var wooMiniCartBox = function() {
      if($('#theme-extends-widget-mini-cart').length <= 0) return;

      new _ThemeAnimBox({
        el: $('#theme-extends-widget-mini-cart'),
        onInit (ab_object) {

          $('body').on('click', '[data-theme-open-widget-cart-form]', function(e) {
            e.preventDefault();
            var pos = $(this).data('cart-pos'),
                left = 0;

            if(pos == 'left') {
              left = $(this).offset().left + $(this).innerWidth() - 500;
            } else if( pos == 'right') {
              left = $(this).offset().left;
            }

            /* update position */
            var pos = {
              left: left,
              top: $(this).offset().top + $(this).innerHeight() + 20,
            };
            ab_object.updatePosition(pos);

            /* toggle animBox */
            ab_object.$el.trigger('_toggle', [e]);
          })
        }
      });
    }
    wooMiniCartBox();

    var wooCustomProductSearchWidget = function() {
      $('[data-woo-widget-custom-product-search-form]').each(function(e) {
        var $formEl = $(this),
            $inputSearch = $formEl.find('input.product-search-field'),
            $iconSearch = $formEl.parents('.theme-extends-widget-product-custom-search').find('._icon-search svg'),
            $btnClose = $formEl.parents('.theme-extends-widget-product-custom-search').find('.__close'),
            $filterProduct = $formEl.find('.theme-extends-filter-product-by-cat');

          $formEl.on({
            '__open_search' (e) {
                $('body').addClass( 'theme-extends-product-custom-search-is-active' );
            },
            '__close_search' (e) {
                $('body').removeClass( 'theme-extends-product-custom-search-is-active' );
            },
            '__focus_search_field.ajax_search' (e) {
                setTimeout( () => {
                    $(this).find('input[type="search"]').focus();
                }, 300 )
            },
            '__on_ajax_load'(e, type) {
              if(type == true) {
                $(this).addClass('__on-ajax-loading-search');
              } else {
                $(this).removeClass('__on-ajax-loading-search');
              }
            },
            '__on_search'(e, s) {
              var $_form = $(this);
              var data = $(this).serialize();

              $_form.trigger('__on_ajax_load', [true]);

              $.ajax({
                type: 'POST',
                url: theme_script_object.ajax_url,
                data: 'action=jayla_woo_widget_product_search_func&' + data,
                success(result) {
                  if(result.success == true && result.data.s == $inputSearch.val()) {
                    $_form.trigger('__refesh_resurl', [result.data]);
                    $_form.trigger('__on_ajax_load', [false]);
                  }
                },
                error(e) {
                  $_form.trigger('__on_ajax_load', [false]);
                  console.log(e);
                }
              })
            },
            '__refesh_resurl'(e, data) {
              $(this).find('.theme-extends-widget-product-search-result-container .p-result-items').html(data.html_content);
              $(this).find('.theme-extends-widget-product-search-result-container .suggestions-short-desc').html(data.total_posts);
            }
          })
          $iconSearch.on('click',function(){
            $formEl.trigger( '__open_search' );
          })
          $btnClose.on('click',function(){
            $formEl.trigger( '__close_search' );
          })
          $inputSearch.on({
            'focusin'(e) {
              $formEl.addClass('__active-form');
            },
            'focusout'() {
              $formEl.removeClass('__active-form');
            },

          })

          var typeSearchTimeOut;
          $inputSearch.on('input', function(e) {
            clearTimeout(typeSearchTimeOut);
            var s = this.value;
            if(s.length <= 0) return;

            typeSearchTimeOut = setTimeout(function() {
              $formEl.trigger('__on_search', [s]);
            }, 400)
          })

          if($filterProduct.length > 0) {
            $filterProduct.on({
              'set_data'(e, slug, name) {

                $filterProduct.find('.__cat_label_display').html(name);
                $(this).find('input[name="term"]').val(slug);
                // $inputSearch.focus();
              }
            })

            $filterProduct.on('click', '.__cat_label_display', function(e) {
              e.preventDefault();
              e.stopPropagation();
              $filterProduct.toggleClass('__is-open');
            })

            $('body').on('click', function() {
              $('.theme-extends-filter-product-by-cat.__is-open').removeClass('__is-open');
            })

            $filterProduct.on('click', '[data-pcat-slug]', function(e) {
              e.preventDefault();
              $filterProduct.trigger('set_data', [
                $(this).data('pcat-slug'),
                $(this).data('pcat-name')
              ]);

              $filterProduct.removeClass('__is-open');
            })
          }
      })
    }
    wooCustomProductSearchWidget();

    var wooToggleDataTabs = function() {
      $('body').on({
        '__themeextends_woo_toogle_data_tabs' (e, st) {
          var $tabs = $('.woocommerce-tabs');

          if( st == 'show' ) {
            $tabs.stop(true, true).slideDown('slow');
          } else {
            $tabs.stop(true, true).slideUp('slow');
          }
        },
        '__themeextends_woo_move_review_tab' (e) {
          $(this).trigger('__themeextends_woo_toogle_data_tabs', ['show']);
        }
      })

      $('body').on('click', 'a#product-toogle-data-tabs-button', function(e) {
        e.preventDefault();
        var $this = $(this);

        $this.toggleClass('__is-show');
        if($this.hasClass('__is-show')) { $('body').trigger('__themeextends_woo_toogle_data_tabs', ['show']); }
        else { $('body').trigger('__themeextends_woo_toogle_data_tabs', ['hide']); }
      })

      if($('body').hasClass('woo-product-custom-single__layout-product-sticky-content')) {
        $('body').on('click', 'a.woocommerce-review-link', function(e) {
          $('body').trigger('__themeextends_woo_move_review_tab');
          $('a#product-toogle-data-tabs-button').addClass('__is-show');
        })

        if(window.location.hash != '#reviews') return;
        $('body').trigger('__themeextends_woo_move_review_tab');
        $('a#product-toogle-data-tabs-button').addClass('__is-show');
      }
    }
    wooToggleDataTabs();

    var wooCustomGalleryTriggerHandle = function() {
      if( $('[data-woo-product-gallery-trigger]').length <= 0 ) return;

      $('[data-woo-product-gallery-trigger]').on({
        '__g-active-item-by-image-id' (e, image_id, product_variations) {
          var $mainSlide    = $(this).find('[data-themeextends-swiper-slide]'),
              $navSlide     = $(this).find('[data-themeextends-swiper-slide-nav]'),
              SwiperObj     = $mainSlide.data('themeextends-swiper-object'),
              SwiperObjNav  = $navSlide.data('themeextends-swiper-object');

          if(! image_id) { SwiperObj.slideTo(0); return; }

          var $nextImage = function() { return $mainSlide.find(`[data-img-id="${image_id}"]`) };

          if($nextImage().length <= 0) {
            $(this).trigger('__g-add-image-item', [image_id, product_variations, SwiperObj, SwiperObjNav]);
          }

          SwiperObj.slideTo($nextImage().index());
        },
        '__g-add-image-item' (e, image_id, product_variations, swiper_obj, swiper_obj_nav) {
          var currentVar = product_variations.filter(function(item) {
            return item.image_id == image_id;
          })[0];

          var _image = currentVar.image;
          var $newItem = $(`<div class="product-g-item swiper-slide" data-themeextends-zoomove="true" data-zoo-image="${_image.full_src}" data-img-id="${image_id}" data-lightgallery-item data-src="${_image.full_src}"><img src="${_image.full_src}" alt="${_image.alt}"></div>`)

          swiper_obj.appendSlide($newItem);
          swiper_obj_nav.appendSlide(`<div class="product-g-item swiper-slide" data-img-id="${image_id}"><img src="${_image.full_src}" alt="${_image.alt}"></div>`);

          // apply zoomove
          $newItem.ZooMove();

          // apply lightgallery
          var $lightGallery = $(this).find('[data-theme-extends-lightgallery]');
          w.lgData[$lightGallery.attr('lg-uid')].destroy(true);
          lightGallery($lightGallery[0], {
            selector: '[data-lightgallery-item]',
          });
        },
      })
    }
    wooCustomGalleryTriggerHandle();

    var wooCustomGalleryTriggerHandle2 = function() {
      if( $('[data-woo-product-gallery-trigger2]').length <= 0 ) return;
      var cache_gallery = {};

      $('[data-woo-product-gallery-trigger2]').on({
        '__g-ajax-load-effect' (e, st) {
          var $thisEl = $(this);
          var $lSGallery = $thisEl.find('.lSGallery');
          if( $lSGallery.length <= 0 ) return;

          if( true == st ) {
            $lSGallery.addClass('__ajax-is-loading')
          } else {
            $lSGallery.removeClass('__ajax-is-loading')
          }
        },
        '__g-active-item-by-image-id' (e, image_id, product_variations) {
          var $thisEl = $(this);
          var $lightSlide = $thisEl.find('[data-themesextends-lightslider]');

          if( $lightSlide.length <= 0 ) return;
          var lightSlideObject = $lightSlide.data('lightslider-object');

          if( ! cache_gallery.default ) {
            cache_gallery.default = {
              medium_src: $thisEl.find('.product-g-item').first().data('thumb'),
              large_src: $thisEl.find('.product-g-item').first().find('img').data('themeextends-lazyload-url'),
            }
          }

          if(! image_id) {
            $thisEl.trigger( '__g-load-image', cache_gallery.default );
            lightSlideObject.goToSlide(0);
            return;
          }

          $thisEl.triggerHandler( '__g-get-image', image_id);
          lightSlideObject.goToSlide(0);
        },
        '__g-add-image-item' (e, image_id, product_variations, swiper_obj, swiper_obj_nav) {

        },
        '__g-get-image' (e, image_id) {
          var self = this;
          var $thisEl = $(this);

          if( cache_gallery[image_id] ) {
            $thisEl.trigger( '__g-load-image', cache_gallery[image_id] );
            return;
          }

          $thisEl.trigger('__g-ajax-load-effect', true);
          $.ajax({
            type: 'POST',
            url: theme_script_object.ajax_url,
            data: { action: 'jayla_woo_ajax_get_image_by_id', att_id: image_id },
            success(res) {
              $thisEl.trigger('__g-ajax-load-effect', false);

              if( true == res.success ) {
                var data = res.data;
                cache_gallery[data.id] = data;
                $thisEl.trigger( '__g-load-image', data );
              }
            },
            error(err) {
              console.log(err);
            }
          })
        },
        '__g-load-image' (e, image_data) {
          var $thisEl = $(this);
          var $lightSlide = $thisEl.find('[data-themesextends-lightslider]');
          var $pg_item = $thisEl.find('.product-g-item').first();

          $pg_item.children('img').attr('src', image_data.large_src);
          if( $pg_item.find('.zoo-img').length > 0 ) {
            $pg_item.find('.zoo-img').css( 'background-image', `url(${image_data.large_src})` );
          }

          if( $thisEl.find('.lSGallery').length > 0 ) {
            $pg_item.attr( 'data-thumb', image_data.medium_src );
            $thisEl.find('.lSGallery > li').first().find('img').attr('src', image_data.medium_src);
          }
        },
      })
    }
    wooCustomGalleryTriggerHandle2()

    var wooUpdateGalleryProductVariations = function() {
      var $_productVariationsForm = $('form.variations_form'),
          $_productCustomGallery = $('[data-woo-product-gallery-trigger]'),
          $_productCustomGallery2 = $('[data-woo-product-gallery-trigger2]');

      if( $_productVariationsForm.length <= 0 ) return;

      var isTimeout = false;
      $_productVariationsForm.on('woocommerce_update_variation_values.product-gallery-update', function(evt) {
        var $form = $(this);
        clearTimeout(isTimeout);

        isTimeout = setTimeout(function() {
          var currentImage = $form.attr('current-image'),
              productVariations = $form.data('product_variations');

          if( $_productCustomGallery.length > 0 )
            $_productCustomGallery.trigger('__g-active-item-by-image-id', [currentImage, productVariations]);

          if( $_productCustomGallery2.length > 0 )
            $_productCustomGallery2.trigger('__g-active-item-by-image-id', [currentImage, productVariations]);
        }, 100)
      }).trigger('woocommerce_update_variation_values.product-gallery-update');
    }
    wooUpdateGalleryProductVariations();

    var wooFixSwatchTagASelect = function() {
      $('body').on('click', '.swatch-wrapper a', function(e) {
        e.preventDefault();
      })
    }
    wooFixSwatchTagASelect();

    var wooStickyContentByLayout = function() {
      var classes_allow = ['woo-product-custom-single__layout-product-sticky-content', 'woo-product-custom-single__layout-product-gallery-grid'];

      $.each(classes_allow, function(index, classesName) {
        if( $('body').hasClass(classesName) ) {
          var StickySidebarObject = new w.StickySidebar('#themeextends-woo-product-inner-container .entry-summary', {
            topSpacing: 60,
            bottomSpacing: 60,
            containerSelector: '#themeextends-woo-product-inner-container',
            innerWrapperSelector: '.product-entry-summary__inner',
            minWidth: 768,
          });

          _themeGlobalVariable.StickySidebarObject.push( StickySidebarObject )

          return false;
        }
      })
    }
    wooStickyContentByLayout();

    var updateAllElementAddStickySidebar = function() {
      if( _themeGlobalVariable.StickySidebarObject.length <= 0 ) return;
      _themeGlobalVariable.StickySidebarObject.forEach(function(obj) {
        obj.updateSticky();
      })
    }

    var triggerResizeHandleFixAnyIssueResizeBrowser = function() {
      var triggerResizeTimeOut = null;
      $(w).on('resize', function(e, isTriggerResize) {
        clearTimeout( triggerResizeTimeOut );

        triggerResizeTimeOut = setTimeout(function() {
          if( isTriggerResize == true ) return;

          $(w).trigger('resize', [true]);
          updateAllElementAddStickySidebar();

        }, 500)
      })
    }
    triggerResizeHandleFixAnyIssueResizeBrowser();


    /* header menu accordion */
    var headerElemSelectorMenuAccordion = [
      '.theme-extends-layout-nav-left header.site-header .widget-element-primary-navigation',
      '.theme-extends-layout-nav-right header.site-header .widget-element-primary-navigation',
      '.widget-element-handheld-navigation .menu-container',
      '.widget-element-menu-offcanvas .menu-container',
      '.theme-extends-widget-custom-menu .menu-style-vertical .widget-custom-menu',
    ];
    headerElemSelectorMenuAccordion.forEach(function(selector) {
      w.themeScriptApi.menuAccordion($(selector));
    })

    /* header nav left, right toggle on mobile */
    w.themeScriptApi.clickToggleClass(
      $('.theme-extends-header-toggle-btn'),
      $('.theme-extends-header-toggle-btn').closest('.site-header'),
      'theme-extends-header-is-show',
      function($controlEl, $targetEl) {
        if($targetEl.hasClass('theme-extends-header-is-show')) $controlEl.find('.hamburger').addClass('is-active');
        else $controlEl.find('.hamburger').removeClass('is-active');
      }
    );

    /* menu mobile */
    w.themeScriptApi.clickToggleClass(
      $('[data-theme-extends-mobi-menu-trigger], [data-theme-extends-mobi-menu-trigger-close]'),
      $('body'),
      'theme-extends-menu-mobile-open',
      function($controlEl, $targetEl) {
        if($targetEl.hasClass('theme-extends-menu-mobile-open')) $controlEl.addClass('is-active');
        else $controlEl.removeClass('is-active');
      }
    );

    /* menu offcanvas */
    w.themeScriptApi.clickToggleClass(
      $('[data-theme-extends-menu-offcanvas-trigger], [data-theme-extends-menu-offcanvas-trigger-close]'),
      $('body'),
      'theme-extends-menu-offcanvas-open',
      function($controlEl, $targetEl) {
        if($targetEl.hasClass('theme-extends-menu-offcanvas-open')) $controlEl.addClass('is-active');
        else $controlEl.removeClass('is-active');
      }
    );

    // attaches to DOMLoadContent and does anything for you
    // ElementQueries.listen();

    // or if you want to trigger it yourself:
    // 'init' parses all available CSS and attach ResizeSensor to those elements which
    // have rules attached (make sure this is called after 'load' event, because
    // CSS files are not ready when domReady is fired.
    // Use this function if you have dynamically created HTMLElements
    // (through ajax calls or something)
    // ElementQueries.init();

    /* boostrap enable tooltip */
    $('[data-toggle="tooltip"]').tooltip();

    /* mouse tip */
    var MouseTip = new _ThemeMouseTip();
    MouseTip.run();

    // call after 0.1 sec
    setTimeout(function() {
      /* sticky element */
      w.themeScriptApi.sticky_element();

      /* nav slide (responsive) */
      w.themeScriptApi.navSlide();

      /* trigger resize */
      $(w).trigger('resize');
    }, 100);

    // fix visual composer parallax issue
    // trigger event resize after 0.5 sec
    setTimeout(function() {
      $( '[data-vc-parallax]' ).each(function() {
        if( w.vcParallaxSkroll ) {
          w.vcParallaxSkroll.refresh( $(this) ); 
        }
      })
    }, 2000)

    /* custom animate element */
    var $animateEl = $('[data-animate]');
    $animateEl.each(function () {
        var $el = $(this),
            $name = $el.data('animate'),
            $duration = $el.data('duration'),
            $delay = $el.data('delay');

        $duration = typeof $duration === 'undefined' ? '0.6' : $duration ;
        $delay = typeof $delay === 'undefined' ? '0' : $delay ;

        $el.waypoint(function () {
            $el.addClass('animated ' + $name)
               .css({
                    'animation-duration': $duration + 's',
                    'animation-delay': $delay + 's'
               });
        }, {offset: '100%'});
    });
  })
})(window, document, jQuery)
