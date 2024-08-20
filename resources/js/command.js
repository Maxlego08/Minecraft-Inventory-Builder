import axios from "axios";
import ClipboardJS from "clipboard";

window.isClick = false
window.addEventListener('load', function () {

    let element = document.getElementById('command-copy')
    if (element == null) return

    element.addEventListener('click', function () {

        if (window.isClick) return

        window.isClick = true

        let assetUrl = import.meta.env.VITE_URL_ASSET;
        element.style.cursor = "process";
        axios({
            method: 'post',
            url: `${assetUrl}profile/command`,
            data: {
                _token: document.getElementsByName('_token').value,
            }
        }).then(response => {

            let text = `/zmenu login ${response.data}`
            element.innerHTML = text
            element.classList.remove('blurred');
            element.classList.add('unblurred');

            let clipboard = new ClipboardJS('#command-copy', {
                text(elem) {
                    return text
                }
            });
            clipboard.on('success', function(e) {
                window.toast('success', 'Success', 'Copied text', 1000)
                e.clearSelection();
            });
        })
    })

})
