/**
 * component switch field
 */
var condition = require('../mixins/vue-condition-mixins.js');

module.exports = {
  props: ['params', 'name', 'dataMap'],
  mixins: [condition],
  template: `
    <div :class="classes" v-show="condition_value">
      <span v-if="params.label">
        {{ params.label }}
        <el-tooltip placement="top" v-if="params.description" popper-class="theme-extends-customize-zindex">
          <div slot="content">{{ params.description }}</div>
          <span class="ion-help-circled"></span>
        </el-tooltip>
      </span>
      <span>
        <el-switch
          v-model="dataMap[name]"
          on-value="on"
          off-value="off"
          on-text=""
          off-text="">
        </el-switch>
      </span>
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
      var classes = ['theme-extends-field-wrap __field-inline', 'field-type-' + this.params.type];
      if(this.params.extra_class) classes.push(this.params.extra_class);
      return classes;
    }
  },
  methods: {

  }
}
