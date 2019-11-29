/**
 * Designer helpers
 */
var helpers = require('./helpers.js');
$ = jQuery.noConflict();

var font_family_type_handle = {
  'font_family' (data) {
    return `font-family: "${data}";`;
  },
  'font_size' (data) {
    return `font-size: ${data};`;
  },
  'fill_color' (data) {
    return `fill: ${data};`;
  },
  'font_style' (data) {
    if(data.length <= 0) return;
    var output = [];

    data.forEach(function(item) {
      switch (item) {
        case 'bold': output.push( 'font-weight: bold;' ); break;
        case 'italic': output.push( 'font-style: italic;' ); break;
        case 'underline': output.push( 'text-decoration: underline;' ); break;
        case 'strikethrough': output.push( 'text-decoration: line-through;' ); break;
      }
    })

    return output.join('');
  },
  'font_variant' (data) {
    var weight = (data == 'regular') ? 'normal' : parseInt(data);
    return `font-weight: ${weight};`;
  },
  'letter_spacing' (data) {
    return `letter-spacing: ${data};`;
  },
  'line_height' (data) {
    return `line-height: ${data};`;
  },
  'text_color' (data) {
    return `color: ${data};`;
  }
}

var design_group_type_handle = {
  'size' (properties) {
    var output = '';

    $.each(properties, function(name, value) {
      if(value) output += `${name}: ${value};`;
    })

    return output;
  },
  'space' (properties) {
    var output = '';

    $.each(properties, function(name, value) {
      if(value) output += `${name}: ${value};`;
    })

    return output;
  },
  'typography' (properties) {
    var output = [];
    var typography = properties.typography;

    $.each(typography, function(key, data) {
      if(data && font_family_type_handle[key]) output.push( font_family_type_handle[key](data) );
    })

    return output.join('');
  },
  'border' (properties) {
    var output = '';

    $.each(properties, function(name, value) {
      if(value) output += `${name}: ${value};`;
    })

    return output;
  },
  'position' (properties) {
    var output = '';

    $.each(properties, function(name, value) {
      if(value) output += `${name}: ${value};`;
    })

    return output;
  },
  'background' (properties) {
    var output = '';
    $.each(properties, function(name, value) {
      if(value) {
        if('background-image' == name)
          output += `${name}: url(${value});`;
        else
          output += `${name}: ${value};`;
      }
    })

    return output;
  },
};

export default function designer_helpers(opts) {
  this.style_elem = '', this.data = {};
  var head = document.head || document.getElementsByTagName('head')[0];
  var self = this;
  var opts = $.extend({
    styleElemId: '', // theme-designer-inline-css;
  }, opts)

  /**
   * get style element
   */
  this.get_style_element = function() {
    if($('style#' + opts.styleElemId).length > 0) {
      this.style_elem = document.getElementById(opts.styleElemId);
    } else {
      this.style_elem = document.createElement('style');
      this.style_elem.type = 'text/css';

      head.appendChild(this.style_elem);
    }
  }

  /**
   * css render by group type
   */
  this.css_render_by_group_type = function(data) {
    var output = [];
    $.each(data, function(index, item) {
      output.push(design_group_type_handle[item.type](item.properties));
    })

    return output.join(' ');
  }

  /**
   * css bulder data
   */
  this.css_content = function(data) {
    return new Promise(
      function(resolve, reject) {
        var result = [];

        /**
         * each design element
         */
        $.each(data, function(index, item) {
          result.push(`${item.css_selector}` + '{'+ self.css_render_by_group_type(item.group_style) +'}' );
        })

        resolve(result);
      }
    )
  }

  /**
   * render
   */
  this.render = function(data, css_inline) {
    if(this.style_elem == '') this.get_style_element();

    this.css_content(data)
    .then(function(css_conten) {
      if(css_inline) css_conten.push(css_inline);
      $(self.style_elem).html(css_conten);
    })
  }

  return this;
}
