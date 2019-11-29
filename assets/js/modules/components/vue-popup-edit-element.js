/**
 * component popup edit element
 */

$ = jQuery.noConflict();
module.exports = {
  data () {
    return {
      draggable_opts: {
        handle: '.popup-title',
        cursor: 'crosshair',
        drag: this.draggable_drag_handle,
      },
      active_name: 'general',
    }
  },
  template: `
    <div class="popup-edit-element-wrap" v-show="Object.keys(element_edit).length > 0" v-draggable-element="draggable_opts">
      <div class="close-popup" @click="close_popup($event)"><span class="ion-close-round"></span></div>
      <div class="popup-title">{{ popup_title }}</div>
      <div class="popup-body">
      
        <el-tabs v-if="active_tabs == true" v-model="active_name">
          <el-tab-pane v-for="(item, index) in group_options" :name="item.name">
            <span slot="label"><i v-if="item.icon" :class="item.icon"></i> {{ item.title }}</span>
            <settings-render :data-map="get_element_params()" :field-map="item.fields"></settings-render>
          </el-tab-pane>
        </el-tabs>

        <!-- WordPress Widget Form -->
        <div v-if="this.element_edit.element == 'wp-widget'" class="wp-widget-fields">
          <wp-widget-fields :item="element_edit"></wp-widget-fields>
        </div>
      </div>
    </div>`,
  computed: {
    field_map () {
      return this.$store.state.header.widget_options;
    },
    element_edit () {
      return this.$root.root_store.element_edit;
    },
    popup_title () {
      return ( $.inArray(this.element_edit.element, ['widget', 'wp-widget']) >= 0 ) ? `${this.element_edit.element} - ${this.element_edit.title}` : this.element_edit.element;
    },
    active_tabs () {
      var element_type = this.get_widget_type(this.element_edit);
      // console.log(element_type, this.field_map);
      return (this.field_map[element_type] && typeof this.field_map[element_type].groups != 'undefined') ? true : false;
    },
    group_options () {
      var element_type = this.get_widget_type(this.element_edit);
      return this.field_map[element_type].groups;
    },
  },
  watch: {

  },
  methods: {
    get_element_params () {
      if ( (Object.keys(this.element_edit).length > 0) && ! this.element_edit.params )
        Vue.set(this.element_edit, 'params', {});
      // console.log(this.field_map);
      return this.element_edit.params;
    },
    get_widget_type (element) {
      return ( $.inArray(element.element, ['widget', 'wp-widget']) >= 0 ) ? `${element.element}-${element.name}` : element.element;
    },
    draggable_drag_handle (event, ui) {
      $(event.target).css('height', '');
    },
    close_popup ($event) {
      this.$root.root_store.element_edit = {};
    },
  }
}
