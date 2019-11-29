<?php 
/**
 * Jayla Jetpack portfolio class
 * 
 */

if(! class_exists('Jayla_Jetpack_Portfolio') ) {
    class Jayla_Jetpack_Portfolio {
        function __construct() {
            $this->hooks();
        }
        
        public function hooks() {
            add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
            add_action( 'carbon_fields_register_fields', array($this, 'register_jetpack_portfolio_custom_meta_box') );
            
            Jayla_Jetpack_Portfolio_Add_Meta_Boxed();
        }

        public function register_jetpack_portfolio_custom_meta_box() {
            $info_project_fields = apply_filters( 'jayla_jetpack_portfolio_client_info_meta_fields', array(
                Carbon_Fields\Field::make( 'image', 'project_client_brand', __('Client Brand', 'jayla') ),
                Carbon_Fields\Field::make( 'text', 'project_client_name', __('Client Name', 'jayla')),
                Carbon_Fields\Field::make( 'text', 'project_client_website', __('Client Website', 'jayla')),
            ) );
            
            {
                $project_section_entry_complex_fields = apply_filters( 'project_section_entry_complex_fields_filter', array(
                    Carbon_Fields\Field::make( 'text', 'title', __('Title', 'jayla'))
                        ->set_help_text( __('Name is a section not showing on frontend.', 'jayla') ),
                    Carbon_Fields\Field::make( 'select', 'type', __('Section Type', 'jayla') )
                        ->add_options( array(
                            'single_image' => __('Single Image', 'jayla'),
                            'text_block' => __('Text Block', 'jayla'),
                            'image_gallery_grid' => __('Image Gallery Grid', 'jayla'),
                            'video' => __('Video', 'jayla'),
                        ) )
                        ->set_default_value('single_image'),
                    Carbon_Fields\Field::make( 'image', 'image', __('Image', 'jayla'))
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'single_image',
                            )
                        ) ),
                    Carbon_Fields\Field::make( 'media_gallery', 'image_gallery' )
                        ->set_type( array( 'image' ) )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'image_gallery_grid',
                            )
                        ) ),
                    Carbon_Fields\Field::make( 'select', 'grid_columns', __('Grid Columns', 'jayla') )
                        ->add_options( array(
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            5 => 5,
                            6 => 6,
                        ) )
                        ->set_default_value(4)
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'image_gallery_grid',
                            )
                        ) ),
                    Carbon_Fields\Field::make( 'select', 'video_type', __('Video Type', 'jayla') )
                        ->add_options( array(
                            'video_html5' => __('HTML5 Video', 'jayla'),
                            'youtube_vimeo' => __('Youtube or Vimeo', 'jayla'),
                        ) )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'video',
                            )
                        ) )
                        ->set_default_value('youtube_vimeo'),
                    Carbon_Fields\Field::make( 'oembed', 'video_youtube_vimeo_data', __('Video Link', 'jayla') )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'video',
                            ),
                            array(
                                'field' => 'video_type',
                                'value' => 'youtube_vimeo',
                            ),
                        ) )
                        ->set_default_value('https://vimeo.com/67300322'),
                    Carbon_Fields\Field::make( 'text', 'video_html5_data', __('Video Link', 'jayla') )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'video',
                            ),
                            array(
                                'field' => 'video_type',
                                'value' => 'video_html5',
                            ),
                        ) )
                        ->set_width(80),
                    Carbon_Fields\Field::make( 'select', 'html5_video_format', __('Video Format', 'jayla') )
                        ->add_options( apply_filters( 'jayla_jetpack_porfolio_html5_video_type', array(
                            'video/mp4' => 'mp4',
                            'video/ogg' => 'ogg',
                            'video/webm' => 'webm',
                        ) ) )
                        ->set_default_value('video/mp4')
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'video',
                            ),
                            array(
                                'field' => 'video_type',
                                'value' => 'video_html5',
                            ),
                        ) )
                        ->set_width(20),
                    Carbon_Fields\Field::make( 'image', 'video_poster', __('Poster', 'jayla') )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'video',
                            )
                        ) )
                        ->set_value_type( 'url' ),
                    Carbon_Fields\Field::make( 'rich_text', 'text_content', __('Content', 'jayla'))
                        ->set_rows( 8 )        
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => 'text_block',
                            )
                        ) ),
                    Carbon_Fields\Field::make( 'rich_text', 'caption', __('Caption', 'jayla'))
                        ->set_rows( 8 )    
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'type',
                                'value' => array('single_image', 'video'),
                                'compare' => 'IN',
                            ),
                        ) ),
                ) );
    
                $project_Section_Entry_fields = apply_filters( 'jayla_jetpack_portfolio_project_section_entry_meta_fields', array(
                    Carbon_Fields\Field::make( 'complex', 'project_section_entry_complex', __('Section(s)', 'jayla') )
                        ->set_layout('tabbed-vertical')
                        ->add_fields( $project_section_entry_complex_fields )
                        ->set_header_template('
                            <% if (title) { %>
                                Section Name — <%- title %>
                            <% } else { %>
                                <%- $_index %>
                            <% } %>
                        ')
                ) );
            }

            Carbon_Fields\Container::make( 'post_meta', __( 'Project Start/End date', 'jayla' ) )
                ->where( 'post_type', '=', 'jetpack-portfolio' )
                ->set_context('side')
                ->set_priority( 'high' )
                ->add_fields( array(
                    Carbon_Fields\Field::make( 'date', 'project_start_date', __('Project Start Date', 'jayla') )
                        ->set_attribute( 'placeholder', __('Date of project start', 'jayla') ),
                    Carbon_Fields\Field::make( 'date', 'project_end_date', __('Project End Date', 'jayla') )
                        ->set_attribute( 'placeholder', __('Date of project end', 'jayla') ),
                ) );

            Carbon_Fields\Container::make( 'post_meta', __( 'Portfolio Options - Info Project', 'jayla' ) )
                ->where( 'post_type', '=', 'jetpack-portfolio' )
                ->add_tab( __('Client Info', 'jayla'), $info_project_fields )
                ->add_tab( __('Project Section Entry', 'jayla'), $project_Section_Entry_fields );
        }

        public function scripts() {
            global $jayla_version;
            wp_enqueue_style( 'jayla-portfolio', get_template_directory_uri() . '/assets/css/jayla-portfolio.bundle.css', '', $jayla_version );
        }
    }
}

return new Jayla_Jetpack_Portfolio();