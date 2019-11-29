<?php
/**
 * Class to create a Action Control.
 *
 */
class Jayla_Footer_Builder_Control extends WP_Customize_Control {

	public function render_content() {
  ?>
  <div id="theme-extends-footer-action-control">
    <div class="theme-extends-customize-control-title"><?php _e( 'Footer Customizer', 'jayla' ) ?></div>
    <div class="theme-extends-message">
      <span class="ion-information-circled"></span>
      <?php _e('The Footer Customizer allows you to creative footer layout with drag-drop the components.', 'jayla'); ?>
    </div>

    <div class="theme-extends-footer-layouts theme-extends-margin">
      <el-row :gutter="10">
        <el-col class="theme-extends-margin" :span="24" v-if="root_store.layouts.length" v-for="(item, index) in root_store.layouts" :item="item" :index="index" :key="item.key">
          <div class="layout-content">
            <div
              @click="select_layout_handle($event, item)"
              :class="footer_class_list(item)"
              >
              <div v-if="footer_edit == item" class="editing-overlay">
                <span><?php _e('Editing...', 'jayla'); ?><span>
              </div>
              <div class="title">{{ item.name }}</div>
              <customize-builder :data="item.footer_data" mode="preview"></customize-builder>
            </div>
            <div class="actions">
              <div class="item-action edit-action" @click="edit_layout_handle($event, item)" title="<?php esc_attr_e('edit', 'jayla'); ?>"><span class="ion-gear-a"></span></div>
              <div v-if="(! item.lock || item.lock == false)" @click="remove_layout_handle($event, item, index)" class="item-action remove-action" title="<?php esc_attr_e('remove', 'jayla'); ?>"><span class="ion-android-delete"></span></div>
            </div>
          </div>
        </el-col>

        <!-- new footer layout ui -->
        <el-col class="theme-extends-margin" :span="24">
          <div class="layout-content">
            <div class="add-footer-layout" @click="new_layout_handle($event)">
              <div class="add-footer-layout-inner">
                <span class="ion-plus-round"></span> <?php _e('New layout', 'jayla'); ?>
              </div>
            </div>
          </div>
        </el-col>
      </el-row>

      <div class="theme-extends-margin"></div>
    </div>
  </div>
  <textarea hidden id="theme-extends-footer-builder-layout-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('footer_layout'))); ?>><?php echo esc_textarea( $this->value('footer_layout') ); ?></textarea>
  <textarea hidden id="theme-extends-footer-builder-data-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('footer_data'))); ?>><?php echo esc_textarea( $this->value('footer_data') ); ?></textarea>
  <?php
  }
}
