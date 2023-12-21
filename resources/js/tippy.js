import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

window.addEventListener('load', function () {

    let tooltipsData = {};

// NodeList
    tippy(document.querySelectorAll('.username-tooltip'), {
        content: '<span style="padding: 10px 5px">Loading...</span>',
        arrow: true,
        allowHTML: true,
        interactive: true,
        interactiveBorder: 5,
        zIndex: 99999,
        theme: 'light',
        trigger: "mouseenter click",
        delay: [500, null],
        appendTo: reference => reference.parentNode,
        onShow(instance) {
            let url = instance.reference.getAttribute('data-url');

            if (!tooltipsData[url]) {
                tooltipsData[url] = {lastUpdateAt: 0, content: ""};
            }

            if (tooltipsData[url].lastUpdateAt > Date.now()) {
                instance.setContent(tooltipsData[url].content);
                return;
            }

            tooltipsData[url].lastUpdateAt = Date.now() + 1000 * 60; // 60 secondes de cooldown

            axios.get(url).then((response) => {
                tooltipsData[url].content = response.data;
                instance.setContent(tooltipsData[url].content);
            }).catch((error) => {
                instance.setContent(`Request failed. ${error}`);
            });
        },
    });

    let usernameElement = document.getElementById('user-name')
    if (usernameElement == null) return

    let lastElement = usernameElement.classList.item(2);

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


window.addEventListener('load', function () {

    let usernameElement = document.getElementById('username-history')
    if (usernameElement == null) return

    let names = usernameElement.getAttribute('data-names').split(',')
    let title = usernameElement.getAttribute('data-title')

    tippy(usernameElement, {
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

            let value = `
            <div class="username-history p-2">
            <div class="username-history-title">
                ${title}
            </div>
            <div class="username-history-content">`
            names.forEach(function (name) {
                value += `<span>${name}</span>`
            })
            value += `</div>
    </div>`

            instance.setContent(value);
        },
    });

});
