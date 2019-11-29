/**
 * component design group fields
 */

module.exports = {
  props: ['item', 'index'],
  data () {
    return {
      activeNames: '',
    }
  },
  template: `
    <el-collapse v-model="activeNames">
      <el-collapse-item :name="group_controls.base_id">
        <span slot="title" class="collapse-title-group-style">
          {{ group_controls.name }}
        </span>
        <div :class="classes">
          <component
            v-for="(_item, key, _index) in control_data"
            :is="get_component_type(_item.type)"
            :name="key"
            :params="_item"
            :data-map="item.properties">
          </component>
          <div class="collapse-footer">
            <button class="btn-remove-style" type="button" @click="remove_block_style($event)">
              <i class="ion-close-round"></i>
              Remove Style
            </button>
          </div>
        </div>
      </el-collapse-item>
    </el-collapse>`,
  computed: {
    classes () {
      return ['theme-extends-design-group-fields'];
    },
    group_type () {
      return this.item.type;
    },
    group_style () {
      return this.$root.designer_store.group_style;
    },
    group_controls () {
      var type = this.group_type;
      return this.group_style.filter( item => {
        return item.base_id == type;
      } )[0];
    },
    control_data () {
      return JSON.parse(JSON.stringify(this.group_controls.controls));
    },
  },
  methods: {
    remove_block_style (event) {
      event.preventDefault();
      this.$root.designer_store.data_edit.group_style.splice(this.index, 1);
    },
    get_component_type (type) {
      return `${type}-field`;
    },
  },
}
