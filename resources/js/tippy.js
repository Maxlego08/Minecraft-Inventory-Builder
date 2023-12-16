import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

window.addEventListener('load', function () {
    // NodeList
    tippy(document.querySelectorAll('.username-tooltip'), {
        content: '<span style="padding: 10px 5px">Loading...</span>',
        arrow: true,
        allowHTML: true,
        interactive: true,
        interactiveBorder: 5,
        zIndex: 99999,
        theme: 'light', // show delay is 100ms, hide delay is the default
        delay: [100, null],
        appendTo: reference => reference.parentNode,
        onShow(instance) {
            let url = instance.reference.getAttribute('data-url')
            axios.get(url).then((response) => {
                instance.setContent(response.data);
            }).catch((error) => {
                instance.setContent(`Request failed. ${error}`);
            });
        },
    });
});
