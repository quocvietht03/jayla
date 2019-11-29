/**
 * designer frontend component
 */

module.exports = {
  props: [],
  data () {
    return {
      heading_pane: 'Design',
      back_button: false,
      frontend_body_classes: ['designer-frontend-body'],
      group_style_visible: false,
      design_mode: 'design-block',
      draggable_data: {
        handle: '.heading-pane',
        containment: 'window',
      },
      lang: {
        save_style: 'Save style',
      }
    }
  },
  template: `<div class="theme-extends-designer-frontend-wrap" v-draggable-element="draggable_data">
    <div class="__inner" v-loading="loading.active" :element-loading-text="loading.loading_text">
      <div class="heading-pane">
        <a v-show="back_button" href="javascript:" class="__back" @click="clearDataEdit($event)"><i class="ion-android-arrow-back"></i></a>
        <span>{{ heading_pane }}</span>
        <a href="javascript:" class="__close" @click="closeDesignerMode($event)"><span class="ion-close-round"></span></a>
      </div>
      <div :class="frontend_body_classes">
        <!-- design block -->
        <div class="__body_inner inner_design_block">
          <br />
          <div v-if="design_target_list_data.length > 0" class="theme-extends-selector-element-list-wrap">
            <p>Select item for design!</p>
            <a href="javascript:" class="btn-clear-selector-element" @click="clearTargetListData($event)"><span class="ion-ios-close-empty"></span></a>
            <ul class="theme-extends-selector-element-list">
              <li v-for="item in design_target_list_data" @click="triggerAddDesignElement(item.name, item.selector)">
                <i class="ion-ios-arrow-right"></i> <span>{{ item.name }}</span>
              </li>
            </ul>

            <br /><hr />
          </div>

          <!-- list element design -->
          <ul class="designer-element-list" v-if="design_data.length > 0">
            <li class="item" v-for="item in design_data" @click="setEditElement(item, $event)">
              <span class="element-name">{{ item.name }}</span>
              <i class="ion-ios-arrow-right"></i>
            </li>
          </ul>

          <!-- edit element design -->
          <div class="design-edit-element-pane" v-show="Object.keys(design_data_edit).length > 0">
            <design-group-fields v-for="(item, index) in design_data_edit.group_style" :item="item" :index="index"></design-group-fields>
            <div class="add-group-style">
              <el-popover
                v-model="group_style_visible"
                ref="popover-group-style"
                placement="bottom"
                width="200"
                trigger="click"
                popper-class="theme-extends-popover-ui theme-extends-customize-zindex">
                <div class="theme-extends-design-group-style" v-if="design_group_style.length > 0">
                  <div class="theme-extends-design-group-style-item" v-for="(item, index) in design_group_style" @click="add_block_style(item)" :index="index">
                    <div class="title" v-if="item.name"><span v-if="item.icon" :class="['fi', item.icon]"></span> {{ item.name }}</div>
                    <p class="description" v-if="item.description">{{ item.description }}</p>
                  </div>
                </div>
              </el-popover>
              <div class="add-group-style-inner" v-popover:popover-group-style><span class="ion-plus-round"></span> Add Style</div>
            </div>
            <a href="#" class="reset-style" @click="remove_design_element($event)">Remove <strong>"{{ design_data_edit.name }}"</strong> Style</a>
            
          </div>
        </div>
        <!-- css editor -->
        <div class="__body_inner inner_css_editor">
          <editor :content="css_inline" :height="'60vh'" :lang="'css'" :theme="'monokai'"></editor>
        </div>
      </div>
      <div class="footer-pane">
        <a :class="['icon-handle', 'theme-extends-design-block', (design_mode == 'design-block') ? 'current-mode' : '']" href="javascript:" @click="design_mode = 'design-block'"><i class="ion-waterdrop"></i></a>
        <a :class="['icon-handle', 'theme-extends-css-editor', (design_mode == 'css-editor') ? 'current-mode' : '']" href="javascript:" @click="design_mode = 'css-editor'"><i class="ion-code"></i></a>
        <a class="icon-handle theme-extends-design-frontend-save" href="javascript:" :title="lang.save_style" @click="saveHandle($event)">Save</a>
      </div>
    </div>
  </div>`,
  created (el) {

  },
  mounted () {
    var vm = this;
    vm.$on('editor-update', vm.cssEditorUpdate);
  },
  computed: {
    design_group_style () {
      return this.$root.designer_store.group_style;
    },
    css_inline () {
      return this.$root.designer_store.css_inline;
    },
    design_data () {
      return this.$root.designer_store.data;
    },
    design_data_edit () {
      return this.$root.designer_store.data_edit;
    },
    design_target_list_data () {
      return this.$root.element_target_list;
    },
    loading () {
      return this.$root.loading;
    },
  },
  watch: {
    design_data_edit (data) {
      if( Object.keys(data).length > 0 ) {
        // this.frontend_body_classes = ['designer-frontend-body', 'is-edit'];
        this.frontend_body_classes.push('is-edit');

        this.heading_pane   = data.name;
        this.back_button    = true;
      } else {
        // this.frontend_body_classes = ['designer-frontend-body'];
        if(this.frontend_body_classes.indexOf('is-edit') != -1)
          this.frontend_body_classes.splice( this.frontend_body_classes.indexOf('is-edit'), 1 );

        this.heading_pane   = 'Design';
        this.back_button    = false;
      }
    },
    design_mode (data) {
      if( 'css-editor' == data ) {
        this.frontend_body_classes.push('mode-css-editor');
      } else {
        if(this.frontend_body_classes.indexOf('mode-css-editor') != -1)
          this.frontend_body_classes.splice( this.frontend_body_classes.indexOf('mode-css-editor'), 1 );
      }
    },
  },
  methods: {
    closeDesignerMode (e) {
      e.preventDefault();
      this.$root.$emit('Event:DisableDesiner');
    },
    saveHandle (e) {
      e.preventDefault();
      this.$root.$emit('Event:SaveData');
    },
    cssEditorUpdate (data) {
      this.$root.designer_store.css_inline = data;
    },
    setEditElement (item, e) {
      e.preventDefault();
      this.$root.designer_store.data_edit = item;
    },
    clearDataEdit (e) {
      e.preventDefault();
      this.$root.designer_store.data_edit = {};
    },
    add_block_style (item) {
      var new_block_style = {
        type: item.base_id,
        properties: JSON.parse(JSON.stringify(item.data_map)),
      };

      this.design_data_edit.group_style.push(new_block_style);
      this.group_style_visible = false;
    },
    clearTargetListData (e) {
      e.preventDefault();
      this.$root.element_target_list = [];
    },
    triggerAddDesignElement (name, selector) {
      this.$root.$emit('Event:AddDesignElement', name, selector);
    },
    remove_design_element (e) {
      e.preventDefault();

      var index = this.$root.designer_store.data.indexOf(this.$root.designer_store.data_edit);
      this.$root.designer_store.data.splice(index, 1);
      this.$root.designer_store.data_edit = {};
    }
  },
}
