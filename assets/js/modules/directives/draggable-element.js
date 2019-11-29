/**
 * directive draggable
 */

$ = jQuery.noConflict();
module.exports = {
  bind (el, binding, vnode) {

  },
  inserted (el, binding, vnode) {
    $(el).draggable(binding.value);
  },
  update (el, binding, vnode) {

  },
  componentUpdated (el, binding, vnode) {

  }
}
