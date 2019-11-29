<?php

?>
<div id="theme-extends-footer-configurator" class="theme-extends-panel">

  <div :class="footer_panel_inner_classes">
    <div v-show="!has_edit" class="clear-footer-edit" @click="clear_footer_edit">
      <span class="ion-close-round"></span> <?php _e('Close', 'jayla'); ?>
    </div>

    <div v-show="has_edit" class="apply-footer-edit" @click="update_footer_edit">
      <span class="ion-checkmark-circled"></span> <?php _e('Update & Close', 'jayla'); ?>
    </div>

    <div class="theme-extends-message" style="background: #eee; box-shadow: none;">
      <span class="ion-information-circled"></span>
      <?php _e('Allow creating layout footer easy, start with new row & columns, use components on the left sidebar by drag and drop.', 'jayla'); ?>
    </div>

    <div class="footer-field-name-wrap">
      <input class="footer-field-name-input" type="text" v-model="footer_edit.name" placeholder="<?php esc_attr_e('Input footer layout name', 'jayla') ?>"/>
    </div>

    <strong class="theme-extends-margin"><?php echo sprintf(
      '%s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">New ticksy</a>', 
      __('You can view the tutorial settings footer at', 'jayla'), 
      esc_url( 'https://jayla.wordpress.com/' ),
      __('here', 'jayla'), 
      __('and don\'t hesitate to contact us if you need help', 'jayla'),
      esc_url( 'https://bearsthemes.ticksy.com/' )) ?>
    </strong>

    <div class="footer-customize-layout-wrap theme-extends-margin">
      <div class="footer-customize-builder-wrap">
        <customize-builder v-if="Object.keys(footer_edit).length > 0" :data="footer_edit.footer_data"></customize-builder>
      </div>
    </div>

    <popup-edit-element></popup-edit-element>

    <div class="footer-widget-wrap">
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
