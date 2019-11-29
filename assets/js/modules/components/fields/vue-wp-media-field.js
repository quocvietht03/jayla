/**
 * component wp media field
 */

var helpers = require('../../helpers.js');
var condition = require('../mixins/vue-condition-mixins.js');

module.exports = {
  props: ['params', 'name', 'dataMap'],
  mixins: [condition],
  template: `
    <div :class="classes" v-show="condition_value">
      <label v-if="params.label">
        {{ params.label }}
        <el-tooltip placement="top" v-if="params.description" popper-class="theme-extends-customize-zindex">
          <div slot="content">{{ params.description }}</div>
          <span class="ion-help-circled"></span>
        </el-tooltip>
      </label>
      <div class="theme-extend-image-preview-area">
        <div v-if="dataMap[name]" class="img-wrap">
          <img :src="dataMap[name]" />
          <a href="#" class="clear-image" @click="clear_image($event)"><i class="ion-close-round"></i></a>
        </div>
        <span v-else class="no-image">No image set</span>
      </div>
      <button class="btn-open-modal" @click="open_wp_media_lightbox($event)">Select Image</button>
      <slot></slot>
    </div>`,
  computed: {
    classes () {
      var classes = ['theme-extends-field-wrap', 'field-type-' + this.params.type];
      if(this.params.extra_class) classes.push(this.params.extra_class);
      return classes;
    },
    wp_media () {

      var frame = helpers.wp_media();
      frame.on('select', this.wp_media_select_handle);

      return frame;
    },

  },
  methods: {
    open_wp_media_lightbox (event) {

      event.preventDefault();
      this.wp_media.open();
    },
    wp_media_select_handle () {

      // Get media attachment details from the frame state
      var attachment = this.wp_media.state().get('selection').first().toJSON();
      // console.log(attachment);
      // this.dataMap[this.name] = attachment.url;
      Vue.set(this.dataMap, this.name, attachment.url);
    },
    clear_image (event) {

      event.preventDefault();
      this.dataMap[this.name] = "";
    }
  }
}
