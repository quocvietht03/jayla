/**
 * component checkbox group field
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
                <el-checkbox-group v-model="dataMap[name]" :size="fieldSize">
                <el-checkbox-button v-if="params.options" v-for="(item, index) in params.options" :label="item.label" :key="item.label">
                    {{ item.text }}
                </el-radio-button>
                </el-radio-group>
            </div>
            <slot></slot>
        </div>`,
    created(el) {
        this.setDataDefault();
    },
    computed: {
        classes() {
            return ['theme-extends-field-wrap', 'field-type-' + this.params.type];
        },
        fieldSize() {
            return ( this.params.size ) ? this.params.size : '';
        }
    },
    methods: {
        setDataDefault() {
            if(! this.dataMap[this.name]) {
                Vue.set(this.dataMap, this.name, ( this.params.value ) ? this.params.value : [] );
            }
        }
    }
}
