<?php
/**
 * @since 1.0.0
 * Widget params header & footer builder 
 * 
 * Support Widgets
 *  - Row
 *  - Column
 *  - Search
 *  - Primary Navigation
 *  - Secondary Navigation
 *  - Handheld Navigation
 *  - Menu Offcanvas
 *  - Logo
 *  - Connect Social
 */

$widget_options = array(
    'rs-row' => include __DIR__ . '/widget-rs-row-params.php',
    'rs-col' => include __DIR__ . '/widget-rs-col-params.php',
    'widget-search' => include __DIR__ . '/widget-search-params.php',
    'widget-primary-navigation' => include __DIR__ . '/widget-primary-navigation-params.php',
    'widget-secondary-navigation' => include __DIR__ . '/widget-secondary-navigation-params.php',
    'widget-handheld-navigation' => include __DIR__ . '/widget-handheld-navigation-params.php',
    'widget-menu-offcanvas' => include __DIR__ . '/widget-menu-offcanvas-params.php',
    'widget-logo' => include __DIR__ . '/widget-logo-params.php',
    'widget-connect-social' => include __DIR__ . '/widget-connect-social-params.php',
    'widget-icon-font' => include __DIR__ . '/widget-icon-font-params.php',
);

return $widget_options;
