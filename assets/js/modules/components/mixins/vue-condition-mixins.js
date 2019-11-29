/**
 * condition mixins
 */
$ = jQuery.noConflict();

module.exports = {
  // data () {
  //   return {
  //     condition_value: true,
  //   };
  // },
  computed: {
    condition_value () {
      return this._condition();
    }
  },
  // created (el) {
  //   this.condition_value = this._condition();
  //   console.log(this.condition_value);
  // },
  methods: {
    _condition () {
      var self = this,
          showing = true;

      /* check condition exist */
      if( ! this.params.condition ) return showing;

      var handle_map = {
        'string' (key, val) {
          var result = true;

          switch (val) {
            case 'not-null': result = (self.dataMap[key] != '') ? true : false; break;
            default: result = (self.dataMap[key] == val); break;
          }

          return result;
        },
        'object' (key, val) {
          return $.inArray(self.dataMap[key], val);
        },
      };

      /* each condition */
      $.each(this.params.condition, function(key, val) {
        var type = typeof val;
        showing = handle_map[type](key, val);
        if(showing == false) return false;
      })

      return showing;
    }
  }
}
