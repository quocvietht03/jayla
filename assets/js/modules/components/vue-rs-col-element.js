/**
 * component rs-col
 */
var helpers = require('../helpers.js');

module.exports = {
  props: ['item', 'index', 'mode'],
  data () {
    return {
      rs_col_inner_classes: ['rs-col-inner'],
    }
  },
  template: `
    <div class="rs-col" :item="item" :index="index" :key="item.key">
      <slot name="tool"></slot>
      <div :class="rs_col_inner_classes" v-sortable-element="widget_sortable_data">
        <slot></slot>
      </div>
    </div>`,
  created (el) {
    if(this.item.children && this.item.children.length == 0) {
      this.rs_col_inner_classes.push('empty-widget');
    }
  },
  computed: {
    area_element_first_display () {
      return (this.item.children && this.item.children.length <= 0) ? true : false;
    },
    widget_sortable_data () {
      var sortable_data = {
        group: {
          name: 'widgets',
          put: ['widgets'],
        },
        draggable: '.widget-item',
        animation: 150,
        dragoverBubble: true,
        onUpdate: this.sortable_update_handle,
        onAdd: this.sortable_add_handle,
      };

      return (this.mode != 'preview') ? sortable_data : false;
    }
  },
  watch: {
    'item.children' (data) {
      if(data.length > 0) {
        if(this.rs_col_inner_classes.indexOf('empty-widget') > 0)
          this.rs_col_inner_classes.splice(this.rs_col_inner_classes.indexOf('empty-widget'), 1);
      } else {
        this.rs_col_inner_classes.push('empty-widget');
      }
    }
  },
  methods: {
    sortable_update_handle (event) {
      this.item.children.splice(event.newIndex, 0, this.item.children.splice(event.oldIndex, 1)[0]);
    },
    sortable_add_handle (event) {
      if(event.from.parentElement.__vue__) {
        /* move group */
        var fromData = event.from.parentElement.__vue__.item || event.from.parentElement.__vue__.$parent.item,
            toData = event.to.parentElement.__vue__.item || event.to.parentElement.__vue__.$parent.item;

        toData.children.splice(event.newIndex, 0, fromData.children.splice(event.oldIndex, 1)[0]);
      } else {
        /* add new */

        var widget_name = $(event.item).data('name'),
            widget_type = $(event.item).data('widget-type'),
            widget_source = (widget_type == 'widget') ? this.$root.root_store.widgets : this.$root.root_store.wp_widgets,
            widgetItem = widget_source.filter(item => {
              return item.name.toLowerCase().indexOf(widget_name.toLowerCase()) > -1
            })[0];

        /* add key */
        var newItem = JSON.parse(JSON.stringify(widgetItem));
        newItem.key = helpers.random_key('widget-element');

        var newIndex = (event.to.parentElement.__vue__.item.children.length == 0) ? 0 : event.newIndex;

        event.to.parentElement.__vue__.item.children.splice(newIndex, 0, newItem);
        $(event.item).remove();
      }

    }
  }
}
