<?php 

?>
<div id="admin-theme__setup">
    <el-tabs v-model="ThemeSetupActiveTab" class="__theme-setup-custom-tabs">
        <el-tab-pane name="requirements">
            <span slot="label" class="__tab-label"><?php _e('Theme Requirements', 'jayla') ?></span>
            <?php get_template_part( 'templates/admin/content', 'requirements' ) ?>
        </el-tab-pane>
        <el-tab-pane name="demo_import">
            <span slot="label" class="__tab-label"><?php _e('Demo & Install Package', 'jayla') ?></span>
            <?php get_template_part( 'templates/admin/content', 'import-demo' ) ?>
        </el-tab-pane>
        <el-tab-pane name="plugins_compatible">
            <span slot="label" class="__tab-label"><?php _e('Plugins Compatible', 'jayla') ?></span>
            <?php get_template_part( 'templates/admin/content', 'plugins-compatible' ) ?>
        </el-tab-pane>
        <el-tab-pane name="advanced_options">
            <span slot="label" class="__tab-label"><?php _e('Advanced Options', 'jayla') ?></span>
            <?php get_template_part( 'templates/admin/content', 'advanced-options' ) ?>
        </el-tab-pane>
    </el-tabs>
</div>