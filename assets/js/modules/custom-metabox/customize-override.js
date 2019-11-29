export default function (params) {
  var fieldData = params.fieldData,
      fieldSaving = params.fieldSaving,
      data = JSON.parse(fieldData.val());
  
  new Vue({
    el: params.el,
    data () {
      return {
        data: data,
        wp_media_field_params: {
          //'label': "Select Image",
          'type': "wp-media"
        },
        bg_image_size: [
          { label: 'Cover', value: 'cover' },
          { label: 'Contain', value: 'contain' },
          { label: 'Initial', value: 'initial' },
        ],
        bg_image_position: [
          { label: 'Left', value: 'left' },
          { label: 'Right', value: 'right' },
          { label: 'Center', value: 'center' },
        ],
        bg_image_repeat: [
          { label: 'No Repeat', value: 'no-repeat' },
          { label: 'Tile', value: 'repeat' },
          { label: 'Tile Horizontally', value: 'repeat-x' },
          { label: 'Tile Vertically', value: 'repeat-y' },
        ],
        bg_image_attachment: [
          { label: 'Scroll', value: 'scroll' },
          { label: 'Fixed', value: 'fixed' },
        ],
      };
    },
    computed: {
      form () {
        return this.data.settings;
      },
      header_layouts () {
        return this.data.header_layouts;
      },
      header_options () {
        var options = [{label: 'Global', value: ''}];

        this.header_layouts.forEach(function(item) {
          options.push({
            label: item.name,
            value: item.key,
          })
        })

        return options;
      },
      footer_layouts () {
        return this.data.footer_layouts;
      },
      footer_options () {
        var options = [{label: 'Global', value: ''}];

        this.footer_layouts.forEach(function(item) {
          options.push({
            label: item.name,
            value: item.key,
          })
        })

        return options;
      },
    },
    watch: {
      form: {
        handler (data) {
          fieldSaving.val( JSON.stringify(data) );
        },
        deep: true,
      }
    }
  });
}
