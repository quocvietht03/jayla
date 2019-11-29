<?php 
/**
 * @since 1.0.2
 *  
 */
?>
<div class="__themeextends-advanced-options">
    <div :class="ClassesWrapAdvancedOptions">
        <el-form ref="advanced-options-form" :model="ThemeAdvancedOptions">
            <el-row :gutter="20">
                <el-col :lg="8" :sm="12">
                    <div class="__block-options">
                        <div class="heading-option">
                            <?php _e( 'Custom content types (Since v1.0.2)', 'jayla' ); ?> 
                        </div>
                        <div class="container-options">
                            <div class="__opts-group">
                                <p><?php _e( 'Add team to your website. Load custom post type "Team" and more options if combined with jetpack portfolio.', 'jayla' ) ?></p>
                                <div class="__field-item">
                                    <el-switch v-model="ThemeAdvancedOptions.load_custom_post_type_team" on-text="" off-text="" on-value="yes" off-value="no"></el-switch>
                                    <label style="margin-left: 10px;"><?php _e( 'On / Off Post Teams', 'jayla' ); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </el-form>
    </div>
</div>