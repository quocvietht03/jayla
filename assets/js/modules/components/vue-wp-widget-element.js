/**
 * component wp widget
 */

module.exports = {
  props: ['item', 'index', 'mode', 'showDescription', 'action'],
  data () {
    return {
      lang: {
        edit: 'edit',
        remove: 'remove',
      }
    }
  },
  template: `
    <div class="widget-item wp-widget-item" :data-name="item.name" :data-widget-type="item.element">
      <div class="icon-wrap">
        <span v-if="item.icon" :class="item.icon"></span>
      </div>
      <div class="widget-entry" v-if="mode != 'preview'">
        <div class="title">{{ item.title }}</div>
        <div class="des" v-show="showDescription">{{ item.description }}</div>
      </div>
      <div class="widget-actions" v-if="action == true">
        <div class="item-action config-action" :title="lang.edit" @click="config_item($event, item)"><span class="ion-gear-a"></span></div>
        <div class="item-action remove-action" :title="lang.remove" @click="remove_handle"><span class="ion-android-delete"></span></div>
      </div>
    </div>`,
  computed: {

  },
  methods: {
    config_item (event, item) {
      event.preventDefault();
      this.$root.root_store.element_edit = item;
    },
    remove_handle (event) {
      event.preventDefault();
      /**
       * rs-col/rs-col-inner/widget
       */
      this.$parent.$parent.item.children.splice(this.index, 1);
    }
  }
}
