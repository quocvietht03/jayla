/**
 * component select field
 */
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
      <el-select v-model="dataMap[name]" class="theme-extends-select-full-width" popper-class="theme-extends-customize-zindex theme-extends-custom-select-option">
        <el-option
          v-for="item in params.options"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <slot></slot>
    </div>`,
  created (el) {
    // value init
    if(typeof this.dataMap[this.name] == 'undefined' && this.params.value ) {
      Vue.set(this.dataMap, this.name, this.params.value);
    }
  },
  computed: {
    classes () {
      var classes = ['theme-extends-field-wrap', 'field-type-' + this.params.type];
      if(this.params.extra_class) classes.push(this.params.extra_class);
      return classes;
    }
  },
  methods: {

  }
}
