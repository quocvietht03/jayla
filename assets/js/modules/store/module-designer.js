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
      'width'       : { label: 'Width',       type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: 'The width property sets the width of an element.' },
      'min-width'   : { label: 'Min Width',   type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: 'The min-width property is used to set the minimum width of an element.' },
      'max-width'   : { label: 'Max Width',   type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: 'The max-width property is used to set the maximum width of an element.' },
      'height'      : { label: 'Height',      type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: 'The height property sets the height of an element.' },
      'min-height'  : { label: 'Min Height',  type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: 'The min-height property is used to set the minimum height of an element.' },
      'max-height'  : { label: 'Max Height',  type: 'input', extra_class: 'theme-extends-width-4',  value: '',  placeholder: '0px',  description: 'The max-height property is used to set the maximum height of an element.' },
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

var elements = [
  {
    name: 'Body Tag',
    description: 'format body tag default style',
    help: 'The &#60;body&#62; element contains all the contents of an HTML <br />document, such as text, hyperlinks, images, tables, lists, etc.',
    css_selector: 'body',
    group_default: ['typography', 'space', 'border', 'background'],
  },
  {
    name: 'Button Tag',
    description: 'format button tag default style',
    help: 'The &#60;button&#62; tag defines a clickable button.',
    css_selector: [
      {name: 'Button style default', selector: 'button'},
      {name: 'Button style on :hover', selector: 'button:hover'},
    ],
    group_default: ['typography', 'space', 'border', 'background'],
  },
  {
    name: 'A Tag',
    description: 'format a(link) tag default style',
    help: 'The &#60;a&#62; tag defines a hyperlink, which is used to <br />link from one page to another. ',
    css_selector: [
      {name: 'Link style default', selector: 'a'},
      {name: 'Link style on :hover', selector: 'a:hover'},
    ],
    group_default: ['typography'],
  },
  {
    name: 'Heading Tag',
    description: 'format heading(h1 .. h6) tag default style',
    help: 'Headings are defined with the &#60;h1&#62; to &#60;h6&#62; tags.',
    css_selector: [
      {name: 'General H1 .. H6', selector: 'h1,h2,h3,h4,h5,h6'},
      {name: 'H1', selector: 'h1'},
      {name: 'H2', selector: 'h2'},
      {name: 'H3', selector: 'h3'},
      {name: 'H4', selector: 'h4'},
      {name: 'H5', selector: 'h5'},
      {name: 'H6', selector: 'h6'},
    ],
    group_default: ['typography'],
  },
];

module.exports = {
  state: {
    group_style   : group_style,
    elements      : elements,
    data          : theme_customize_object.jayla_designer_settings,
    google_fonts  : {},
    data_edit     : {},
  },
  mutations: {},
}
