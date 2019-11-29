<?php
/**
 * Class to create a Action Control.
 *
 */
class Jayla_Global_Control extends WP_Customize_Control {

	public function render_content() {
		$url_image_core = get_template_directory_uri() . '/assets/images/core/';

		?>
		<div id="theme-extends-global-action-control">
			<el-form ref="form" :model="data" label-width="120px" label-position="left">
				<el-collapse class="theme-extends-collapse-custom-ui-customize-settings" accordion>
					<!-- layout -->
				  <el-collapse-item name="layout">
				    <template slot="title">
				      <span class="fi flaticon-blog-template"></span> <?php _e('Layout', 'jayla') ?>
				    </template>

						<el-form-item class="theme-extends-margin" label="<?php _e('Container Width', 'jayla') ?>">
		          <el-select v-model="data.layout.container_width" placeholder="<?php esc_attr_e('Select', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
		            <el-option label="<?php esc_attr_e('Full Width', 'jayla'); ?>" value="fluid"></el-option>
		            <el-option label="<?php esc_attr_e('Large', 'jayla'); ?>" value="large"></el-option>
		            <el-option label="<?php esc_attr_e('Medium', 'jayla'); ?>" value="medium"></el-option>
							</el-select>
							<div style="line-height: normal;"><small><?php _e('Select container width (Full width / Large / Medium).', 'jayla'); ?></small></div>
		        </el-form-item>

						<el-form-item v-show="data.layout.container_width == 'large'" class="theme-extends-margin" label="<?php _e('Custom Width Container Large', 'jayla') ?>">
							<el-input-number v-model="data.layout.custom_width_container_large" :min="900" :max="2400"></el-input-number>
							<div style="line-height: normal;"><small><?php _e('Enter custom width container larges (ex: 1230).', 'jayla'); ?></small></div>
		        </el-form-item>

		        <hr class="theme-extends-margin" />

						<div class="theme-extends-radio-group-image-style">
							<p><?php _e('Select Layout', 'jayla') ?></p>
							<el-radio-group v-model="data.layout.layout">
			          <el-radio :label="'default'">
			            <el-tooltip placement="top" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('Default', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'layout-default.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			          <el-radio :label="'nav-left'">
			            <el-tooltip placement="top" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('Nav left', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'layout-nav-left.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			          <el-radio :label="'nav-right'">
			            <el-tooltip placement="top" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('Nav right', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'layout-nav-right.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			        </el-radio-group>
						</div>

				  </el-collapse-item>

					<!-- sidebar -->
				  <el-collapse-item name="sidebar">
						<template slot="title">
				      <span class="fi flaticon-bars"></span> <?php _e('Sidebar', 'jayla') ?>
				    </template>

						<div class="theme-extends-margin theme-extends-radio-group-image-style">
			        <p><?php _e('Select Layout Sidebar', 'jayla') ?></p>
			        <el-radio-group v-model="data.sidebar.layout">
			          <el-radio :label="'left-sidebar'">
			            <el-tooltip placement="top" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('Left sidebar', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'left-sidebar.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			          <el-radio :label="'right-sidebar'">
			            <el-tooltip placement="top" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('Right sidebar', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'right-sidebar.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			          <el-radio :label="'no-sidebar'">
			            <el-tooltip placement="top" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('No sidebar', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'no-sidebar.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			        </el-radio-group>
			      </div>

						<div class="theme-extends-margin" v-show="['left-sidebar', 'right-sidebar'].indexOf(data.sidebar.layout) >= 0">
							<hr class="theme-extends-margin"/>

							<el-form-item label="<?php _e('Sticky', 'jayla'); ?>" class="theme-extends-margin">
				        <el-switch
				          on-value="yes" off-value="no"
				          on-text="" off-text=""
									v-model="data.sidebar.sticky"></el-switch>
									<div style="line-height: normal;"><small><?php _e('On/Off sidebar sticky.', 'jayla'); ?></small></div>
				      </el-form-item>
						</div>

				  </el-collapse-item>

					<!-- pagination -->
				  <el-collapse-item name="pagination">
						<template slot="title">
				      <span class="fi flaticon-menu-2"></span> <?php _e('Pagination', 'jayla') ?>
				    </template>

						<div class="theme-extends-margin theme-extends-radio-group-image-style-inline">
			        <p><?php _e('Pagination Layout', 'jayla') ?></p>
			        <el-radio-group v-model="data.pagination.layout">
			          <el-radio :label="'default'">
			            <el-tooltip placement="right" popper-class="theme-extends-customize-zindex">
			              <div slot="content"><?php _e('Default', 'jayla'); ?></div>
			              <img src="<?php echo implode('', array($url_image_core, 'pagination-default.jpg')) ?>" alt="<?php esc_attr_e('layout default', 'jayla') ?>"/>
			            </el-tooltip>
			          </el-radio>
			        </el-radio-group>
			      </div>
				  </el-collapse-item>

					<!-- Scroll Top & Page loading -->
				  <el-collapse-item name="scroll-top">
						<template slot="title">
				      <span class="fi flaticon-upload-rounded-symbol"></span> <?php _e('Scroll Top & Page Loading', 'jayla') ?>
				    </template>

						<el-form-item label="<?php _e('Scroll-Top', 'jayla'); ?>" class="theme-extends-margin">
			        <el-switch
			          on-value="yes" off-value="no"
			          on-text="" off-text=""
								v-model="data.scroll_top.show"></el-switch>
								<div style="line-height: normal;"><small><?php _e('On/Off scroll-top.', 'jayla'); ?></small></div>
			      </el-form-item>

						<hr class="theme-extends-margin" />

						<el-form-item label="<?php _e('Loading Top Bar', 'jayla'); ?>" class="theme-extends-margin">
			        <el-switch
			          on-value="yes" off-value="no"
			          on-text="" off-text=""
								v-model="data.loading_top_bar.show"></el-switch>
								<div style="line-height: normal;"><small><?php _e('On/Off loading top bar.', 'jayla'); ?></small></div>
			      </el-form-item>

						<el-form-item label="<?php _e('Color', 'jayla'); ?>" class="theme-extends-margin">
							<el-color-picker v-model="data.loading_top_bar.color"></el-color-picker>
							<div style="line-height: normal;"><small><?php _e('Select loading top bar color.', 'jayla'); ?></small></div>
			      </el-form-item>
				  </el-collapse-item>
				</el-collapse>
			</el-form>
    </div>
		<textarea hidden id="theme-extends-global-settings-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('global_settings'))); ?>>
	    <?php echo esc_textarea( $this->value('global_settings') ); ?>
	  </textarea>
		<?php
	}
}
