/**
 * directive sortable
 */

$ = jQuery.noConflict();
module.exports = {
  bind (el, binding, vnode) {

  },
  inserted (el, binding, vnode) {
    if(binding.value == false) return;

    var options = binding.value;
    new Sortable(el, options);
  },
  update (el, binding, vnode) {
    
  },
  componentUpdated (el, binding, vnode) {

  }
}
