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

    let usernameElement = document.getElementById('user-name')
    if (usernameElement == null) return

    let lastElement = usernameElement.classList.item(2);
    console.log(lastElement)
    console.log(usernameElement.innerText)

    let elements = document.querySelectorAll('.username-card-content')

    tippy(elements, {
        content: '<span style="padding: 10px 5px">Loading...</span>',
        arrow: true,
        allowHTML: true,
        interactive: true,
        interactiveBorder: 5,
        zIndex: 99999,
        theme: 'light', // show delay is 100ms, hide delay is the default
        delay: [100, null],
        trigger: "mouseenter click",
        appendTo: reference => reference.parentNode,
        onShow(instance) {

            let isToggle = instance.reference.getAttribute('data-toggle') === '1'
            let hasAccess = instance.reference.getAttribute('data-access') === '1'
            let cssName = instance.reference.classList.item(1)
            let csrf = instance.reference.getAttribute('data-csrf')
            let url = instance.reference.getAttribute('data-url')
            let translation = instance.reference.getAttribute('data-translation')

            let value = `
            <div class="username-tippy d-flex flex-column p-2">
            <span class="${cssName} h3">${usernameElement.innerText}</span>
            `
            let action = isToggle ? `
                <form action="${url}" method="POST">
                    <input type="hidden" name="_token" value="${csrf}">
                    <button type="submit"
                            class="btn btn-sm btn-danger btn-sm"><i
                            class="bi bi-trash me-2"></i>${translation}</button>
                </form>
            ` : hasAccess ? `
                <form action="${url}" method="POST">
                    <input type="hidden" name="_token" value="${csrf}">
                    <button type="submit"
                            class="btn btn-sm btn-success btn-sm">${translation}</button>
                </form>
            ` : `
                <form action="${url}" method="POST">
                    <input type="hidden" name="_token" value="${csrf}">
                    <button type="submit" class="btn btn-sm btn-success btn-sm"><i
                            class="bi bi-cart me-2"></i>${translation}</button>
                </form>
            `

            value += action
            value += `</div>`

            instance.setContent(value);
        },
    });

    elements.forEach(function (element) {
        let cssName = element.classList.item(1)
        element.addEventListener('mouseenter', function () {
            usernameElement.classList.add(cssName)
            usernameElement.classList.remove(lastElement)
        })
        element.addEventListener('mouseleave', function () {
            usernameElement.classList.remove(cssName)
            usernameElement.classList.add(lastElement)
        })
    })
});
