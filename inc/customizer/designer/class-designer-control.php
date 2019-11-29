<?php
/**
 * Class to create a Action Control.
 *
 */
class Jayla_Designer_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
		<div id="theme-extends-designer-action-control">
      <div style="text-align: right">
        <el-popover
					v-model="stylelist_visible"
          ref="stylelist"
          placement="bottom"
          title="<?php esc_attr_e('Select design element', 'jayla'); ?>"
          width="200"
          trigger="click"
          popper-class="theme-extends-popover-ui theme-extends-customize-zindex">
          <ul v-if="designer_store.elements.length > 0" class="theme-extends-element-design-items">
            <li v-for="(item, index) in designer_store.elements" class="element-design-item" @click="select_element_default_list(item.name, item.css_selector);">
              <div class="label">
                {{ item.name }}
                <el-tooltip v-if="item.help" placement="right" popper-class="theme-extends-customize-zindex">
                  <div slot="content" v-html="item.help"></div>
                  <i class="ion-help-circled"></i>
                </el-tooltip>
              </div>
              <div class="description" v-if="item.description">{{ description_element_item_text(item) }}</div>
            </li>
          </ul>
        </el-popover>
        <div class="theme-extends-add-style-area" v-popover:stylelist><i class="el-icon-plus"></i> <?php _e('Add a Style', 'jayla') ?></div>
				<button :class="['theme-extends-add-style-element-target', (element_target == true) ? 'enable-element-target' : '']" type="button" @click="add_design_target_element($event)"><i class="ion-android-locate"></i></button>
				<transition name="theme-extends-fade">
					<div v-if="element_target" class="theme-extends-message">
						<span class="ion-information-circled"></span>
						<?php _e('Select an editable element on your page to the right to adjust its properties.', 'jayla'); ?>
					</div>
				</transition>

				<transition name="theme-extends-fade">
					<div v-if="element_target_list.length > 0" class="theme-extends-margin theme-extends-selector-element-list-wrap">
						<p><?php _e('Select item for design!', 'jayla') ?></p>
						<a href="javascript:" class="btn-clear-selector-element" @click="element_target_list = []"><span class="ion-ios-close-empty"></span></a>
						<ul class="theme-extends-selector-element-list">
							<li v-for="item in element_target_list" @click="add_design_element(item.name, item.selector)">
								<i class="ion-ios-arrow-right"></i> <span>{{ item.name }}</span>
							</li>
						</ul>
					</div>
				</transition>
			</div>


      <!-- custom style list -->
      <div class="theme-extends-design-list">
        <ul v-if="designer_store.data.length > 0" class="theme-extends-design-items">
          <li v-for="(item, index) in designer_store.data" class="theme-extends-design-item" @click="edit_element(item)">
            <div class="title">{{ item.name }}</div>
            <i class="ion-ios-arrow-right"></i>
          </li>
        </ul>
      </div>

      <!-- panel settings -->
      <div id="theme-extends-design-panel" :class="design_panel_class">
        <div v-if="Object.keys(designer_store.data_edit).length > 0" class="design-panel-inner">
          <div class="heading">
            <div class="back-handle" @click="clear_edit()"><i class="ion-ios-arrow-left" title="<?php esc_attr_e('Back', 'jayla'); ?>"></i></div>
            <span>{{ designer_store.data_edit.name }}</span>
          </div>
          <div class="design-group">
						<design-group-fields v-for="(item, index) in designer_store.data_edit.group_style" :item="item" :index="index"></design-group-fields>
						<div class="add-group-style">
							<el-popover
								v-model="group_style_visible"
							  ref="popover-group-style"
							  placement="top"
							  width="200"
							  trigger="click"
								popper-class="theme-extends-popover-ui theme-extends-customize-zindex">
								<div class="theme-extends-design-group-style" v-if="designer_store.group_style.length > 0">
									<div class="theme-extends-design-group-style-item" v-for="(item, index) in designer_store.group_style" @click="add_block_style(item)" :index="index">
										<div class="title" v-if="item.name"><span v-if="item.icon" :class="['fi', item.icon]"></span> {{ item.name }}</div>
										<p class="description" v-if="item.description">{{ item.description }}</p>
									</div>
								</div>
							</el-popover>
							<div class="add-group-style-inner" v-popover:popover-group-style><span class="ion-plus-round"></span> <?php _e('Add Style', 'jayla'); ?></div>
						</div>
						<br />
						<a href="<?php echo esc_url( '#' ); ?>" class="reset-style" @click="remove_design_element($event)">Remove <strong>"{{ designer_store.data_edit.name }}"</strong> Style</a>
					</div>
        </div>
      </div>
    </div>
		<textarea hidden id="theme-extends-design-data-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('designer_settings'))); ?>><?php echo esc_textarea( $this->value('designer_settings') ); ?></textarea>
		<textarea hidden id="theme-extends-design-google-fonts-data-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('designer_google_fonts'))); ?>><?php echo esc_textarea( $this->value('designer_google_fonts') ); ?></textarea>
		<?php
	}
}
