/**
 * component customize builder
 */

var helpers = require('../helpers.js');
module.exports = {
  props: ['data', 'mode'],
  data () {
    return {
      popover_row_temp_visible: false,
      custom_row_input: '',
      lang: {
        custom_row_text: 'Input custom row (Exam: 15/70/15 & Enter for push a new row)',
      }
    }
  },
  template: `
    <div
      :class="wrap_classes"
      v-sortable-element="element_sortable_data">

      <child-component
        v-for="(item, index) in data"
        :item="item"
        :index="index"
        :mode="mode"
        :key="item.key"
        >
      </child-component>

      <div class="customize-builder-footer-tools" v-if="mode != 'preview'">
        <el-popover
          ref="rowtemplate"
          placement="top"
          title="Select your structure"
          width="600"
          trigger="hover"
          v-model="popover_row_temp_visible"
          popper-class="theme-extends-popover-ui theme-extends-customize-zindex"
        >
          <el-row class="theme-extends-grid-template" :gutter="8">
            <el-col :span="12">
              <div class="grid-content bg-purple" @click="add_row($event, [100])">
                <el-row class="theme-extends-custom-el-row" >
                  <el-col :span="24"><div class="grid-content bg-purple-dark">100%</div></el-col>
                </el-row>
              </div>
            </el-col>

            <el-col :span="12">
              <div class="grid-content bg-purple" @click="add_row($event, [50,50])">
                <el-row class="theme-extends-custom-el-row" >
                  <el-col :span="12"><div class="grid-content bg-purple">50%</div></el-col>
                  <el-col :span="12"><div class="grid-content bg-purple-light">50%</div></el-col>
                </el-row>
              </div>
            </el-col>

            <el-col :span="12">
              <div class="grid-content bg-purple" @click="add_row($event, [33.333,33.333,33.333])">
                <el-row class="theme-extends-custom-el-row" >
                  <el-col :span="8"><div class="grid-content bg-purple">33.3%</div></el-col>
                  <el-col :span="8"><div class="grid-content bg-purple-light">33.3%</div></el-col>
                  <el-col :span="8"><div class="grid-content bg-purple">33.3%</div></el-col>
                </el-row>
              </div>
            </el-col>

            <el-col :span="12">
              <div class="grid-content bg-purple" @click="add_row($event, [20, 80])">
                <el-row class="theme-extends-custom-el-row" >
                  <el-col :span="4"><div class="grid-content bg-purple">20%</div></el-col>
                  <el-col :span="20"><div class="grid-content bg-purple-light">80%</div></el-col>
                </el-row>
              </div>
            </el-col>

            <el-col :span="12">
              <div class="grid-content bg-purple" @click="add_row($event, [20,60,20])">
                <el-row class="theme-extends-custom-el-row" >
                  <el-col :span="4"><div class="grid-content bg-purple">20%</div></el-col>
                  <el-col :span="16"><div class="grid-content bg-purple-light">60%</div></el-col>
                  <el-col :span="4"><div class="grid-content bg-purple">20%</div></el-col>
                </el-row>
              </div>
            </el-col>

            <el-col :span="12">
              <div class="grid-content bg-purple" @click="add_row($event, [25,25,25,25])">
                <el-row class="theme-extends-custom-el-row" >
                  <el-col :span="6"><div class="grid-content bg-purple">25%</div></el-col>
                  <el-col :span="6"><div class="grid-content bg-purple-light">25%</div></el-col>
                  <el-col :span="6"><div class="grid-content bg-purple">25%</div></el-col>
                  <el-col :span="6"><div class="grid-content bg-purple-light">25%</div></el-col>
                </el-row>
              </div>
            </el-col>

            <el-col :span="24">
            <div class="grid-content bg-purple">
              <el-row class="theme-extends-custom-el-row">
                <input
                  v-on:keyup="add_custom_row($event)"
                  v-model="custom_row_input"
                  class="theme-extends-input-add-custom-row"
                  :placeholder="lang.custom_row_text">
              </el-row>
            </div>
            </el-col>
          </el-row>
        </el-popover>
        <div class="tool-item add-row-wrap" v-popover:rowtemplate><span class="ion-plus-round"></span></div>
      </div>
    </div>`,
  computed: {
    wrap_classes () {
      var _class = ['theme-extends-customize-builder', 'customize-builder-wrap'];
      if(this.mode) { _class.push('builder-mode-' + this.mode); }

      return _class;
    },
    element_sortable_data () {
      return {
        group: 'rows',
        onUpdate: this.sortable_update_rows_handle,
        animation: 150,
        draggable: '.rs-row',
        handle: '.sort-item-rs-row',
      };
    }
  },
  methods: {
    add_custom_row(e) {
      if (e.keyCode == 13) {
        var data = this.custom_row_input;
        this.add_row(e, data.split('/'));

        /* empty field */
        this.custom_row_input = '';
      }
    },
    sortable_update_rows_handle (event) {
      this.data.splice(event.newIndex, 0, this.data.splice(event.oldIndex, 1)[0]);
    },
    make_col_data (data) {
      var result = [];

      data.forEach(function(width) {
        result.push({
          key: helpers.random_key('col-element'),
          element: 'rs-col',
          params: {
            width: width,
            padding: '',
          },
          children: []
        })
      });

      return result;
    },
    add_row (event, data) {
      this.data.push({
        key: helpers.random_key('row-element'),
        element: 'rs-row',
        params: {
          content_width: 'large',
        },
        children: this.make_col_data(data),
      });

      this.popover_row_temp_visible = false;
    }
  }
}
