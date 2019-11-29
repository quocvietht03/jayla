<?php
/**
 * Class to create a Action Control.
 *
 */
class Jayla_Heading_Bar_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
		<div id="theme-extends-heading-bar-action-control">
      <div class="theme-extends-message">
        <span class="ion-information-circled"></span>
        <?php _e('Options control page title & breadcrumb.', 'jayla'); ?>
      </div>

      <div class="theme-extends-margin">
        <el-form ref="formHeadingBar" :model="headingBarStore.data" label-width="100px" label-position="left">
          <el-form-item label="<?php _e('Heading Bar', 'jayla'); ?>">
            <el-switch
            	v-model="headingBarStore.data.jayla_heading_bar_display"
							on-text="" off-text=""
            	on-value="true"
  						off-value="false"></el-switch>
            <div style="line-height: normal;"><small><?php _e('show/hide heading bar.', 'jayla') ?></small></div>
          </el-form-item>

          <hr />

          <transition name="theme-extends-fade">
            <div v-show="(headingBarStore.data.jayla_heading_bar_display == 'true')">
              <el-form-item label="<?php _e('Title Page', 'jayla'); ?>">
                <el-switch
                	v-model="headingBarStore.data.jayla_heading_bar_page_title_display"
									on-text="" off-text=""
		            	on-value="true"
									off-value="false"></el-switch>
                <div style="line-height: normal;"><small><?php _e('show/hide title Page.', 'jayla') ?></small></div>
              </el-form-item>

              <el-form-item label="<?php _e('Breadcrumb', 'jayla'); ?>">
                <el-switch
                	v-model="headingBarStore.data.jayla_heading_bar_breadcrumb_display"
									on-text="" off-text=""
		            	on-value="true"
									off-value="false"></el-switch>
                <div style="line-height: normal;"><small><?php _e('show/hide breadcrumb.', 'jayla') ?></small></div>
              </el-form-item>

              <hr />

							<el-form-item label="<?php _e('Content Alignment', 'jayla'); ?>">
                <el-radio-group v-model="headingBarStore.data.jayla_heading_bar_content_align" size="small">
                  <el-radio-button label="text-left"><?php _e('Left', 'jayla'); ?></el-radio-button>
									<el-radio-button label="text-center"><?php _e('Center', 'jayla'); ?></el-radio-button>
                  <el-radio-button label="text-right"><?php _e('Right', 'jayla'); ?></el-radio-button>
                </el-radio-group>
                <div style="line-height: normal;"><small><?php _e('choose content alignment.', 'jayla') ?></small></div>
              </el-form-item>

              <hr />

              <el-form-item label="<?php _e('Background Type', 'jayla'); ?>">
                <el-radio-group v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_type" size="small">
                  <el-radio-button label="color"><?php _e('Color', 'jayla'); ?></el-radio-button>
                  <el-radio-button label="image"><?php _e('Image', 'jayla'); ?></el-radio-button>
                  <el-radio-button label="video"><?php _e('Video', 'jayla'); ?></el-radio-button>
                </el-radio-group>
                <div style="line-height: normal;"><small><?php _e('choose background type.', 'jayla') ?></small></div>
              </el-form-item>

              <!-- background color -->
              <div v-show="headingBarStore.data.jayla_heading_bar_background_settings.background_type == 'color'">
                <el-form-item label="<?php _e('Gradient', 'jayla'); ?>">
                  <el-switch
                  	v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_gradient"
										on-text="" off-text=""
			            	on-value="true"
										off-value="false"></el-switch>
                  <div style="line-height: normal;"><small><?php _e('on/off background gradient.', 'jayla') ?></small></div>
                </el-form-item>

                <el-form-item label="<?php _e('Color', 'jayla'); ?>">
                  <!-- <el-color-picker v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_color"></el-color-picker> -->
                  <bears-color-picker-field v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_color" />
                  <div style="line-height: normal;"><small><?php _e('choose color.', 'jayla') ?></small></div>
                </el-form-item>

                <el-form-item v-show="headingBarStore.data.jayla_heading_bar_background_settings.background_gradient == 'true'" label="<?php _e('Color 2', 'jayla'); ?>">
                  <!-- <el-color-picker v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_color2"></el-color-picker> -->
                  <bears-color-picker-field v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_color2" />
                  <div style="line-height: normal;"><small><?php _e('choose color 2.', 'jayla') ?></small></div>
                </el-form-item>
              </div>

              <!-- background image -->
              <div v-show="headingBarStore.data.jayla_heading_bar_background_settings.background_type == 'image'">
                <wp-media-field :params="wp_media_field_params" name="background_image" :data-map="headingBarStore.data.jayla_heading_bar_background_settings"></wp-media-field>

                <el-form-item label="<?php _e('Size', 'jayla'); ?>">
                  <el-select v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_size" placeholder="<?php esc_attr_e('bg size', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
                    <el-option
                      v-for="s_item in bg_image_size"
                      :key="s_item.value"
                      :label="s_item.label"
                      :value="s_item.value">
                    </el-option>
                  </el-select>
                </el-form-item>

                <el-form-item label="<?php _e('Position', 'jayla'); ?>">
                  <el-select v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_position" placeholder="<?php esc_attr_e('bg position', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
                    <el-option
                      v-for="p_item in bg_image_position"
                      :key="p_item.value"
                      :label="p_item.label"
                      :value="p_item.value">
                    </el-option>
                  </el-select>
                </el-form-item>

                <el-form-item label="<?php _e('Repeat', 'jayla'); ?>">
                  <el-select v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_repeat" placeholder="<?php esc_attr_e('bg repeat', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
                    <el-option
                      v-for="r_item in bg_image_repeat"
                      :key="r_item.value"
                      :label="r_item.label"
                      :value="r_item.value">
                    </el-option>
                  </el-select>
                </el-form-item>

                <el-form-item label="<?php _e('Attachment', 'jayla'); ?>">
                  <el-select v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_attachment" placeholder="<?php esc_attr_e('bg attachment', 'jayla'); ?>" popper-class="theme-extends-customize-zindex">
                    <el-option
                      v-for="a_item in bg_image_attachment"
                      :key="a_item.value"
                      :label="a_item.label"
                      :value="a_item.value">
                    </el-option>
                  </el-select>
                </el-form-item>

								<el-form-item label="<?php _e('Parallax Effect', 'jayla'); ?>">
									<el-switch
                  	v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_image_parallax"
										on-text="" off-text=""
			            	on-value="true"
										off-value="false"></el-switch>
									<div style="line-height: normal;"><small><?php _e('on/off background parallax effect.', 'jayla'); ?></small></div>
								</el-form-item>
              </div>

							<!-- background video -->
              <div v-show="headingBarStore.data.jayla_heading_bar_background_settings.background_type == 'video'">
								<el-form-item label="<?php esc_attr_e('Video Url', 'jayla'); ?>">
									<el-input placeholder="<?php esc_attr_e( 'https://vimeo.com/110138539', 'jayla' ) ?>" v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_video_url"></el-input>
								</el-form-item>
								<div class="theme-extends-message">
					        <span class="ion-information-circled"></span>
									<?php echo sprintf(
										'%1$s <el-tooltip content="%4$s" placement="top" popper-class="theme-extends-customize-zindex"><u>Youtube</u></el-tooltip> %2$s <el-tooltip content="%5$s" placement="top" popper-class="theme-extends-customize-zindex"><u>Vimeo</u></el-tooltip> %3$s',
										__('Use video url', 'jayla'),
										__('or', 'jayla'),
										__('for background and parallax effect auto enable.', 'jayla'),
										__('https://www.youtube.com/watch?v=ab0TSkLe-E0', 'jayla'),
										__('https://vimeo.com/110138539', 'jayla')); ?>
					      </div>
								<br />
							</div>

							<hr />

							<el-form-item label="<?php _e('Background Overlay', 'jayla'); ?>">
								<el-switch
									v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_overlay_color_display"
									on-text="" off-text=""
		            	on-value="true"
									off-value="false"></el-switch>
								<div style="line-height: normal;"><small><?php _e('on/off background overlay color.', 'jayla') ?></small></div>
							</el-form-item>

							<el-form-item v-show="headingBarStore.data.jayla_heading_bar_background_settings.background_overlay_color_display == 'true'" label="<?php _e('Overlay Color', 'jayla'); ?>">
								<!-- <el-color-picker v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_overlay_color" show-alpha></el-color-picker> -->
                <bears-color-picker-field v-model="headingBarStore.data.jayla_heading_bar_background_settings.background_overlay_color" />
                <div style="line-height: normal;"><small><?php _e('choose background overlay color.', 'jayla') ?></small></div>
							</el-form-item>
            </div>
          </transition>
        </el-form>
      </div>
    </div>
		<input type="hidden" id="theme-extends-heading-bar-title-bar-display-data-field" <?php echo implode('', array($this->get_link('title_bar_display'))); ?> value="<?php echo esc_attr($this->value('title_bar_display')); ?>">
		<input type="hidden" id="theme-extends-heading-bar-page-title-display-data-field" <?php echo implode('', array($this->get_link('page_title_display'))); ?> value="<?php echo esc_attr($this->value('page_title_display')); ?>">
		<input type="hidden" id="theme-extends-heading-bar-breadcrumb-display-data-field" <?php echo implode('', array($this->get_link('breadcrumb_display'))); ?> value="<?php echo esc_attr($this->value('breadcrumb_display')); ?>">
		<input type="hidden" id="theme-extends-heading-bar-content-align-data-field" <?php echo implode('', array($this->get_link('content_align'))); ?> value="<?php echo esc_attr($this->value('content_align')); ?>">
		<textarea hidden id="theme-extends-heading-bar-background-setings-data-field" <?php echo implode('', array($this->get_link('background_setings'))); ?>><?php echo esc_textarea( $this->value('background_setings') ); ?></textarea>
		<?php
	}
}