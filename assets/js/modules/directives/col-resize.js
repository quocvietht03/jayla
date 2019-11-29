/**
 * directive col resize
 */

$ = jQuery.noConflict();
module.exports = {
  bind (el, binding, vnode) {

  },
  inserted (el, binding, vnode) {
    if(binding.value == false) return;
    var [item, index] = binding.value;

    el.resizable_obj = $(el).resizable({
      handles: 'w',
      create () {

        /* get width first parent rs-row */
        this.get_row_width = function(ui) {
          return $(ui.element).closest('.rs-row').innerWidth();
        }

        /* calc new row percent */
        this.calc_new_percent = function(ui) {
          return parseFloat((ui.size.width / this.get_row_width(ui)) * 100).toFixed(3);
        }
      },
      resize (event, ui) {
        var col_new_percent = this.calc_new_percent(ui);
        vnode.context.$root.$emit('event:resize_col' + vnode.parent.context.$props.item.key, item, col_new_percent);
        ui.position.left = 0;
        ui.originalElement.css('width', col_new_percent + '%');
      },
    });

    if(index == 0)
      el.resizable_obj.resizable( 'option', 'disabled', true );
  },
  update (el, binding, vnode) {
    if(binding.value == false) return;
    var [item, index] = binding.value;

    var children_data = vnode.parent.context.item.children;
        new_index = children_data.indexOf(binding.value[0]);

    if(0 == new_index) {
      el.resizable_obj.resizable( 'option', 'disabled', true );
    } else {
      el.resizable_obj.resizable( 'option', 'disabled', false );
    }
  },
  componentUpdated (el, binding, vnode) {

  }
}
