/**
 * component child component
 */

$ = jQuery.noConflict();
module.exports = {
  props: ['item', 'index', 'mode'],
  template: `
      <component
        :is="item.element"
        v-col-resize="element_resize_data"
        v-sortable-element="element_sortable_data"
        :item="item"
        :index="index"
        :mode="mode"
        :action="enable_widget_action"
        :class="element_class(item)"
        :style="element_style_inline">

        <editor-tool slot="tool" v-if="editor_tool_display" :parent-data="parent_item_data" :item="item" :index="index"></editor-tool>

        <child-component
          v-if="item.children && item.children.length > 0"
          v-for="(child_item, child_index) in item.children"
          :item="child_item"
          :index="child_index"
          :mode="mode"
          :key="child_item.key">
        </child-component>

      </component>`,
  created (el) {
    switch (this.item.element) {
      case 'rs-row':
        this.$root.$on('event:resize_col' + this.item.key, this.calc_col_resize_handle);
        break;

      case 'rs-col':

        break;
    }
  },
  computed: {
    enable_widget_action () {
      var allow_element = ['widget', 'wp-widget'];
      return ( ($.inArray(this.item.element, allow_element) >= 0) && this.mode != 'preview' );
    },
    count_children_element () {
      if( this.item.element != 'rs-row' ) return;
      return this.item.children.length;
    },
    parent_item_data () {
      switch (this.item.element) {
        case 'rs-row':
          return this.$parent.data;
          break;

        case 'rs-col':
          return this.$parent.$parent.item.children;
          break;
      }
    },
    children_data () {
      return (this.item.children) ? this.item.children : [];
    },
    editor_tool_display () {
      return ($.inArray(this.item.element, ['sr-row','sr-col']) && this.mode != 'preview');
    },
    element_sortable_data () {

      var sortable_opts = {
        'rs-row': {
          group: {
            name: 'cols',
            put: ['cols'],
          },
          animation: 150,
          handle: '.sort-item-rs-col',
          draggable: '.rs-col',
          dragoverBubble: true,
          onUpdate: this.sortable_update_cols_handle,
          onAdd: this.sortable_add_cols_handle,
        },
      }

      return (sortable_opts[this.item.element] && this.mode != 'preview') ? sortable_opts[this.item.element] : false;
    },
    element_resize_data () {
      return (this.item.element == 'rs-col') ? [this.item, this.index] : false;
    },
    element_style_inline () {
      var style = {};

      if(this.item.params && this.item.params.style_inline)
        style = $.extend(style, this.item.params.style_inline);

      if(this.item.element == 'rs-col') {
        style.width = this.get_col_width() + '%';
      }

      return style;
    }
  },
  watch: {
    'count_children_element' (count) {
      this.item.children.forEach(function(item) {
        if(item.element == 'rs-col') {
          item.params.width = 100/count;
        }
      })
    }
  },
  methods: {
    sortable_add_cols_handle (event) {
      var fromData = event.from.__vue__.item || event.from.__vue__.$parent.item,
          toData = event.to.__vue__.item || event.to.__vue__.$parent.item;

      toData.children.splice(event.newIndex, 0, fromData.children.splice(event.oldIndex, 1)[0]);
    },
    sortable_update_cols_handle (event) {
      // console.log(event);
      this.children_data.splice(event.newIndex, 0, this.children_data.splice(event.oldIndex, 1)[0]);
    },
    calc_col_resize_handle (item, new_width) {

      if(this.item.element != 'rs-row') return;
      var index = this.item.children.indexOf(item);


      var current_item        = this.item.children[index],
          pre_item            = this.item.children[index - 1];

      var current_width       = parseFloat(current_item.params.width).toFixed(3),
          pre_width           = parseFloat(pre_item.params.width).toFixed(3),
          change_width        = parseFloat(new_width - current_width).toFixed(3),
          pre_new_width       = parseFloat(pre_width - change_width).toFixed(3);

      this.item.children[index].params.width = new_width;
      this.item.children[index - 1].params.width = pre_new_width;
    },
    get_col_width () {
      return this.item.params.width;
    },
    element_class (item) {
      return '';
    }
  }
}
