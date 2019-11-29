/**
 * component typography field
 */

var google_font_data = require('../../google_webfonts.js');

module.exports = {
  props: ['params', 'name', 'dataMap'],
  data () {
    return {
      model: this.dataMap[this.name],
      font_variant_data: [],
      font_style_data: [
        { label: 'bold', icon: 'flaticon-bold' },
        { label: 'italic', icon: 'flaticon-italic-text' },
        { label: 'underline', icon: 'flaticon-underline' },
        { label: 'strikethrough', icon: 'flaticon-strikethrough-text-interface-option-button' },
      ],
      google_fonts: google_font_data.items,
      lang: {
        text_16px: '16px',
        text_25px: '25px',
        text_0px: '0px',
      }
    };
  },
  template: `
    <div :class="classes">
      <label v-if="params.label">
        {{ params.label }}
        <el-tooltip placement="top" v-if="params.description" popper-class="theme-extends-customize-zindex">
          <div slot="content">{{ params.description }}</div>
          <span class="ion-help-circled"></span>
        </el-tooltip>
      </label>
      <div class="theme-extends-font-style-group">
        <div class="label">Font Style</div>
        <el-checkbox-group v-model="model.font_style">
          <el-checkbox-button v-for="font_style_item in font_style_data" :label="font_style_item.label">
            <i :class="['fi', font_style_item.icon]"></i>
          </el-checkbox-button>
        </el-checkbox-group>
      </div>
      <div class="theme-extends-font-family-group theme-extends-margin">
        <div class="label">Font Family</div>
        <el-select v-model="model.font_family" filterable class="theme-extends-select-full-width" popper-class="theme-extends-customize-zindex theme-extends-custom-select-option">
          <el-option-group
            v-for="font_family_group in font_family_data"
            :key="font_family_group.label"
            :label="font_family_group.label">
            <el-option
              v-for="font_family_item in font_family_group.options"
              :key="font_family_item.value"
              :label="font_family_item.label"
              :value="font_family_item.value">
            </el-option>
          </el-option-group>
        </el-select>
      </div>
      <div class="theme-extends-margin">
        <div class="theme-extends-font-variant-group" style="width: 60%; float: left; padding-right: 10px; box-sizing: border-box;">
          <div class="label">Font Variant</div>
          <el-select v-model="model.font_variant" class="theme-extends-select-full-width" popper-class="theme-extends-customize-zindex theme-extends-custom-select-option">
            <el-option
              v-for="font_variant_item in font_variant_data"
              :key="font_variant_item.value"
              :label="font_variant_item.label"
              :value="font_variant_item.value">
            </el-option>
          </el-select>
        </div>
        <div class="theme-extends-font-size-group" style="width: 40%; float: left;">
          <div class="label">Font Size</div>
          <el-input :placeholder="lang.text_16px" v-model="model.font_size"></el-input>
        </div>
        <div class="clear"></div>
      </div>
      <div class="theme-extends-margin">
        <div class="theme-extends-lineheight-group" style="width: 60%; float: left; padding-right: 10px; box-sizing: border-box;">
          <div class="label">Line Height</div>
          <el-input :placeholder="lang.text_25px" v-model="model.line_height"></el-input>
        </div>
        <div class="theme-extends-letterspacing-group" style="width: 40%; float: left;">
          <div class="label">Letter Spacing</div>
          <el-input :placeholder="lang.text_0px" v-model="model.letter_spacing"></el-input>
        </div>
        <div class="clear"></div>
      </div>
      <div class="theme-extends-margin">
        <div class="theme-extends-textcolor-group" style="width: 60%; float: left; padding-right: 10px; box-sizing: border-box;">
          <div class="label">Text Color</div>
          <bears-color-picker-field v-model="model.text_color" />
          <!-- <el-color-picker v-model="model.text_color"></el-color-picker> -->
        </div>
        <div class="theme-extends-textcolor-group" style="width: 40%; float: left;">
          <div class="label">SVG Fill Color</div>
          <bears-color-picker-field v-model="model.fill_color" />
          <!-- <el-color-picker v-model="model.fill_color"></el-color-picker> -->
        </div>
        <div class="clear"></div>
      </div>
      <slot></slot>
    </div>`,
  created (el) {
    if(this.model.font_family) {
      this.set_font_variant(this.model.font_family);
    }
  },
  computed: {
    classes () {
      var classes = ['theme-extends-field-wrap', 'field-type-' + this.params.type];
      if(this.params.extra_class) classes.push(this.params.extra_class);
      return classes;
    },
    google_font_data () {
      return this.google_fonts.map(function(item) {
        return {
          value: item.family,
          key: item.family,
        };
      })
    },
    font_family_data () {
      return [
        {
          label: 'Theme',
          options: [
            {
              value: '',
              label: 'Theme default',
            },
            {
              value: 'Futura',
              label: 'Futura Regular'
            },
            // {
            //   value: 'Gilroy',
            //   label: 'Gilroy',
            //   variants: ['300', '800'],
            // },
            {
              value: 'Texta',
              label: 'Texta',
              variants: ['normal', '300', '500', '700'],
            },
            {
              value: 'Neue Einstellung',
              label: 'Neue Einstellung',
              variants: ['normal', '300', '500', '700'],
            },
          ]
        },
        {
          label: 'Google Fonts',
          options: this.google_font_data,
        }
      ];
    },
  },
  watch: {
    'model.font_family' (data) {
      this.set_font_variant(data);
      this.model.font_variant = (this.font_variant_data.length > 0) ? this.font_variant_data[0].value : '';
    },
  },
  methods: {
    set_font_variant (font_family) {

      /* scan local fonts */
      var result = this.font_family_data[0].options.find(function( item ) {
        return (font_family == item.value);
      })
      
      if( ! result ) {
        /* scan google fonts */
        var result = this.google_fonts.find(function(item) {
          return (font_family == item.family);
        })
      }

      this.font_variant_data = (result && result.variants) ? result.variants.map(function(item) {
        return {
          value: item,
          label: item
        }
      }) : [];
    }
  }
}
