/**
 * component wordpress widget fields
 */
var helpers = require('../../helpers.js');
$ = jQuery.noConflict();

module.exports = {
  props: ['item'],
  data () {
    return {
      ajaxload    : true,
      form        : '',
    }
  },
  template: `
    <div :class="classes">
      <div v-if="form != ''" class="">
        <div v-html="form" class="wp-widget-form widget-content" ref="wp_widget_form"></div>
      </div>
      <button v-if="form != ''" class="btn-apply" @click="send_data($event)">Apply <i v-show="ajaxload" class="el-icon-loading"></i></button>
    </div>`,
  created (el) {
    this.get_wp_widget_form(this.item)
  },
  computed: {
    classes () {
      return ['field-wrap'];
    }
  },
  methods: {
    send_data (event) {
      event.preventDefault();
      var self = this;
          form = $(this.$refs.wp_widget_form).find('[data-theme-extends-widget-id]'),
          data = form.serialize();

      this.ajaxload = true;
      var sendData = [
        'action=jayla_save_wp_widget_data', 
        'widget_key=' + self.item.widget_key, 
        'key=' + self.item.key, 
        'element=' + self.item.element,
        data
      ];

      $.ajax({
        type: 'POST',
        url: theme_customize_object.ajax_url,
        data: sendData.join('&'),
        success (result) {
          self.ajaxload = false;
          if(result.success != true) return;

          Vue.set(self.item, 'params', result.data);
        },
        error (e) { console.log(e); }
      })
    },
    get_wp_widget_form (item) {
      var self = this;
      this.ajaxload = true;
      // console.log(item);
      $.ajax({
        type: 'POST',
        url: theme_customize_object.ajax_url,
        data: { action: 'jayla_load_wp_widget_form', data: item },
        success (result) {
          self.ajaxload = false;
          if(! result) return;

          try{
            var form = (result.data && result.data.form) ? result.data.form : '';
            self.form = form;

    				// WP >= 4.8
    				if ( window.wp.textWidgets ) {
              setTimeout(function() {
                var event = new $.Event( 'widget-added' ),
                    widget_id = $('[data-theme-extends-widget-id]').data('theme-extends-widget-id'); // $('#theme-extends-widget-area-define');
                
                var form = $('#' + widget_id);
                    
      					window.wp.textWidgets.handleWidgetAdded( event, form );
                window.wp.mediaWidgets.handleWidgetAdded( event, form );
                window.wp.customHtmlWidgets.handleWidgetAdded( event, form );
                $(document).trigger('widget-before-added', [form])

                // console.log(window.wp);
                // window.carbon_json.pagenow = '@@'; 

                // $(document).trigger('carbonFields.apiLoaded', form[0]);
                // .trigger('widget-added', [form])
              }, 10)
    				}

          } catch (e) { console.log(e) }
        },
        error (e) { console.log(e) }
      })
    },
  }
}
