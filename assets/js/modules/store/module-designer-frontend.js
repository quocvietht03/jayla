/**
 * Store module designer
 */

var group_style = [
  {
    base_id: 'typography',
    name: 'Typography',
    description: 'font, color, size, line-height, etc.',
    icon: 'flaticon-capitals',
    data_map: {
      'typography'  : {
        font_style: [],
        font_family: '',
        font_variant: '',
        font_size: '',
        line_height: '',
        letter_spacing: '',
        text_color: '',
        fill_color: '',
      },
    },
    controls: {
      'typography'  : {
        label: 'Text',
        type: 'typography',
        value: {},
        extra_class: '',
        description: ''
      },
    },
  },
  {
    base_id: 'size',
    name: 'Size',
    description: 'width, height.',
    icon: 'flaticon-full-size',
    data_map: {
      'width': '',
      'min-width': '',
      'max-width': '',
      'height': '',
      'min-height': '',
      'max-height': '',
    },
    controls: {
      'width'       : { label: 'Width',       type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: '' },
      'min-width'   : { label: 'Min Width',   type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: '' },
      'max-width'   : { label: 'Max Width',   type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: '' },
      'height'      : { label: 'Height',      type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: '' },
      'min-height'  : { label: 'Min Height',  type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: '' },
      'max-height'  : { label: 'Max Height',  type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: '' },
    },
  },
  {
    base_id: 'space',
    name: 'Space',
    description: 'margin & padding.',
    icon: 'flaticon-left-margin',
    data_map: {
      'margin': '',
      'padding': '',
    },
    controls: {
      'margin'      : { label: 'Margin',      type: 'input',   value: '', placeholder: '0px 0px 0px 0px',  description: 'The margin shorthand property sets all the margin properties in one declaration. This property can have from one to four values.' },
      'padding'     : { label: 'Padding',     type: 'input',   value: '', placeholder: '0px 0px 0px 0px',  description: 'The padding shorthand property sets all the padding properties in one declaration. This property can have from one to four values.' },
    },
  },
  {
    base_id: 'border',
    name: 'Border',
    description: 'format border style, color, radius.',
    icon: 'flaticon-border',
    data_map: {
      'border-style': '',
      'border-width': '',
      'border-radius': '',
      'border-color': '',
    },
    controls: {
      'border-style'  : {
        label: 'Border Style',
        type: 'select',
        options: [
          { label: 'None',    value: 'none',    },
          { label: 'Dotted',  value: 'dotted',  },
          { label: 'Dashed',  value: 'dashed',  },
          { label: 'Double',  value: 'double',  },
          { label: 'Solid',   value: 'solid',   },
        ],
        extra_class: 'theme-extends-width-7',
      },
      'border-width'  : {
        label: 'Border Width',
        type: 'input',
        extra_class: 'theme-extends-width-5',
        placeholder: '0px',
      },
      'border-radius' : {
        label: 'Border Radius',
        type: 'input',
        extra_class: '',
        placeholder: '0px 0px 0px 0px',
      },
      'border-color'  : {
        label: 'Border Color',
        type: 'color-picker',
        alpha: true,
        extra_class: '',
      },
    },
  },
  {
    base_id: 'position',
    name: 'Position',
    description: 'Property specifies the type of positioning method.',
    icon: 'flaticon-background',
    data_map: {
      position: '',
      left: '',
      top: '',
    },
    controls: {
      'position'  : {
        label: 'Position',
        type: 'select',
        options: [
          { label: 'Static',    value: 'static',    },
          { label: 'Absolute',  value: 'absolute',  },
          { label: 'Fixed',     value: 'fixed',     },
          { label: 'Relative',  value: 'relative',  },
          { label: 'Initial',   value: 'initial',   },
          // { label: 'Sticky',    value: 'sticky',    },
          // { label: 'Inherit',   value: 'inherit',   },
        ],
      },
      'top'  : {
        label: 'Top',
        type: 'input',
        extra_class: 'theme-extends-width-6',
        placeholder: '0px',
      },
      'right'  : {
        label: 'Right',
        type: 'input',
        extra_class: 'theme-extends-width-6',
        placeholder: '0px',
      },
      'bottom'  : {
        label: 'Bottom',
        type: 'input',
        extra_class: 'theme-extends-width-6',
        placeholder: '0px',
      },
      'left'  : {
        label: 'Left',
        type: 'input',
        extra_class: 'theme-extends-width-6',
        placeholder: '0px',
      },
    }
  },
  {
    base_id: 'background',
    name: 'Background',
    description: 'format background image, color.',
    icon: 'flaticon-background',
    data_map: {
      'background-color': '',
      'background-image': '',
      'background-size': '',
      'background-repeat': '',
      'background-position': '',
      'background-attachment': '',
    },
    controls: {
      'background-color': {
        label: 'Background Color',
        type: 'color-picker',
        alpha: true,
        extra_class: '',
      },
      'background-image': {
        label: 'Background Image',
        type: 'wp-media',
        extra_class: '',
      },
      'background-size': {
        label: 'Background Size',
        type: 'select',
        options: [
          { label: 'Cover',               value: 'cover'     },
          { label: 'Contain',             value: 'contain'   },
          { label: 'Initial',             value: 'initial'   },
        ],
        condition: {
          'background-image': 'not-null',
        },
      },
      'background-repeat': {
        label: 'Background Repeat',
        type: 'select',
        options: [
          { label: 'No Repeat',           value: 'no-repeat'  },
          { label: 'Tile',                value: 'repeat'     },
          { label: 'Tile Horizontally',   value: 'repeat-x'   },
          { label: 'Tile Vertically',     value: 'repeat-y'   },
        ],
        condition: {
          'background-image': 'not-null',
        },
      },
      'background-position': {
        label: 'Background Position',
        type: 'select',
        options: [
          { label: 'Left',    value: 'left'    },
          { label: 'Center',  value: 'center'  },
          { label: 'Right',   value: 'right'   },
        ],
        condition: {
          'background-image': 'not-null',
        },
      },
      'background-attachment': {
        label: 'Background Attachment',
        type: 'select',
        options: [
          { label: 'Scroll',   value: 'scroll'  },
          { label: 'Fixed',    value: 'fixed'   },
        ],
        condition: {
          'background-image': 'not-null',
        },
      },
    },
  },
];

var design_frontend_data = [
  {
    'name': 'Body Tag',
    'css_selector': 'body',
    'group_style': [],
  },
];

// console.log(JSON.parse(window._designer_frontend_data.google_fonts));

module.exports = {
  state: {
    group_style   : group_style,
    // elements      : elements,
    data          : window._designer_frontend_data.design_data,
    css_inline    : window._designer_frontend_data.css_inline,
    google_fonts  : {}, // JSON.parse(window._designer_frontend_data.google_fonts),
    data_edit     : {},
  },
  mutations: {},
}
