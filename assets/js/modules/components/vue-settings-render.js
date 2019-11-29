/**
 * component settings render
 */

$ = jQuery.noConflict();
module.exports = {
  props: ['fieldMap', 'dataMap'],
  template: `
    <div class="settings-wrap">
      <component
        v-for="(item, key, index) in fieldMap"
        :is="is_component(item.type)"
        :name="key"
        :data-map="dataMap"
        :params="item"
      ></component>
    </div>`,
  created (el) {

  },
  computed: {

  },
  methods: {
    is_component (type) {
      return `${type}-field`;
    },
  }
}
