<?php
/**
 * Class to create a Action Control.
 *
 */
class Jayla_Header_Builder_Control extends WP_Customize_Control {

	public function render_content() {
		?>
		<div id="theme-extends-header-action-control">
			<div class="theme-extends-customize-control-title"><?php _e( 'Header Customizer', 'jayla' ) ?></div>
			<div class="theme-extends-message">
				<span class="ion-information-circled"></span>
				<?php _e('The Header Customizer allows you to creative header layout with drag-drop the components.', 'jayla'); ?>
			</div>

			<div class="theme-extends-header-layouts theme-extends-margin">
				<el-row :gutter="10">
					<el-col class="theme-extends-margin" :span="24" v-if="root_store.layouts.length" v-for="(item, index) in root_store.layouts" :item="item" :index="index" :key="item.key">
						<div class="layout-content">
							<div
								@click="select_layout_handle($event, item)"
								:class="header_class_list(item)"
								>
								<div v-if="header_edit == item" class="editing-overlay">
									<span><?php _e('Editing...', 'jayla'); ?><span>
								</div>
    						<div class="title">{{ item.name }}</div>
								<customize-builder :data="item.header_data" mode="preview"></customize-builder>
							</div>
							<div class="actions">
								<div class="item-action edit-action" @click="edit_layout_handle($event, item)" title="<?php esc_attr_e('edit', 'jayla'); ?>"><span class="ion-gear-a"></span></div>
								<div v-if="(! item.lock || item.lock == false)" @click="remove_layout_handle($event, item, index)" class="item-action remove-action" title="<?php esc_attr_e('remove', 'jayla'); ?>"><span class="ion-android-delete"></span></div>
							</div>
						</div>
					</el-col>

					<!-- new header layout ui -->
					<el-col class="theme-extends-margin" :span="24">
						<div class="layout-content">
							<div class="add-header-layout" @click="new_layout_handle($event)">
								<div class="add-header-layout-inner">
									<span class="ion-plus-round"></span> <?php _e('New layout', 'jayla'); ?>
								</div>
							</div>
						</div>
					</el-col>
				</el-row>

				<div class="theme-extends-margin"></div>
			</div>
		</div>
		<textarea hidden id="theme-extends-header-builder-layout-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('header_layout'))); ?>><?php echo esc_textarea( $this->value('header_layout') ); ?></textarea>
		<textarea hidden id="theme-extends-header-builder-data-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('header_data'))); ?>><?php echo esc_textarea( $this->value('header_data') ); ?></textarea>
		<?php
	}
}
