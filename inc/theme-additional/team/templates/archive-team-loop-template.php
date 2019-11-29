<?php 
global $post;
$team_avatar = carbon_get_post_meta( get_the_ID(), 'team_avatar' );
$team_main_work = carbon_get_post_meta( get_the_ID(), 'team_main_work' );
$avatar_data = wp_get_attachment_image_src( $team_avatar, 'full', false );

$avatar_image_html = '';
if( $avatar_data ) {
    $avatar_image_html = wp_get_attachment_image( $team_avatar, 'medium', false, array(
        'class' => 'team-avatar-image',
        'data-themeextends-lazyload-url' => $avatar_data[0],
    ) );
}
?>
<div class="furygrid-item">
    <div id="post-<?php the_ID(); ?>" <?php post_class( 'team-loop-item team-template-default' ); ?>>
        <a class="link-avatar" href="<?php the_permalink() ?>">
            <div class="team-avatar">
                <?php echo "{$avatar_image_html}"; ?>
            </div>
        </a>
        <div class="team-entry">
            <a href="<?php the_permalink() ?>" class="title-link">
                <h4 class="title"><?php the_title(); ?></h4>
            </a>
            <div class="team-position">
                <?php echo "{$team_main_work}"; ?>
            </div>
        </div>
    </div>
</div>