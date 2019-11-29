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
class Jayla_Widget_Recent_Posts extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_recent_posts',
            __('Theme Widget - Recent Posts', 'jayla'),
            __('Your site’s most recent Posts.', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )->set_default_value( __('Recent Posts', 'jayla') ) ,
                Field::make( 'text', 'number_posts_show', __('Number of posts to show', 'jayla') )
                    ->set_attribute( 'type', 'number' )
                    ->set_attribute( 'min', 1 )
                    ->set_attribute( 'max', 20 )
                    ->set_default_value( 5 ),
                Field::make( 'checkbox', 'display_post_date', __('Display post date?', 'jayla') )
                    ->set_default_value( true ),
                Field::make( 'checkbox', 'display_post_author', __('Display post author?', 'jayla') )
                    ->set_default_value( true ),

            )
        );
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';

        $args = array(
            'numberposts' => (int) $instance['number_posts_show'],
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_status' => 'publish',
        );

        $recent_posts = wp_get_recent_posts( $args );
        ?>
        <div class="theme-extends-widget-recent-posts __layout-default">
            <div class="__inner">
                <?php if( ! empty($recent_posts) && count($recent_posts) > 0 ) {
                    $output = array();
                    array_push( $output, '<ul class="recent-post-items">' );
                    foreach( $recent_posts as $_p ) {
                        $post_link = get_the_permalink( $_p['ID'] );
                        $post_thumb = '<img class="__placeholder-image" src="'. esc_url( get_template_directory_uri() . '/assets/images/core/placeholder-image.jpg' ) .'" title="'. esc_attr( $_p['post_title'] ) .'" alt="'. esc_attr( $_p['post_title'] ) .'">';
                        if ( has_post_thumbnail( $_p['ID'] ) ) {
                            $post_thumb = get_the_post_thumbnail( $_p['ID'], 'thumbnail' );
                        }

                        $post_by = '<div class="p-author">' . __('by', 'jayla') . ' ' . '<a href="'. esc_url( get_author_posts_url($_p['post_author']) ) .'">' . get_the_author_meta('user_nicename', $_p['post_author']) . '</a>' . '</div>';
                        $post_date = '<div class="p-date">' . get_the_date( '', $_p['ID'] ) . '</div>';

                        array_push( $output, implode('', array(
                            '<li class="recent-post-item">',
                                '<a class="p-thumb" href="'. esc_url( $post_link ) .'">'. $post_thumb .'</a>',
                                '<div class="p-entry">',
                                    '<h3><a class="p-title" href="'. esc_url( $post_link ) .'">'. $_p['post_title'] .'</a></h3>',
                                    ( $instance['display_post_date'] == true ) ? $post_date : '',
                                    ( $instance['display_post_author'] == true ) ? $post_by : '',
                                '</div>',
                            '</li>',
                        )) );
                    }
                    array_push( $output, '</ul>' );
                    echo implode('', $output);
                } else {
                    ?>
                    <p><?php _e('There are no posts to display..!', 'jayla') ?></p>
                    <?php
                }
                wp_reset_query();
                ?>
            </div>
        </div>
        <?php
    }
}
