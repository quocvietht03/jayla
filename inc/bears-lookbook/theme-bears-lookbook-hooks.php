<?php 
add_action( 'blookbook_before_main_content', 'jayla_blookbook_wrap_single_content_open', 15 );
add_action( 'blookbook_after_main_content', 'jayla_blookbook_wrap_single_content_close', 25 );

add_action( 'blookbook_before_archive_content', 'jayla_blookbook_wrap_single_content_open', 15 );
add_action( 'blookbook_after_archive_content', 'jayla_blookbook_wrap_single_content_close', 25 );

add_action( 'blookbook_archive_classes_open', 'jayla_blookbook_custom_classes_open' );
add_action( 'blookbook_single_content_classes_open', 'jayla_blookbook_custom_classes_open' );
add_filter( 'jayla_heading_bar_display_data', 'jayla_blookbook_remove_heading_bar_single_page' );