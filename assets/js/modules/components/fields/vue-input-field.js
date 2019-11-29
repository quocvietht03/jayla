/**
 * component input field
 */
var condition = require('../mixins/vue-condition-mixins.js');
module.exports = {
  props: ['params', 'name', 'dataMap'],
  mixins: [condition],
  template: `
    <div :class="classes" v-show="visible">
      <label v-if="params.label">
        {{ params.label }}
        <el-tooltip placement="top" v-if="params.description" popper-class="theme-extends-customize-zindex">
          <div slot="content">{{ params.description }}</div>
          <span class="ion-help-circled"></span>
        </el-tooltip>
      </label>
      <el-input :placeholder="params.placeholder" v-model="dataMap[name]"></el-input>
      <slot></slot>
    </div>`,
  created (el) {
    if(typeof this.dataMap[this.name] == 'undefined' && this.params.value ) {
      Vue.set(this.dataMap, this.name, this.params.value);
    }
  },
  computed: {
    classes () {
      var classes = ['theme-extends-field-wrap', 'field-type-' + this.params.type];
      if(this.params.extra_class) classes.push(this.params.extra_class);
      return classes;
    },
    visible () {
      if(this.params.hidden && this.params.hidden == true) return false;
      return this.condition_value;
    }
  },
  methods: {

  }
}
