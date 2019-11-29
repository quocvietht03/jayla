/**
 * component radio group field
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
      <div>
        <el-radio-group v-model="dataMap[name]">
          <el-radio-button v-if="params.options" v-for="(item, index) in params.options" :label="item.label">
            {{ item.text }}
          </el-radio-button>
        </el-radio-group>
      </div>
      <slot></slot>
    </div>`,
  computed: {
    classes () {
      return ['theme-extends-field-wrap', 'field-type-' + this.params.type];
    }
  },
  methods: {

  }
}
