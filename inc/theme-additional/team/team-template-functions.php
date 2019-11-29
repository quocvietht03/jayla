<?php 

if( ! function_exists('jayla_team_get_custom_archive_page_template') ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_get_custom_archive_page_template( $archive_template ) {
        global $post;

        if ( is_post_type_archive ( 'team' ) ) {
            $archive_template = dirname( __FILE__ ) . '/templates/archive-team-template.php';
        }
        return $archive_template;
    }
}

if( ! function_exists('jayla_team_before_archive_content_open') ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_before_archive_content_open() {
        ?>
        <div id="main-content" class="team-main-content"> <!-- open #main-content -->
            <div class="<?php do_action('jayla_container_class') ?>"> <!-- open jayla_container_class -->
        <?php
    }
}

if( ! function_exists('jayla_team_before_archive_content_close') ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_before_archive_content_close() {
        ?>
            </div> <!-- close jayla_container_class -->
        </div> <!-- close #main-content -->
        <?php
    }
}

if(! function_exists('jayla_team_before_archive_content_masonry_open')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_before_archive_content_masonry_open() {
        $furygrid_opts = array(
            'Col' => 4,
            'Space' => 35,
            'Responsive' => array(
                '780' => array(
                    'Col' => 2,
                ),
                '360' => array(
                    'Col' => 1,
                ),
            ),
        );
        ?>
        <div class="team-furygrid-grid" data-theme-furygrid-options="<?php echo esc_attr( wp_json_encode( $furygrid_opts ) ); ?>">
            <div class="furygrid-sizer"></div>
            <div class="furygrid-gutter-sizer"></div>
        <?php
    }
}

if(! function_exists('jayla_team_archive_item_entry_func')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_archive_item_entry_func() {
        global $post;
        include __DIR__ . '/templates/archive-team-loop-template.php';
    }
}

if(! function_exists('jayla_team_before_archive_content_masonry_close')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_before_archive_content_masonry_close() {
        ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'jayla_team_get_custom_post_type_template' ) ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_get_custom_post_type_template( $single_template ) {
        global $post;

        if ( 'team' == $post->post_type ) {

            // remove heading bar
            remove_action( 'jayla_content_top', 'jayla_heading_bar_func', 10 );
            add_action( 'jayla_content_top', 'jayla_team_add_team_cover_func', 20 );

            $single_template = dirname( __FILE__ ) . '/templates/single-team-template.php';
        }

        return $single_template;
    }
}

if( ! function_exists( 'jayla_team_add_team_cover_func' ) ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_add_team_cover_func() {
        include dirname( __FILE__ ) . '/templates/single-team-cover-template.php';
    }
}

if( ! function_exists( 'jayla_team_single_image_cover_func' ) ) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_team_single_image_cover_func() {
        global $post;

        $corver_image = '';
        if( has_post_thumbnail() ) {
            $cover_medium = get_the_post_thumbnail_url( $post->ID, 'medium' );
            $cover_full = get_the_post_thumbnail_url( $post->ID, 'full' );
            
            if( $cover_full ) {
                $corver_image = '<img class="jarallax-img" src="'. $cover_medium .'" data-themeextends-lazyload-url="'. $cover_full .'">';
            }
        }
        ?>
        <div class="single-post-team-cover-image-parallax jarallax" data-jarallax data-speed="0.2">
			<?php echo "{$corver_image}"; ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_single_entry_open')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_single_entry_open() {
        ?>
        <div class="post-single-team-entry-container"> <!-- open .post-single-team-entry-container -->
        <?php
    }
}

if(! function_exists('jayla_team_single_entry_close')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_single_entry_close() {
        ?>
        </div> <!-- close .post-single-team-entry-container -->
        <?php
    }
}

if(! function_exists('jayla_team_single_avatar_box_html')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_single_avatar_box_html() {
        global $post;
        $avatar_image = '<img src="" alt="'. get_the_title() .'"/>';
        $avatar_img_id = carbon_get_post_meta( $post->ID, 'team_avatar' );
        if( $avatar_img_id ) {
            $img_full = wp_get_attachment_image_src( $avatar_img_id, 'full' );

            if( false != $img_full ) {
                $avatar_image = wp_get_attachment_image( $avatar_img_id, 'medium', false, array(
                    'class' => 'post-team-avatar-img',
                    'data-themeextends-lazyload-url' => $img_full[0],
                ) );
            }
        }
        ?>
        <div class="post-team-avatar-box">
            <div class="__inner">
                <div class="team-avatar-image">
                    <?php echo "{$avatar_image}"; ?>
                </div>
                <?php do_action( 'jayla_team_avatar_after_avatar' ); ?>
                <div class="team-avatar-entry">
                    <h2 class="team-name"><?php the_title(); ?></h2>
                </div>
                <?php do_action( 'jayla_team_avatar_after_entry' ); ?>
            </div>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_qoute_box_html')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_qoute_box_html() {
        global $post;
        $team_quote = carbon_get_post_meta( $post->ID, 'team_quote' );
        if( empty( $team_quote ) ) return;

        ?>
        <div class="post-team-quote-box">
            <?php echo "{$team_quote}"; ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_follow_me_html')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_follow_me_html() {
        global $post;
        $social_button_link_temp = apply_filters( 'jayla_team_social_bottom_link_temp' , array(
            'facebook' => '<a href="{{link_social}}" class="__button-link-social s-facebook {{extra_class}}" target="_blank"><span class="__icon"><i class="fa fa-facebook"></i></span><span class="__text">'. __( 'Facebook', 'jayla' ) .'</span></a>',
            'twitter' => '<a href="{{link_social}}" class="__button-link-social s-twitter {{extra_class}}" target="_blank"><span class="__icon"><i class="fa fa-twitter"></i></span><span class="__text">'. __( 'Twitter', 'jayla' ) .'</span></a>',
            'google_plus' => '<a href="{{link_social}}" class="__button-link-social s-google-plus {{extra_class}}" target="_blank"><span class="__icon"><i class="fa fa-google-plus"></i></span><span class="__text">'. __( 'Google plus', 'jayla' ) .'</span></a>',
        ));
        ?>
        <div class="post-team-follow-me-via-social">
            <div class="__heading">
                <?php _e( 'Follow me on social', 'jayla' ); ?>
            </div>
            <div class="__button-link-direct-social">
                <?php foreach( $social_button_link_temp as $social_name => $button ) {
                    $social_link = carbon_get_post_meta( $post->ID, 'team_'. $social_name .'_link' );
                    $replace_variable = array(
                        '{{link_social}}' => '#',
                        '{{extra_class}}' => '__disable-link',
                    );
                    if( ! empty( $social_link ) ) {
                        $replace_variable = array(
                            '{{link_social}}' => $social_link,
                            '{{extra_class}}' => '',
                        );
                    }

                    echo str_replace( array_keys( $replace_variable ), array_values( $replace_variable ), $button );
                    // echo $button;
                } ?>
            </div>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_single_content_html')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_single_content_html() {
        $classes = apply_filters( 'jayla_team_single_content_classes_filter', array( 'post-team-content' ) );
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <?php do_action( 'jayla_team_before_content_inner' ); ?>
            <div class="__inner __team-description">
                <?php do_action( 'jayla_team_before_content' ); ?>
                <?php the_content(); ?>
                <?php do_action( 'jayla_team_after_content' ); ?>
            </div>
            <?php do_action( 'jayla_team_after_content_inner' ); ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_features_section_container')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_features_section_container() {
        global $post;
        $features_section_data = carbon_get_post_meta( $post->ID, 'team_features_section_data' );
        if( count( $features_section_data ) <= 0 ) return;
        ?>
        <div class="post-team-features-section-container">
            <?php foreach( $features_section_data as $index => $feature_item ) { ?>
                <div class="team-feature-section-item type-<?php echo esc_attr( $feature_item['team_features_section_type'] ); ?>">
                    <?php do_action( 'jayla_team_feature_section_type_' . $feature_item['team_features_section_type'], $feature_item ); ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_feature_section_type_skill_progress_bar_func')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_feature_section_type_skill_progress_bar_func( $data ) {
        $skill_progress_bar_data = $data['skill_progress_bar_data'];
        if( count( $skill_progress_bar_data ) <= 0 ) return;
        ?>
        <h4 class="feature-title"><?php echo apply_filters( 'jayla_team_feature_section_item_title', $data['section_title'], $data['section_title'] ); ?></h4>
        <div class="feature-descriptions">
            <?php echo "{$data['section_descriptions']}"; ?>
        </div>
        <div class="feature-entry team-skill-progress-bar">
            <?php foreach( $skill_progress_bar_data as $item ) { 
                $skill_percent = $item['skill_proficient'] . '%';
                ?>
            <div class="skill-progress-bar-item">
                <label class="skill-name"><?php echo "{$item['skill_name']} {$skill_percent}"; ?></label>
                <div class="progress-bar-wrap">
                    <span 
                        class="progress-bar-light" 
                        style="width: <?php echo esc_attr( $skill_percent ); ?>; background: <?php echo esc_attr( $item['skill_progress_bar_color'] ); ?>;">
                        <span class="__dot" style="background: <?php echo esc_attr( $item['skill_progress_bar_color'] ); ?>;"></span>
                    </span>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_feature_section_type_timeline_func')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_feature_section_type_timeline_func( $data ) {
        // echo '<pre>'; print_r( $data ); echo '</pre>';
        $timeline_data = $data['timeline_data'];
        if( count( $timeline_data ) <= 0 ) return;
        ?>
        <h4 class="feature-title"><?php echo apply_filters( 'jayla_team_feature_section_item_title', $data['section_title'], $data['section_title'] ); ?></h4>
        <div class="feature-descriptions">
            <?php echo "{$data['section_descriptions']}"; ?>
        </div>
        <div class="feature-entry team-timeline">
            <?php foreach( $timeline_data as $item ) { ?>
            <div class="team-timeline-item">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-12">
                        <div class="team-timeline-item-meta team-timeline-time">
                            <?php echo "{$item['time']}"; ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-12">
                        <div class="team-timeline-item-meta team-timeline-company">
                            <div class="company-name"><?php echo "{$item['company_name']}"; ?></div>
                            <div class="company-location"><?php echo "{$item['company_location']}"; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-12">
                        <div class="team-timeline-item-meta team-timeline-position">
                            <?php echo "{$item['position']}"; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_jetpack_project_team_html')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_team_jetpack_project_team_html() {
        global $post;
        $project_member_heading_text = carbon_get_post_meta( $post->ID, 'project_member_heading_text' );
        $project_member_data = carbon_get_post_meta( $post->ID, 'project_member_data' );
        if( empty( $project_member_data ) ) return;

        $query = new WP_Query( array(
            'post_type' => 'team',
            'post__in' => $project_member_data,
            'orderby' => 'post__in',
            'posts_per_page' => -1,
        ) );
        ?>
        <div class="p-jetpack-project-team">
            <div class="p-heading-text">
                <?php echo "{$project_member_heading_text}"; ?>
            </div>
            <div class="p-jectpack-project-team-list">
                <?php
                // The Loop
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $team_avatar_id = carbon_get_post_meta( get_the_ID(), 'team_avatar' );
                        ?>
                        <a href="<?php the_permalink(); ?>" class="project-team-item">
                            <?php 
                            $avatar_image_data =  wp_get_attachment_image_src( $team_avatar_id, 'thumbnail' ); 
                            $image_url = ( false != $avatar_image_data ) ? $avatar_image_data[0] : '';

                            $avatar_image_html = '<img 
                                class="team-image-icon" 
                                src="'. get_template_directory_uri() . '/assets/images/core/icon-avatar.png' .'" 
                                data-themeextends-lazyload-url="'. $image_url .'" 
                                alt="#">';
                            ?>
                            <?php echo "{$avatar_image_html}"; ?>
                            <span class="team-name"><?php the_title(); ?></span>
                        </a>
                        <?php
                    }
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
    }
}

if(! function_exists('jayla_team_infomation_inline_html')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_infomation_inline_html() {
        global $post;
        $team_main_work = carbon_get_post_meta( $post->ID, 'team_main_work' );
        $team_location = carbon_get_post_meta( $post->ID, 'team_location' );
        $team_phone_number = carbon_get_post_meta( $post->ID, 'team_phone_number' );
        $team_email = carbon_get_post_meta( $post->ID, 'team_email' );
        ?>
        <div class="team-single-infomation-inline-container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="team-infomation-item __main-work">
                        <label>
                            <span class="label-icon"><svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 409.6 409.6" style="enable-background:new 0 0 409.6 409.6;" xml:space="preserve"> <g> <g> <path d="M402.773,150.187c-3.768,0-6.827,3.058-6.827,6.827V348.16H13.653V157.013c0-3.768-3.058-6.827-6.827-6.827 S0,153.245,0,157.013v197.973c0,3.768,3.058,6.827,6.827,6.827h395.947c3.768,0,6.827-3.058,6.827-6.827V157.013 C409.6,153.245,406.542,150.187,402.773,150.187z"/> </g> </g> <g> <g> <path d="M402.773,88.747H6.827C3.058,88.747,0,91.805,0,95.573v75.093c0,3.41,2.516,6.298,5.891,6.762l172.472,23.791 c3.741,0.505,7.182-2.096,7.697-5.83c0.515-3.734-2.096-7.182-5.83-7.697L13.653,164.717V102.4h382.293v62.317l-168.168,23.194 c-3.734,0.515-6.345,3.963-5.83,7.697c0.471,3.417,3.4,5.895,6.755,5.895c0.311,0,0.625-0.02,0.939-0.065l174.063-24.009 c3.379-0.464,5.895-3.352,5.895-6.762V95.573C409.6,91.805,406.542,88.747,402.773,88.747z"/> </g> </g> <g> <g> <path d="M241.37,47.787h-73.138c-17.48,0-31.7,14.22-31.7,31.7v16.087c0,3.768,3.058,6.827,6.827,6.827h122.88 c3.768,0,6.827-3.058,6.827-6.827V79.486C273.067,62.007,258.847,47.787,241.37,47.787z M259.413,88.747H150.187v-9.26 c0-9.95,8.096-18.046,18.046-18.046h73.134c9.95,0,18.046,8.096,18.046,18.046V88.747z"/> </g> </g> <g> <g> <path d="M225.28,163.84h-40.96c-3.768,0-6.827,3.058-6.827,6.827v47.787c0,15.056,12.25,27.307,27.307,27.307 s27.307-12.25,27.307-27.307v-47.787C232.107,166.898,229.048,163.84,225.28,163.84z M218.453,218.453 c0,7.53-6.123,13.653-13.653,13.653c-7.53,0-13.653-6.124-13.653-13.653v-40.96h27.307V218.453z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></span>
                            <span class="label-name"><?php echo empty( $team_main_work ) ? __( 'n/a', 'jayla' ) : $team_main_work; ?></span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="team-infomation-item __location">
                        <label>
                            <span class="label-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve"> <g> <path d="M30,26c3.86,0,7-3.141,7-7s-3.14-7-7-7s-7,3.141-7,7S26.14,26,30,26z M30,14c2.757,0,5,2.243,5,5s-2.243,5-5,5 s-5-2.243-5-5S27.243,14,30,14z"/> <path d="M29.823,54.757L45.164,32.6c5.754-7.671,4.922-20.28-1.781-26.982C39.761,1.995,34.945,0,29.823,0 s-9.938,1.995-13.56,5.617c-6.703,6.702-7.535,19.311-1.804,26.952L29.823,54.757z M17.677,7.031C20.922,3.787,25.235,2,29.823,2 s8.901,1.787,12.146,5.031c6.05,6.049,6.795,17.437,1.573,24.399L29.823,51.243L16.082,31.4 C10.882,24.468,11.628,13.08,17.677,7.031z"/> <path d="M42.117,43.007c-0.55-0.067-1.046,0.327-1.11,0.876s0.328,1.046,0.876,1.11C52.399,46.231,58,49.567,58,51.5 c0,2.714-10.652,6.5-28,6.5S2,54.214,2,51.5c0-1.933,5.601-5.269,16.117-6.507c0.548-0.064,0.94-0.562,0.876-1.11 c-0.065-0.549-0.561-0.945-1.11-0.876C7.354,44.247,0,47.739,0,51.5C0,55.724,10.305,60,30,60s30-4.276,30-8.5 C60,47.739,52.646,44.247,42.117,43.007z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></span>
                            <span class="label-name"><?php echo empty( $team_location ) ? __( 'n/a', 'jayla' ) : $team_location; ?></span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="team-infomation-item __phone-number">
                        <label>
                            <span class="label-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve"> <g> <path d="M20,49c-2.206,0-4,1.794-4,4s1.794,4,4,4s4-1.794,4-4S22.206,49,20,49z M20,55c-1.103,0-2-0.897-2-2s0.897-2,2-2 s2,0.897,2,2S21.103,55,20,55z"/> <path d="M17,5h4c0.552,0,1-0.447,1-1s-0.448-1-1-1h-4c-0.552,0-1,0.447-1,1S16.448,5,17,5z"/> <path d="M24,5h1c0.552,0,1-0.447,1-1s-0.448-1-1-1h-1c-0.552,0-1,0.447-1,1S23.448,5,24,5z"/> <path d="M56,12H38V4.405C38,1.977,36.024,0,33.595,0H8.405C5.976,0,4,1.977,4,4.405v51.189C4,58.023,5.976,60,8.405,60h25.189 C36.024,60,38,58.023,38,55.595V33h18V12z M8.405,2h25.189C34.921,2,36,3.079,36,4.405V6H6V4.405C6,3.079,7.079,2,8.405,2z M33.595,58H8.405C7.079,58,6,56.921,6,55.595V48h30v7.595C36,56.921,34.921,58,33.595,58z M36,46H6V8h30v4H18v21h4v7l9.333-7H36 V46z M54,31H38h-7.333L24,36v-5h-4V14h18h16V31z"/> <path d="M25,21h10c0.552,0,1-0.447,1-1s-0.448-1-1-1H25c-0.552,0-1,0.447-1,1S24.448,21,25,21z"/> <path d="M24,25c0,0.553,0.448,1,1,1h24c0.552,0,1-0.447,1-1s-0.448-1-1-1H25C24.448,24,24,24.447,24,25z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></span>
                            <span class="label-name"><?php echo empty( $team_phone_number ) ? __( 'n/a', 'jayla' ) : $team_phone_number; ?></span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="team-infomation-item __email">
                        <label>
                            <span class="label-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 457.01 457.01" style="enable-background:new 0 0 457.01 457.01;" xml:space="preserve"> <g> <path d="M423.72,158.389v-55.977h-70.602L228.5,3.598l-124.618,98.813H33.29v55.977L0,184.789v268.623h457.01V184.789 L423.72,158.389z M158.567,317.293L14,431.928V202.659L158.567,317.293z M228.505,279.703l201.41,159.709H27.094L228.505,279.703z M298.442,317.293L443.01,202.658v229.27L298.442,317.293z M438.746,188.173l-15.026,11.915v-23.83L438.746,188.173z M228.5,21.466 l102.086,80.946H126.415L228.5,21.466z M409.72,116.412v94.777l-122.544,97.171l-58.671-46.524l-58.672,46.524L47.29,211.189 v-94.778H409.72z M33.29,200.088l-15.026-11.915l15.026-11.916V200.088z"/> <rect x="92.505" y="168.412" width="272" height="14"/> <rect x="92.505" y="208.412" width="272" height="14"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></span>
                            <span class="label-name"><a href="mailto:<?php echo esc_attr( $team_email ); ?>"><?php echo empty( $team_email ) ? __( 'n/a', 'jayla' ) : $team_email; ?></a></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists('jayla_team_portfolio_button_switch_html') ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_portfolio_button_switch_html() {
        $buttons = apply_filters( 'jayla_team_portfolio_button_switch_filter', array(
            'description' => '<a href="#" class="__btn-switch __is-active" data-active-container=".__team-description">'. __( 'About Me', 'jayla' ) .'</a>',
            'portfolio' => '<a href="#" class="__btn-switch" data-active-container=".__team-projects">'. __( 'Projects', 'jayla' ) .'</a>',
        ) );
        ?>
        <div class="team-portfolio-switch-container">
            <?php foreach( $buttons as $btn_key => $btn_html ) {
                echo "{$btn_html}";
            } ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'jayla_team_portfolio_post_list_html' ) ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_portfolio_post_list_html() {
        global $post;
        $team_id = $post->ID;

        $query = new WP_Query( array(
            'post_type' => 'jetpack-portfolio',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'project_member_data',
                    'value' => array($team_id),
                    'compare' => 'IN'
                )
            )
        ) );
        ?>
        <div class="__inner __team-projects team-porfolio-single-container">
            <div class="row">
                <?php
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <div class="col-md-4">
                            <div class="__project-item">
                                <?php 
                                if( has_post_thumbnail( get_the_ID() ) ) {
                                    echo '<a href="'. get_the_permalink() .'">';
                                    echo '<div class="thumbnail">';
                                    echo get_the_post_thumbnail( 
                                        get_the_ID(), 
                                        'medium', 
                                        array( 'class' => 'project-post-thumbnail' ) 
                                    );
                                    echo '</div>';
                                    echo '</a>';
                                }
                                ?>
                                <div class="project-item-entry">
                                    <a class="title-link" href="<?php the_permalink(); ?>">
                                        <h4 class="title"><?php the_title(); ?></h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    }
}