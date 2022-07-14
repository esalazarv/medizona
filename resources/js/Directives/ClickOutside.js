const ClickOutside = {
    mounted(el, binding, vnode) {
        el.clickOutsideEvent = function(event) {
            if (!(el === event.target || (event.target instanceof Node && el.contains(event.target)))) {
                binding.value(event);
            }
        };

        document.body.addEventListener("click", el.clickOutsideEvent);
    },

    unmounted() {
        //document.body.removeEventListener("click", el.clickOutsideEvent);
    }
};

export default ClickOutside;
