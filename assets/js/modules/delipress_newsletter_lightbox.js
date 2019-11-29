!(function(w, $) {
    'use strict';

    var ThemeExtends_DelipressNewsletterLightbox = function(el, opts) {
        this.Element = el;
        this.opts = this._options(opts);
        this._addTriggerEvent();

        var self = this;

        this.Element.on('click', '.__newsletter-lightbox-close', function(e) {
            e.preventDefault();
            self.Element.trigger('__close');
        })

        this.Element.find('[data-theme-extends-delipress-custom-form]').data('on-subscribed-successfully', this.opts.on_subscribed_success)
        this.Element.find('[data-theme-extends-delipress-custom-form]').data('on-subscribed-error', this.opts.on_subscribed_error)

        return this;
    } 

    ThemeExtends_DelipressNewsletterLightbox.prototype._options = function(default_opts) {
        return $.extend({
            on_close: function() { return; },
            on_open: function() { return; },
            on_subscribed_success: function() { return; },
            on_subscribed_error: function() { return; },
        }, default_opts);
    }

    ThemeExtends_DelipressNewsletterLightbox.prototype._addTriggerEvent = function() {
        var self = this;
        
        this.Element.on({
            '__open'(e) {
                $('body').addClass('delipress-newsletter-lightbox__active');
                self.opts.on_open.call(self);
            },
            '__close'(e) {
                $('body').removeClass('delipress-newsletter-lightbox__active');
                self.opts.on_close.call(self);
            }
        })
    }
    
    /**
     * Browser load complete 
     */
    $(w).load(function() {
        var DelipressNewsletterElement = $('#delipress-newsletter-lightbox-element');
        var DelipressNewsletterElement_Open = $('#delipress-newsletter-lightbox-element__open');
        
        var DelipressNewsletterElement_DisplayFunc = function(DelipressNewsletter_Object, data) {
            var DelipressNewsletter_ClientEvent = localStorage.getItem("DelipressNewsletter_ClientEvent");

            var actions = {
                after_how_many_seconds() {
                    setTimeout(function() {
                        DelipressNewsletter_Object.Element.trigger('__open')
                    }, parseInt(data.AfterSecondsToShow) * 1000)
                },
                scroll_down() {
                    console.log(data.ShowBy, data);
                }
            }

            if( DelipressNewsletter_ClientEvent == 'is_close' ) return;
            actions[data.ShowBy].call();
        }

        if( DelipressNewsletterElement.length > 0 ) {
            var DelipressNewsletter_ShowBy = DelipressNewsletterElement.data('dnl-show-by');
            var DelipressNewsletter_AfterSecondsToShow = DelipressNewsletterElement.data('dnl-after-seconds-to-show');
            var DelipressNewsletter_AfterScrolldownToShow = DelipressNewsletterElement.data('dnl-after-scrolldown-to-show');

            var NewletterLightbox_obj = new ThemeExtends_DelipressNewsletterLightbox( DelipressNewsletterElement, {
                on_close() {
                    localStorage.setItem("DelipressNewsletter_ClientEvent", 'is_close');
                },
                on_open() {
                    // localStorage.setItem("DelipressNewsletter_ClientEvent", 'is_open');
                },
                on_subscribed_success() {
                    setTimeout(function() {
                        NewletterLightbox_obj.Element.trigger('__close')
                    }, 1500)
                },
                on_subscribed_error() {
                    setTimeout(function() {
                        NewletterLightbox_obj.Element.trigger('__close')
                    }, 1500)
                }
            } )

            DelipressNewsletterElement_DisplayFunc(NewletterLightbox_obj, {
                ShowBy: DelipressNewsletter_ShowBy,
                AfterSecondsToShow: DelipressNewsletter_AfterSecondsToShow,
                AfterScrolldownToShow: DelipressNewsletter_AfterScrolldownToShow
            });
           
            if( DelipressNewsletterElement_Open.length > 0 ) {
                DelipressNewsletterElement_Open.on('click', function(e) {
                    e.preventDefault();
                    NewletterLightbox_obj.Element.trigger('__open')
                })
            }
        }
    })
})(window, jQuery)

module.exports = {}