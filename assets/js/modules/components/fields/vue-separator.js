/**
 * component separator
 */

module.exports = {
    props: ['params', 'name', 'dataMap'],
    template: `
        <div :class="classes">
            <hr />
            <slot></slot>
        </div>`,
    computed: {
        classes () {
            return ['theme-extends-field-wrap', 'field-type-' + this.params.type];
        }
    },
}
