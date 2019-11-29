<?php
/**
 * Class to create a Action Control.
 *
 */
class Jayla_Blog_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
<div id="theme-extends-blog-action-control">
    <div class="theme-extends-message">
        <span class="ion-information-circled"></span>
        <?php _e('Options control blog archive & detail.', 'jayla'); ?>
    </div>

    <div class="theme-extends-margin">
        <!-- {{ root_store }} -->
        <el-form ref="form" :model="root_store.data" label-width="100px" label-position="left">
            <el-collapse class="theme-extends-collapse-custom-ui-customize-settings" accordion>
                <!-- Blog Archive -->
                <el-collapse-item name="archive">
                    <template slot="title">
                        <span class="fi flaticon-settings-2"></span> <?php _e('Blog Archive', 'jayla') ?>
                    </template>

                    <el-form-item class="theme-extends-margin" label="<?php _e('Layout', 'jayla'); ?>">
                        <el-select v-model="root_store.data.archive.layout" popper-class="theme-extends-customize-zindex">
                            <?php 
                                $blog_archive_layouts = jayla_blog_archive_layouts();
                                if( ! empty($blog_archive_layouts) ) {
                                    foreach( $blog_archive_layouts as $value => $data ) {
                                        echo '<el-option label="'. $data['label'] .'" value="'. $value .'"></el-option>';
                                    }
                                }
                            ?>
                        </el-select>
                    </el-form-item>

                    <hr class="theme-extends-margin" />

                    <el-form-item class="theme-extends-margin" label="<?php _e('Category filter bar', 'jayla'); ?>">
                        <el-switch
                            on-text="" off-text=""
                            on-value="yes" off-value="no"
                            v-model="root_store.data.archive.layout_grid_category_filter_bar"></el-switch>
                            <div style="line-height: normal"><small><?php _e('On/off category filter bar on top', 'jayla') ?></small></div>
                    </el-form-item>

                    <transition name="theme-extends-fade">
                        <div v-show="(root_store.data.archive.layout_grid_category_filter_bar == 'yes')">
                            <el-form-item class="theme-extends-margin" label="<?php _e('Filter style', 'jayla'); ?>">
                                <el-select v-model="root_store.data.archive.layout_grid_category_filter_bar_style" popper-class="theme-extends-customize-zindex">
                                    <el-option label="<?php _e('Inline', 'jayla') ?>" value="inline"></el-option>
                                    <el-option label="<?php _e('Select', 'jayla') ?>" value="select"></el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                    </transition>

                    <transition name="theme-extends-fade">
                        <div v-show="(root_store.data.archive.layout == 'grid')">

                            <hr class="theme-extends-margin" />

                            <el-form-item label="<?php _e('Columns', 'jayla') ?>">
                                <el-input-number v-model="root_store.data.archive.layout_grid_col" :min="1" :max="6" size="small"></el-input-number>
                                <div style="line-height: normal"><small><?php _e('Grid column on desktop', 'jayla') ?></small></div>
                            </el-form-item>

                            <el-form-item label="<?php _e('Columns tablet', 'jayla') ?>">
                                <el-input-number v-model="root_store.data.archive.layout_grid_col_tablet" :min="1" :max="6" size="small"></el-input-number>
                                <div style="line-height: normal"><small><?php _e('Responsive grid column on tablet', 'jayla') ?></small></div>
                            </el-form-item>

                            <el-form-item label="<?php _e('Columns mobile', 'jayla') ?>">
                                <el-input-number v-model="root_store.data.archive.layout_grid_col_mobile" :min="1" :max="6" size="small"></el-input-number>
                                <div style="line-height: normal"><small><?php _e('Responsive grid column on mobile', 'jayla') ?></small></div>
                            </el-form-item>
                        </div>
                    </transition>
                </el-collapse-item>

                <!-- Blog Detail -->
                <el-collapse-item name="defail">
                    <template slot="title">
                        <span class="fi flaticon-settings-2"></span> <?php _e('Blog Detail', 'jayla') ?>
                    </template>

                    <el-form-item class="theme-extends-margin" label="<?php _e('Layout', 'jayla'); ?>">
                        <el-select v-model="root_store.data.detail.layout" popper-class="theme-extends-customize-zindex">
                            <?php 
                                $blog_single_layouts = jayla_blog_single_layouts();
                                if( ! empty($blog_single_layouts) ) {
                                    foreach( $blog_single_layouts as $value => $data ) {
                                        echo '<el-option label="'. $data['label'] .'" value="'. $value .'"></el-option>';
                                    }
                                }
                            ?>
                        </el-select>
                    </el-form-item>

                    <el-form-item class="theme-extends-margin" label="<?php _e('Post Headings', 'jayla'); ?>">
                        <el-switch
                            on-text="" off-text=""
                            on-value="yes" off-value="no"
                            v-model="root_store.data.detail.post_headings"></el-switch>
                        <div style="line-height: normal"><small><?php _e('On/off post headings', 'jayla') ?></small></div>
                    </el-form-item>

                    <el-form-item class="theme-extends-margin" label="<?php _e('Navigation', 'jayla'); ?>">
                        <el-switch
                            on-text="" off-text=""
                            on-value="yes" off-value="no"
                            v-model="root_store.data.detail.navigation"></el-switch>
                        <div style="line-height: normal"><small><?php _e('On/off navigation older & newer', 'jayla') ?></small></div>
                    </el-form-item>

                    <el-form-item class="theme-extends-margin" label="<?php _e('Post related', 'jayla'); ?>">
                        <el-switch
                            on-text="" off-text=""
                            on-value="yes" off-value="no"
                            v-model="root_store.data.detail.post_related"></el-switch>
                        <div style="line-height: normal"><small><?php _e('On/off post related', 'jayla') ?></small></div>
                    </el-form-item>

                    <transition name="theme-extends-fade">
                        <div v-show="(root_store.data.detail.post_related == 'yes')">
                            <el-form-item class="theme-extends-margin" label="<?php _e('Post related image placeholder', 'jayla'); ?>">
                                <el-switch
                                    on-text="" off-text=""
                                    on-value="yes" off-value="no"
                                    v-model="root_store.data.detail.post_related_image_placeholder"></el-switch>
                                <div style="line-height: normal"><small><?php _e('On/off post related image placeholder', 'jayla') ?></small></div>
                            </el-form-item>
                            
                            <el-form-item label="<?php _e('Post related limit', 'jayla') ?>">
                                <el-input-number v-model="root_store.data.detail.post_related_limit" :min="1" :max="6" size="small"></el-input-number>
                                <div style="line-height: normal"><small><?php _e('Post related limit (min => 1 | max => 6)', 'jayla') ?></small></div>
                            </el-form-item>
                        </div>
                    </transition>
                </el-collapse-item>
            </el-collapse>
        </el-form>
    </div>
</div>
<textarea hidden id="theme-extends-blog-settings-field" class="theme-extends-margin" <?php echo implode('', array($this->get_link('blog_settings'))); ?>>
    <?php echo esc_textarea( $this->value('blog_settings') ); ?>
</textarea>
		<?php
	}
}
