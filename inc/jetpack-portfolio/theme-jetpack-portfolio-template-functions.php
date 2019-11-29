<?php
if(! function_exists('jayla_portfolio_archive_layout_path_filter')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_portfolio_archive_layout_path_filter($layout_path) {
        $post_type = get_post_type();
        if ( $post_type  == 'jetpack-portfolio' && is_archive() ) {
            $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
            $layouts_data = jayla_jetpack_portfolio_archive_layout();
            $layout_path = $layouts_data[$settings['archive_layout']]['path_template'];
        }

        return $layout_path;
    }
}

if(! function_exists('jayla_portfolio_single_layout_path_filter')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_portfolio_single_layout_path_filter($layout_path) {
        global $post;
        $post_type = get_post_type();

        if ( $post_type  == 'jetpack-portfolio' && is_single() ) {
            $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
            $layouts_data = jayla_jetpack_portfolio_single_layout();
            $path_template = $layouts_data[$settings['single_layout']]['path_template'];

            // custom layout metabox options
            $metabox_data = jayla_get_custom_metabox($post->ID);
            if( isset( $metabox_data['custom_jetpack_portfolio_single'] ) && $metabox_data['custom_jetpack_portfolio_single'] == 'yes' ) {
                $path_template = $layouts_data[$metabox_data['jetpack_portfolio_single_settings']['single_layout']]['path_template'];
            }

            $layout_path = $path_template;
        }

        return $layout_path;
    }
}

if(! function_exists('jayla_jetpack_portfolio_archive_entry_content')) {
    /**
     * @since 1.0.0
     */
    function jayla_jetpack_portfolio_archive_entry_content() {
        global $post;
        $jetpack_portfolio_type_html = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type' );
        ?>
        <div class="p-thumbnail-entry">
            <?php do_action( 'jayla_jetpack_portfolio_archive_entry_content_thumbnail_before' ) ?>
            <a href="<?php the_permalink(); ?>" class="p-thumbnail-wrap" title="<?php the_title_attribute(); ?>">
            <?php
            if( has_post_thumbnail($post) ) {
                $featured_image_large_src = get_the_post_thumbnail_url( $post, 'large' );
                echo get_the_post_thumbnail( $post, 'medium', array(
                    'data-themeextends-lazyload-url' => $featured_image_large_src,
                ) );
            } else {
                echo '<img class="placeholder-thumb wp-post-image" src="'. get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg' .'" alt="'. esc_attr( the_title_attribute( 'echo=0' ) ) .'">';
            }
            ?>
            </a>
            <?php
                /**
                 * Hook jayla_jetpack_portfolio_archive_entry_content_thumbnail_after
                 *
                 * @see jayla_jetpack_portfolio_added_like_button - 20
                 */
                do_action( 'jayla_jetpack_portfolio_archive_entry_content_thumbnail_after' );
            ?>
        </div>
        <div class="p-entry">
            <div class="p-entry-meta">
                <?php if( false != $jetpack_portfolio_type_html ) { ?>
                <div class="p-entry-cat">
                    <?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ' ); ?>
                </div>
                <?php } ?>
            </div>
            <a class="p-title-link" href="<?php the_permalink(); ?>">
                <h4 class="p-title"><?php the_title(); ?></h4>
            </a>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_archive_add_furygrid_open')) {
    /**
     * @since 1.0.0
     */
    function jayla_jetpack_portfolio_archive_add_furygrid_open() {
        $post_type = get_post_type();
        if( 'jetpack-portfolio' != $post_type ) return;

        $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
        $layouts_allow_furygrid = jayla_jetpack_portfolio_archive_layout_allow_furygrid();

        if( ! in_array( $settings['archive_layout'],  $layouts_allow_furygrid ) ) { return; }

        $grid_columns = apply_filters( 'jayla_jetpack_portfolio_layout_furygrid_opts_filter', array(
            'space' => 36,
			'desktop' => (int) $settings['grid_columns'],
			'tablet' => (int) $settings['grid_columns_on_tablet'],
			'mobile' => (int) $settings['grid_columns_on_mobile'],
        ), $settings );

        $grid_opts = json_encode(array(
            'Col' => $grid_columns['desktop'],
            'Space' => $grid_columns['space'],
            'Responsive' => array(
                989 => array(
                    'Col' => $grid_columns['tablet'],
                ),
                460 => array(
                    'Col' => $grid_columns['mobile'],
                )
            )
        ));
        ?>
        <div class="post-grid-container" data-theme-furygrid-options='<?php echo esc_attr($grid_opts); ?>'>
				<div class="furygrid-sizer"></div>
				<div class="furygrid-gutter-sizer"></div>
        <?php
    }
}
if(! function_exists('jayla_jetpack_portfolio_archive_add_furygrid_close')) {
    /**
     * @since 1.0.0
     */
    function jayla_jetpack_portfolio_archive_add_furygrid_close() {
        $post_type = get_post_type();
        if( 'jetpack-portfolio' != $post_type ) return;

        $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
        $layouts_allow_furygrid = jayla_jetpack_portfolio_archive_layout_allow_furygrid();

        if( ! in_array( $settings['archive_layout'],  $layouts_allow_furygrid ) ) { return; }

        ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_term_list_html')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_term_list_html() {
        return get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<div class="p-term-list-types"><span>'. __('Project types:', 'jayla') .'</span> ', __(', ', 'jayla'), '</div>' );
    }
}

if(! function_exists('jayla_jetpack_portfolio_info_item_client')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_info_item_client() {
        $client_data = array(
            'name' => carbon_get_post_meta( get_the_ID(), 'project_client_name' ),
            'brand' => carbon_get_post_meta( get_the_ID(), 'project_client_brand' ),
            'website' => carbon_get_post_meta( get_the_ID(), 'project_client_website' ),
        );
        ?>
        <li class="i-item i-client">
            <div class="i-label"><?php _e('Client', 'jayla'); ?></div>
            <div class="i-entry"> <?php echo ! empty( $client_data['name'] ) ? $client_data['name'] : 'N/A'; ?></div>
        </li>
        <li class="i-item i-client-website">
            <div class="i-label"><?php _e('Website', 'jayla'); ?></div>
            <div class="i-entry"><?php echo ! empty( $client_data['website'] ) ? '<a href="'. esc_url( $client_data['website'] ) .'" target="_blank">'. $client_data['website'] .'</a>' : 'N/A'; ?></div>
        </li>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_info_date_work')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_info_date_work() {
        $date_work_data = array(
            'start' => carbon_get_post_meta( get_the_ID(), 'project_start_date' ),
            'end' => carbon_get_post_meta( get_the_ID(), 'project_end_date' ),
        );
        ?>
        <li class="i-item i-date-work">
            <div class="i-label"><?php _e('Date', 'jayla'); ?></div>
            <div class="i-entry">
                <?php if( ! empty( $date_work_data['start'] ) || ! empty( $date_work_data['end'] ) ) {
                    echo ! empty( $date_work_data['start'] ) ? "<span class='d-start' data-toggle='tooltip' data-placement='top' title='". esc_attr__('Start date', 'jayla') ."'>{$date_work_data['start']}</span>" : '';
                    echo ! empty( $date_work_data['end'] ) ? ' — ' . "<span class='d-end' data-toggle='tooltip' data-placement='top' title='". esc_attr__('End date', 'jayla') ."'>{$date_work_data['end']}</span>" : '';
                } else {
                    echo 'N/A';
                } ?>
            </div>
        </li>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_info_tags')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_info_tags() {
        $tags_list_html = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '<div class="p-tags-list-types">', __(', ', 'jayla'), '</div>' );
        if( false == $tags_list_html ) return;
        ?>
        <li class="i-item i-tags">
            <div class="i-label"><?php _e('Tags', 'jayla'); ?></div>
            <div class="i-entry">
                <?php echo "{$tags_list_html}"; ?>
            </div>
        </li>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_info_html')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_info_html($echo = true) {
        ob_start();
        ?>
        <div class="p-jetpack-project-infomation">
            <div class="p-heading-text"><?php _e('Information', 'jayla'); ?></div>
            <ul class="infomation-entry">
                <?php
                    /**
                     * Hooks jayla_jetpack_portfolio_info_item
                     *
                     * @see jayla_jetpack_portfolio_info_item_client - 10
                     * @see jayla_jetpack_portfolio_info_date_work - 15
                     * @see jayla_jetpack_portfolio_info_tags - 18
                     */
                    do_action( 'jayla_jetpack_portfolio_info_item' )
                ?>
            </li>
        </div>
        <?php
        $output = ob_get_clean();

        if( true == $echo ) echo "{$output}";
        else return $output;
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_entry_content')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_single_entry_content() {
        ?>
        <div class="p-entry-content">
            <div class="__inner">
                <?php do_action('jayla_jetpack_portfolio_single_before_entry_content') ?>
                <div class="portfolio-main-entry">
                    <h4 class="p-title"><?php the_title(); ?></h4>
                    <?php echo jayla_jetpack_portfolio_term_list_html(); ?>

                    <div class="p-content">
                        <?php the_content(); ?>
                    </div>
                </div>

                <?php jayla_jetpack_portfolio_info_html(); ?>

                <?php do_action('jayla_jetpack_portfolio_single_after_entry_content') ?>
            </div>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_entry_section_type_single_image')) {
    function jayla_jetpack_portfolio_single_entry_section_type_single_image($data) {
        // print_r($data);
        $image_id = $data['image'];
        if( empty($image_id) || false == wp_get_attachment_image_src($image_id) ) return;
        $image_full_data = wp_get_attachment_image_src($image_id, 'full');
        ?>
        <div class="jetpack-portfolio-single-section-entry section-entry-type-<?php echo esc_attr( $data['type'] ) ?>">
            <?php
            echo wp_get_attachment_image( $image_id, 'medium', false, array(
                'data-themeextends-lazyload-url' => $image_full_data[0],
                'data-themeextends-mediumzoom' => 1,
            ) );

            echo ( ! empty($data['caption']) ) ? '<div class="__caption">'. do_shortcode( $data['caption'] ) .'</div>' : '';
            ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_entry_section_type_text_block')) {
    /**
     * @since 1.0.0
     */
    function jayla_jetpack_portfolio_single_entry_section_type_text_block($data) {
        ?>
        <div class="jetpack-portfolio-single-section-entry section-entry-type-<?php echo esc_attr( $data['type'] ) ?>">
            <?php
            echo do_shortcode( $data['text_content'] );
            ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_entry_section_type_image_gallery_grid')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_single_entry_section_type_image_gallery_grid($data) {
        $image_gallery_data = $data['image_gallery'];
        if( empty($image_gallery_data) || count($image_gallery_data) <= 0 ) return;

        $gird_opts = wp_json_encode( array(
            'Col' => (int) $data['grid_columns'],
            'Space' => 20,
        ) );
        ?>
        <div class="jetpack-portfolio-single-section-entry section-entry-type-<?php echo esc_attr( $data['type'] ) ?>">
            <div class="grid-container" data-theme-furygrid-options='<?php echo esc_attr($gird_opts); ?>'>
                <div class="furygrid-sizer"></div>
                <div class="furygrid-gutter-sizer"></div>
                <?php foreach( $image_gallery_data as $image_id ) {
                    $image_full_data = wp_get_attachment_image_src($image_id, 'full');
                    if( empty($image_full_data) ) continue;

                    $image_html = wp_get_attachment_image( $image_id, 'medium', false, array(
                        'data-themeextends-lazyload-url' => $image_full_data[0],
                        'data-themeextends-mediumzoom' => 1,
                    ) );

                    echo '<div class="furygrid-item">'. $image_html .'</div>';
                } ?>
            </div>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_entry_section_type_video')) {
    function jayla_jetpack_portfolio_single_entry_section_type_video($data) {
        // echo '<pre>'; print_r($data); echo '</pre>';

        $output = '';
        if( 'youtube_vimeo' == $data['video_type'] ) {
            $player_opts = wp_json_encode( array(
                'type' => 'video',
                'video_type' => 'external_video',
                'video_link' => $data['video_youtube_vimeo_data'],
                'video_poster' => $data['video_poster'],
            ) );
            $output = implode('', array(
                '<div class="themeextends-video-player-plyr" data-themeextends-player-plyr=\''. $player_opts .'\'></div>',
            ));
        } else {
            $player_opts = wp_json_encode( array(
                'type' => 'video',
                'video_type' => 'html5_video',
                'video_poster' => $data['video_poster'],
            ) );

            $output = implode('', array(
                '<video controls crossorigin playsinline data-themeextends-player-plyr=\''. $player_opts .'\'>',
                    '<source src="'. esc_url( $data['video_html5_data'] ) .'" type="'. esc_attr( $data['html5_video_format'] ) .'">',
                '</video>',
            ));
        }

        ?>
        <div class="jetpack-portfolio-single-section-entry section-entry-type-<?php echo esc_attr( $data['type'] ) ?>">
            <?php
                echo "{$output}";
                echo ( ! empty($data['caption']) ) ? '<div class="__caption">'. do_shortcode( $data['caption'] ) .'</div>' : '';
            ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_entry_section')) {
    /**
     * @since 1.0.0
     *
     */
    function jayla_jetpack_portfolio_single_entry_section() {
        $section_data = carbon_get_post_meta( get_the_ID(), 'project_section_entry_complex' );
        ?>
        <div class="p-entry-section">
            <div class="__inner">
                <?php do_action('jayla_jetpack_portfolio_single_entry_section_before') ?>
                <?php if( ! empty( $section_data ) && count( $section_data ) > 0 ) {
                    foreach($section_data as $item) {
                        $func_name = 'jayla_jetpack_portfolio_single_entry_section_type_' . $item['type'];
                        if( function_exists( $func_name ) )
                            call_user_func_array( 'jayla_jetpack_portfolio_single_entry_section_type_' . $item['type'], array($item) );
                    }
                } ?>
                <?php do_action('jayla_jetpack_portfolio_single_entry_section_after') ?>
            </div>
        </div>
        <?php
    }
}

if(! function_exists('jayla_metabox_customize_portfolio_detail_settings_panel')) {
    function jayla_metabox_customize_portfolio_detail_settings_panel() {
    ?>
    <el-tab-pane>
        <span slot="label"><i class="fi flaticon-bars"></i> <?php _e('Portfolio Single', 'jayla') ?></span>

        <el-form-item label="<?php esc_attr_e('Custom Portfolio Single', 'jayla'); ?>">
            <el-switch
            v-model="form.custom_jetpack_portfolio_single"
            on-text="" off-text=""
            on-value="yes"
            off-value="no"></el-switch>
            <div style="line-height: normal;"><small><?php _e('on/off custom portfolio single page.', 'jayla') ?></small></div>
        </el-form-item>

        <hr /> <br />

        <transition name="theme-extends-fade">
            <div v-show="(form.custom_jetpack_portfolio_single == 'yes')">
                <el-form-item label="<?php esc_attr_e('Layout Product Detail', 'jayla'); ?>">
                    <el-select v-model="form.jetpack_portfolio_single_settings.single_layout" placeholder="<?php esc_attr_e( 'Select', 'jayla' ); ?>">
                        <?php
                            $project_single_layout = jayla_jetpack_portfolio_single_layout();
                            foreach($project_single_layout as $value => $data) {
                                echo sprintf('<el-option label="%s" value="%s"></el-option>', $data['label'], $value);
                            }
                        ?>
                    </el-select>
                </el-form-item>
            </div>
        </transition>
    </el-tab-pane>
    <?php
    }
}
