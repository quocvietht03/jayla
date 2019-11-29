/**
 * @package FuryGrid v1.0.0
 * Copyright 2018 Bearsthemes
 */
 
/* 
 * Bridget makes jQuery widgets
 */



(function(root, factory) {
    module.exports = factory(root.jQuery, require('isotope-layout'));
})(window || this, function($, Isotope) {
    'use strict';
    
    // -------------------------- helpers -------------------------- //
    
    const CreateRandomKey = function() {
        return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 9);
    }

    /**
     * 
     * @param {callback} func 
     * @param {int} wait 
     * @param {*} immediate 
     */
    const DebounceResize = function(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    /**
     * 
     * @param {array} array 
     * @param {int} num 
     */
    const ArrayClosest = function(array, num){
        var i=0;
        var minDiff=1000;
        var ans;
        for(i in array){
            var m = Math.abs(num-array[i]);
            if(m < minDiff){ 
                minDiff = m; 
                ans = array[i]; 
            }
        }
        return ans;
    }

    /**
     * 
     * @param {array} array 
     */
    const ArrayMax = function(array) {
        return Math.max.apply(Math, array);
    }

    // -------------------------- Fury Grid -------------------------- //

    const FuryGrid = function(opts) {
        // Set options
        const Options = this._options(opts);
        const $el = $(Options.El);
        const RandClassName = '__furygrid-element-' + CreateRandomKey();

        // create style & append style on <head>
        const $style = $('<style>');
        $('head').append($style);

        // Add class - ['class selector js', 'auto class render', 'custom class']
        $el.addClass(['__furygrid-element-js', RandClassName, Options.CustomClass].join(' '));

        // Get
        this.GetOptions = function() { return Options; }
        this.GetStyle = function() { return $style; }
        this.GetElement = function() { return $el; }
        this.GetElementClassName = function() { return RandClassName; }

        // render style
        this._renderStyle();

        // isotope layout
        const IsotopeGrid = this._isotope();
        this.GetIsotopeGrid = function() { return IsotopeGrid; }

        // trigger event
        this._triggerEvent();

        // window resize
        $(window)
        .off('.furygrid_resize')
        .on('resize.furygrid_resize', function(e) {
            $('.__furygrid-element-js').trigger('_responsive.furygrid', [this.innerWidth]);
        })

        // return self
        return this;
    }

    /**
     * @since 1.0.0
     * @param {object} opts 
     */
    FuryGrid.prototype._options = function(opts) {
        return $.extend({
            El              : '#furygrid-element',
            ItemSelector 	: '.furygrid-item',
			ColumnWidth 	: '.furygrid-sizer',
			Gutter 			: '.furygrid-gutter-sizer',
			Col 			: 4,
			Space 			: 24,
            PercentPosition	: false,
            CustomClass     : '',
            Responsive      : {
                1024: {
                    Col: 3,
                    Space: 24,
                },
                780: {
                    Col: 2,
                    Space: 24,
                },
                480: {
                    Col: 1,
                    Space: 24,
                }
            }
        }, opts)
    }

    FuryGrid.prototype._clearStyle = function() {
        this.GetStyle().empty();
        return this;
    }

    FuryGrid.prototype._renderStyle = function() {
        const $style                    = this.GetStyle();

        const Options                   = this.GetOptions();
        const ClassName                 = this.GetElementClassName();
        const Space                     = Options.Space;
        const ItemSelector              = Options.ItemSelector;
        const ColumnWidth               = Options.ColumnWidth;
        const Col                       = Options.Col;
        const Gutter                    = Options.Gutter;

        var css = `
.${ClassName} { margin-left: -${Space}px; width: calc(100% + ${Space}px); transition-property: height, width; } 
.${ClassName} ${ItemSelector}, 
.${ClassName} ${ColumnWidth} { width: calc(100% / ${Col}); } 
.${ClassName} ${Gutter} { width: 0; } 
.${ClassName} ${ItemSelector} { float: left; box-sizing: border-box; padding-left: ${Space}px; padding-bottom: ${Space}px; } `;
        
        // gird size item
		for(var i = 1; i <= Col; i++) {
			var _width = (100 / Col) * i;
			css += `.${ClassName} ${ItemSelector}.furygrid-item--width-${i} { width: ${_width}% } `;
        }

        // responsive
        
        $style.html(css);
    }

    /** 
     * @since 1.0.0
     */
    FuryGrid.prototype._isotope = function() {
        return new Isotope(
            this.GetOptions().El,
            {
                // options...
                itemSelector: this.GetOptions().ItemSelector,
                percentPosition: this.GetOptions().PercentPosition,
                masonry: {
                    columnWidth: this.GetOptions().ColumnWidth,
                    gutter: this.GetOptions().Gutter,
                }
            }
        );
    }

    FuryGrid.prototype._triggerEvent = function() {
        const self = this;
        const $el = this.GetElement();
        const Options = self.GetOptions();
        const Responsive = Options.Responsive;

        const OldParams = {
            Col: Options.Col,
            Space: Options.Space
        };

        $el.on({
            '_refresh.furygrid' (e, opts) {
                if( opts ) {
					self.opts = $.extend(self.GetOptions(), opts);
					self._clearStyle()._renderStyle();
                }
                
                self.GetIsotopeGrid().layout();
            },
            '_responsive.furygrid' (e, WindowWidth) {
                const Breakpoint = ArrayClosest(Object.keys(Responsive), WindowWidth);
                let NewOpts = (ArrayMax(Object.keys(Responsive)) < WindowWidth) ? OldParams : Responsive[Breakpoint];

                const ResponsiveFn = DebounceResize(function() {
                    $el.trigger('_refresh.furygrid', [NewOpts])
                }, 250)

                ResponsiveFn();
            }
        })
    }

    return FuryGrid;
})