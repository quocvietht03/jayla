/**
 * @package theme customize script
 * @author Bearsthemes
 * @version 1.0.0
 */

/*
  * Customize lib
  */
import customizeGlobal from "./modules/customize/global";
import customizeHeader from "./modules/customize/header";
import customizeDesigner from "./modules/customize/designer";
import customizeHeadingBar from "./modules/customize/heading-bar";
import customizeTaxonomyHeadingBar from "./modules/customize/taxonomy-heading-bar";
import customizeFooter from "./modules/customize/footer";
import customizeWooCommerce from "./modules/customize/woocommerce";
import customizeJetpackPortfolio from "./modules/customize/jetpack-portfolio";
import customizeBlog from "./modules/customize/blog";

import { Chrome } from 'vue-color';

!(function(wp, $) {
  "use strict";

  ELEMENT.locale(ELEMENT.lang.en);

  /* DOM Ready */
  $(function() {
    /* store module */
    const moduleGlobal = require("./modules/store/module-global.js");
    const moduleHeader = require("./modules/store/module-header.js");
    const moduleFooter = require("./modules/store/module-footer.js");
    const moduleDesigner = require("./modules/store/module-designer.js");
    const moduleHeadingBar = require("./modules/store/module-heading-bar.js");
    const moduleTaxonomyHeadingBar = require("./modules/store/module-taxonomy-heading-bar.js");
    const moduleWooCommerce = require("./modules/store/module-woocommerce.js");
    const moduleJetpackPortfolio = require("./modules/store/module-jetpack-portfolio.js");
    const moduleBlog = require("./modules/store/module-blog.js");

    wp.theme_store = new Vuex.Store({
      state: {
        widgets: theme_customize_object.jayla_header_widget, // widgets,
        widget_options: theme_customize_object.jayla_header_widget_options, // widget options
        wp_widgets: theme_customize_object.jayla_header_wp_widget // wp widgets,
      },
      modules: {
        global: moduleGlobal,
        header: moduleHeader,
        footer: moduleFooter,
        designer: moduleDesigner,
        headingBar: moduleHeadingBar,
        taxonomyHeadingBar: moduleTaxonomyHeadingBar,
        woocommerce: moduleWooCommerce,
        jetpack_portfolio: moduleJetpackPortfolio,
        blog: moduleBlog
      }
    });

    /**
     * vue directives
     */
    Vue.directive("col-resize", require("./modules/directives/col-resize"));
    Vue.directive(
      "sortable-element",
      require("./modules/directives/sortable-element")
    );
    Vue.directive(
      "draggable-element",
      require("./modules/directives/draggable-element")
    );

    /**
     * vue components
     */

    // fields
    Vue.component(
      "input-field",
      require("./modules/components/fields/vue-input-field")
    );
    Vue.component(
      "select-field",
      require("./modules/components/fields/vue-select-field")
    );
    Vue.component(
      "switch-field",
      require("./modules/components/fields/vue-switch-field")
    );
    Vue.component(
      "color-picker-field",
      require("./modules/components/fields/vue-color-picker-field")
    );
    Vue.component(
      "chrome-color-picker-field",
      Chrome,
    );
    Vue.component(
      "bears-color-picker-field",
      require("./modules/components/fields/vue-bears-color-picker-field.js"),
    );
    Vue.component(
      "radio-group-field",
      require("./modules/components/fields/vue-radio-group-field")
    );
    Vue.component(
      "checkbox-group-field",
      require("./modules/components/fields/vue-checkbox-group-field")
    );
    Vue.component(
      "wp-widget-fields",
      require("./modules/components/fields/vue-wp-widget-fields")
    );
    Vue.component(
      "wp-media-field",
      require("./modules/components/fields/vue-wp-media-field")
    );
    Vue.component(
      "typography-field",
      require("./modules/components/fields/vue-typography-field")
    );
    Vue.component(
      "separator-field",
      require("./modules/components/fields/vue-separator")
    );
    Vue.component(
      "design-group-fields",
      require("./modules/components/fields/vue-design-group-fields")
    );

    // components builder
    Vue.component("rs-row", require("./modules/components/vue-rs-row-element"));
    Vue.component("rs-col", require("./modules/components/vue-rs-col-element"));
    Vue.component("widget", require("./modules/components/vue-widget-element"));
    Vue.component(
      "wp-widget",
      require("./modules/components/vue-wp-widget-element")
    );
    Vue.component(
      "editor-tool",
      require("./modules/components/vue-editor-tool")
    );
    Vue.component(
      "settings-render",
      require("./modules/components/vue-settings-render")
    );
    Vue.component(
      "popup-edit-element",
      require("./modules/components/vue-popup-edit-element")
    );
    Vue.component(
      "child-component",
      require("./modules/components/vue-child-component-element")
    );
    Vue.component(
      "customize-builder",
      require("./modules/components/vue-customize-builder-element")
    );
  });

  /* browser load complete */
  $(window).load(function() {
    /* Customize call */
    customizeGlobal(wp, $);
    customizeHeader(wp, $);
    customizeDesigner(wp, $);
    customizeHeadingBar(wp, $);
    customizeTaxonomyHeadingBar(wp, $);
    customizeFooter(wp, $);
    customizeWooCommerce(wp, $);
    customizeJetpackPortfolio(wp, $);
    customizeBlog(wp, $);
  });
})(window.wp, jQuery);
