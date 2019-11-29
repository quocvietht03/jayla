<?php

?>
<div id="theme-extends-header-configurator" class="theme-extends-panel">
  <div :class="header_panel_inner_classes">
    <div v-show="!has_edit" class="clear-header-edit" @click="clear_header_edit">
      <span class="ion-close-round"></span> <?php _e('Close', 'jayla'); ?>
    </div>

    <div v-show="has_edit" class="apply-header-edit" @click="update_header_edit">
      <span class="ion-checkmark-circled"></span> <?php _e('Update & Close', 'jayla'); ?>
    </div>

    <div class="theme-extends-message" style="background: #eee; box-shadow: none;">
      <span class="ion-information-circled"></span>
      <?php _e('Allow creating layout header easy, start with new row & columns, use components on the left sidebar by drag and drop.', 'jayla'); ?>
    </div>

    <div class="header-field-name-wrap">
      <input class="header-field-name-input" type="text" v-model="header_edit.name" placeholder="<?php esc_attr_e('Input header layout name', 'jayla') ?>"/>
    </div>

    <strong class="theme-extends-margin"><?php echo sprintf(
      '%s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">New ticksy</a>', 
      __('You can view the tutorial settings footer at', 'jayla'), 
      esc_url( 'https://jayla.wordpress.com/' ),
      __('here', 'jayla'), 
      __('and don\'t hesitate to contact us if you need help', 'jayla'),
      esc_url( 'https://bearsthemes.ticksy.com/' )) ?></strong>

    <el-tabs class="theme-extends-margin" type="card" v-model="header_customize_layout_tab">
      <!-- Settings -->
      <el-tab-pane name="settings">
        <span slot="label"><label class="theme-extends-el-tab-pane-custom-label"><i class="fi flaticon-settings-1"></i> <?php _e('Settings', 'jayla'); ?></label></span>
        <div class="theme-extends-header-general-settings">
          <el-row :gutter="0" justify="space-around">
            <el-col :span="6">
              <el-menu :default-active="settings_tab">
                <el-menu-item @click="settings_tab = 'header_strip'" index="header_strip"><?php _e('Header Strip', 'jayla') ?></el-menu-item>
                <el-menu-item @click="settings_tab = 'header_tablet_mobile'" index="header_tablet_mobile"><?php _e('Tablet & Mobile', 'jayla') ?></el-menu-item>
                <el-menu-item @click="settings_tab = 'header_sticky'" index="header_sticky"><?php _e('Sticky', 'jayla') ?></el-menu-item>
              </el-menu>
            </el-col>
            <el-col :span="18">
              <el-form v-if="Object.keys(header_edit).length > 0" :model="header_edit.settings" label-width="120px" label-position="left">
                <!-- Header Sticky -->
                <div class="" v-show="settings_tab == 'header_sticky'">
                  <el-form-item>
                    <label slot="label"><?php _e('Header Sticky', 'jayla') ?></label>
                    <el-switch v-model="header_edit.settings.header_sticky"></el-switch>
                    <div><i><?php _e('On/Off header sticky.', 'jayla'); ?></i></div>
                  </el-form-item>
                </div>
                <!-- Header Tablet / Mobile -->
                <div class="" v-show="settings_tab == 'header_tablet_mobile'">
                  <el-form-item>
                    <label slot="label"><?php _e('Header Tablet/Mobile show on width', 'jayla') ?></label>
                    <el-input-number v-model="header_edit.settings.header_tablet_mobile_transform_width" :min="1" :max="1920"></el-input-number>
                    <div><i><?php _e('Header Tablet/Mobile transform on width.', 'jayla'); ?> ({{ header_edit.settings.header_tablet_mobile_transform_width }}px)</i></div>
                  </el-form-item>
                </div>
                <!-- Header strip -->
                <div class="" v-show="settings_tab == 'header_strip'">
                  <el-form-item label="<?php _e('Header Strip', 'jayla') ?>">
                    <el-switch v-model="header_edit.settings.header_strip_display"></el-switch>
                    <div><i><?php _e('On/Off header strip, display above header bar.', 'jayla'); ?></i></div>
                  </el-form-item>

                  <el-form-item label="<?php _e('Content', 'jayla') ?>">
                    <el-select v-model="header_edit.settings.header_strip_content" placeholder="<?php esc_attr_e( 'please select your zone', 'jayla' ) ?>" popper-class="theme-extends-customize-zindex">
                      <el-option label="<?php _e('Full Width', 'jayla') ?>" value="fluid"></el-option>
                      <el-option label="<?php _e('Large', 'jayla') ?>" value="large"></el-option>
                      <el-option label="<?php _e('Medium', 'jayla') ?>" value="medium"></el-option>
                    </el-select>
                    <div><i><?php _e('Select options boxed or full-width content.', 'jayla'); ?></i></div>
                  </el-form-item>

                  <el-form-item label="<?php _e('Content', 'jayla') ?>">
                    <!-- <el-input type="textarea" v-model="header_edit.settings.header_strip_text"></el-input> -->
                    <div class="el-textarea">
                      <textarea 
                        type="textarea" 
                        autocomplete="off" 
                        validateevent="true" 
                        class="el-textarea__inner" 
                        style="min-height: 80px;" 
                        v-on:blur="update_data_on_blur($event, 'header_strip_text')">{{ header_edit.settings.header_strip_text }}</textarea>
                    </div>
                    <div><i><?php _e('Enter content header strip.', 'jayla'); ?></i></div>
                  </el-form-item>

                  <el-form-item label="<?php _e('Button', 'jayla') ?>">
                    <el-switch v-model="header_edit.settings.header_strip_button_display"></el-switch>
                    <div><i><?php _e('On/Off button redirect.', 'jayla'); ?></i></div>
                  </el-form-item>

                  <el-form-item label="<?php _e('Button Text', 'jayla') ?>">
                    <div class="el-input">
                      <input 
                        autocomplete="off" 
                        type="text" rows="2" 
                        validateevent="true" 
                        class="el-input__inner" 
                        :value="header_edit.settings.header_strip_button_text"
                        v-on:blur="update_data_on_blur($event, 'header_strip_button_text')">
                    </div>
                    <div><i><?php _e('Enter button text.', 'jayla'); ?></i></div>
                  </el-form-item>

                  <el-form-item label="<?php _e('Button Link', 'jayla') ?>">
                    <div class="el-input">
                      <input 
                        autocomplete="off" 
                        type="text" rows="2" 
                        validateevent="true" 
                        class="el-input__inner" 
                        :value="header_edit.settings.header_strip_link"
                        v-on:blur="update_data_on_blur($event, 'header_strip_link')">
                    </div>
                    <div><i><?php _e('Enter link redirect for button', 'jayla'); ?></i></div>
                  </el-form-item>

                  <el-form-item label="<?php _e('Button Close', 'jayla') ?>">
                    <el-switch v-model="header_edit.settings.header_strip_button_close_display"></el-switch>
                    <div><i><?php _e('On/Off button close header strip', 'jayla'); ?></i></div>
                  </el-form-item>
                </div>
              </el-form>
            </el-col>
          </el-row>
        </div>
      </el-tab-pane>

      <!-- Desktop -->
      <el-tab-pane name="desktop">
        <span slot="label"><label class="theme-extends-el-tab-pane-custom-label"><i class="fi flaticon-desktop"></i> <?php _e('Desktop', 'jayla'); ?></label></span>
        <div class="header-customize-layout-wrap">
          <div class="header-customize-builder-wrap">
            <customize-builder v-if="Object.keys(header_edit).length > 0" :data="header_edit.header_data"></customize-builder>
          </div>
          <br />
          <br />
        </div>
      </el-tab-pane>

      <!-- Tablet & Mobile -->
      <el-tab-pane name="tablet_mobile">
        <span slot="label"><label class="theme-extends-el-tab-pane-custom-label"><i class="fi flaticon-devices"></i> <?php _e('Tablet & Mobile', 'jayla'); ?></label></span>
        <div class="header-customize-layout-wrap">
          <div class="header-customize-builder-wrap">
            <customize-builder v-if="Object.keys(header_edit).length > 0" :data="header_edit.header_tablet_mobile_data"></customize-builder>
          </div>
          <br />
          <br />
        </div>
      </el-tab-pane>

      <!-- Sticky -->
      <el-tab-pane name="sticky">
        <span slot="label"><label class="theme-extends-el-tab-pane-custom-label"><i class="fi flaticon-bars"></i> <?php _e('Sticky', 'jayla'); ?></label></span>
        <div class="header-customize-layout-wrap">
          <div class="header-customize-builder-wrap">
            <customize-builder v-if="Object.keys(header_edit).length > 0" :data="header_edit.header_sticky_data"></customize-builder>
          </div>
          <br />
          <br />
        </div>
      </el-tab-pane>
    </el-tabs>

    <popup-edit-element></popup-edit-element>

    <div class="header-widget-wrap">
      <a class="widget-toggle" @click="toggle_class_open_widget"></a>
      <div class="widget-inner">
        <h2 class="title"><?php esc_attr_e('Widgets', 'jayla') ?></h2>
        <div class="theme-extends-widget-items" v-sortable-element="widget_sortable_data">
          <component v-for="(item, index) in root_store.widgets" :is="item.element" :item="item" :index="index" :show-description="true"></component>
        </div>
        <h2 class="title"><?php esc_attr_e('WP Widgets', 'jayla') ?></h2>
        <div class="theme-extends-widget-items wp-widget-items" v-sortable-element="widget_sortable_data">
          <component v-for="(item, index) in root_store.wp_widgets" :is="item.element" :item="item" :index="index" :show-description="true"></component>
        </div>
      </div>
    </div>

  </div>
</div>
