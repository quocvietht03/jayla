/**
 * component editor tool
 */
var helpers = require('../helpers.js');

module.exports = {
  props: ['parentData', 'item', 'index'],
  template: `
    <ul :class="classes.wrap">
      <li :class="classes.sort"><span class="ion-navicon-round" aria-hidden="true"></span></li>
      <li :class="classes.config" @click="config_item($event, item)"><span class="ion-gear-a"></span></li>
      <li v-if="item.element == 'rs-col'" :class="classes.addmore" @click="addmore_col_item"><span class="ion-plus-round" aria-hidden="true"></span></li>
      <li :class="classes.remove" @click="remove_item"><span class="ion-android-delete" aria-hidden="true"></span></li>
    </ul>`,
  computed: {
    classes () {
      // var class_data = ['element-editor-tools', 'control-' + this.item.element];

      var class_data = {
        'wrap': ['element-editor-tools', 'control-' + this.item.element].join(' '),
        'sort': ['sort-item', 'sort-item-' + this.item.element].join(' '),
        'addmore': ['add-more-item', 'add-more-item-' + this.item.element].join(' '),
        'config': ['config-item', 'config-item-' + this.item.element].join(' '),
        'remove': ['remove-item', 'remove-item-' + this.item.element].join(' '),
      }

      return class_data;
    }
  },
  methods: {
    reset_col_width () {

    },
    remove_item () {
      this.parentData.splice(this.index, 1);
    },
    addmore_col_item () {
      var new_col = {
        key: helpers.random_key('col-element'),
        element: 'rs-col',
        params: {
          width: 0,
          padding: '',
        },
        children: [],
      };

      this.parentData.splice(this.index + 1 , 0, new_col);
    },
    config_item (event, item) {
      this.$root.root_store.element_edit = item;
    },
  }
}
