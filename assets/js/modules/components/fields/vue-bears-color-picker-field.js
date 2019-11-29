/**
 * component select field
 */
var condition = require('../mixins/vue-condition-mixins.js');

module.exports = {
    props: ['value'],
    data () {
        return {
           
        }
    },
    template: `
    <div class="el-bears-color-picker">
        <el-popover
            placement="top"
            width="200"
            popper-class="popup-bears-color-picker" 
            trigger="click">
            <div class="el-bears-color-picker">
                <chrome-color-picker-field v-model="value" @input="updateValue"/>
            </div>
            <el-button slot="reference" class="bears-color-picker-btn">
                <span :class="el_color_bg_class" :style="{'background-color': value}"></span>
                <span class="__icon"><i class="el-icon-arrow-down"></i></span>
            </el-button>
        </el-popover>
        <span v-show="(value != '')" class="clear-color" @click="clearColor">×</span>
    </div>`,
    created(el) {
       
    },
    watch: {
        
    },
    computed: {
       el_color_bg_class() {
            var classes = ['el-color-bg'];
            if(this.value == '') {
                    classes.push( '__color_empty' );
            }

            return classes.join(' ');
       }
    },
    methods: {
        updateValue(value) {
            if( value && value.rgba ) {
                var rgba_value = `rgba(${value.rgba.r}, ${value.rgba.g}, ${value.rgba.b}, ${value.rgba.a})`;
                // this._color = rgba_value;
                this.$emit('input', rgba_value);
                this.$emit('change', rgba_value);
            }
        },
        clearColor() {
            this.$emit('input', '');
            this.$emit('change', '');
        }
    }
}