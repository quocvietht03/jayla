/**
 * Store module global
 */

var globalData = {
  layout: {
    layout: 'default', /* nav-left, nav-right */
    nav_toogle: 'no',
  },
  sidebar: {
    archive: 'right-sidebar',
    // archive_no_sidebar_col: 12,

    page_template_default: 'right-sidebar',
    // page_template_default_no_sidebar_col: 12,

    single_default: 'right-sidebar',
    // single_no_sidebar_col: 12,
  },
  pagination: {
    layout: 'default',
  },
  scroll_top: {
    show: 'no',
    icon: '',
  },
};

module.exports = {
  state: {
    data: theme_customize_object.jayla_global_settings,
    edit: '',
  },
  mutations: {

  },
};
