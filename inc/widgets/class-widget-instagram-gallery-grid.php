<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Recent Posts
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_instagram_gallery_grid extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_instagram_gallery_grid',
            __('Theme Widget - Instagram Gallery Grid', 'jayla'),
            __('Instagram gallery grid.', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )->set_default_value( __('Instagram Gallery', 'jayla') ) ,
                Field::make( 'text', 'username', __('Username', 'jayla') )
                    ->set_default_value( __('', 'jayla') )
                    ->set_help_text( __('Input username for instagram feed', 'jayla') )
                    ->set_required( true ) ,
                Field::make( 'text', 'number_item_show', __('Items Show', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 2 )
                    ->set_attribute( 'max', 16 )
                    ->set_default_value( 8 )
                    ->set_help_text( __('Input number item for display.', 'jayla') ),
                Field::make( 'text', 'number_columns', __('Columns', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 2 )
                    ->set_attribute( 'max', 5 )
                    ->set_default_value( 4 )
                    ->set_help_text( __('Input number column.', 'jayla') ),
                Field::make( 'text', 'gap', __('Gap', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 0 )
                    ->set_attribute( 'max', 30 )
                    ->set_default_value( 8 )
                    ->set_help_text( __('Input number gap.', 'jayla') ),
                Field::make( 'checkbox', 'show_author', __('Show author', 'jayla') )
                    ->set_default_value( true )
                    ->set_help_text( __('Checked for show author avatar & authro name.', 'jayla') ),
            ) 
        );
    }

    public function instagram_folder_cache_manager() {
        $uploads = wp_upload_dir();
        $upload_path = $uploads['basedir'];
        $cache_folder =  $upload_path . '/instagram-cache/folder';

        if( ! is_dir($cache_folder) ) wp_mkdir_p($cache_folder);
        return $cache_folder;   
    }

    public function get_instagram_feed($username = '') {
        $cache = new Instagram\Storage\CacheManager( $this->instagram_folder_cache_manager() );
        $api   = new Instagram\Api($cache);

        $instagram_server_status = jayla_get_server_status('https://www.instagram.com/', 80);
        if( 200 != $instagram_server_status ) return array();

        $api->setUserName($username);
        return $api->getFeed();
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        if( empty( $instance['username'] ) ) return;

        $feed = $this->get_instagram_feed($instance['username']);    
        $medias = $feed->medias;

        // echo '<pre>'; print_r($medias); echo '</pre>';

        if( empty($medias) || count($medias) <= 0 ) return;
        $placeholder_image = get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg';
        $number_item_show = (int) $instance['number_item_show'];
        $furygrid_options = wp_json_encode( array(
            'Responsive' => array(),
        ) );

        $author_html = implode('', array(
            '<div class="ins-author">',
                '<a href="'. esc_url( 'https://www.instagram.com/'. $feed->userName ) .'" target="_blank">',
                    '<img class="ins-author-avatar" src="'. esc_url( $feed->profilePicture ) .'" alt="'. esc_attr( $feed->fullName ) .'">',
                    '<span class="ins-author-name">'. $feed->fullName .'</span>',
                '</a>',
            '</div>',
        ));
        ?>
        <div class="instagram-gallery-grid __layout-default">
            <div class="__inner" data-theme-furygrid-options='<?php echo esc_attr($furygrid_options); ?>' data-custom-furygrid-col="<?php echo esc_attr( $instance['number_columns'] ) ?>" data-custom-furygrid-space="<?php echo esc_attr( $instance['gap'] ) ?>">
                <div class="furygrid-sizer"></div>
                <div class="furygrid-gutter-sizer"></div>
                <?php
                    $count = 1;
                    foreach($medias as $m) {
                        ?>
                        <div class="furygrid-item ins-item">
                            <a href="<?php echo esc_url( $m->link ); ?>" target="_blank" data-background-image-lazyload-onload="<?php echo esc_attr($m->thumbnailSrc); ?>" data-hidden-el-onload-success="> img">
                                <img src="<?php echo esc_url( $placeholder_image ); ?>" alt="<?php esc_attr_e('#instagram', 'jayla'); ?>"/>
                            </a>
                        </div>
                        <?php
                        $count += 1;
                        if($count > $number_item_show) break;
                    }
                ?>
            </div>
            <?php if( $instance['show_author'] == true )
                echo apply_filters( 'jayla_widget_instagram_gallery_grid_author_html', $author_html, $feed ); 
            ?>
        </div>
        <?php
    }
}
