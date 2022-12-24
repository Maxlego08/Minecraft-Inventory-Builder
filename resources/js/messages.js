import axios from "axios";


let openedAt = 0
window.addEventListener('load', function () {

    let alertDropdown = document.getElementById('messageDropdown')
    alertDropdown.addEventListener('shown.bs.dropdown', function () {

        if (openedAt > new Date().getTime()) {
            return
        }

        openedAt = new Date().getTime() + (1000 * 60 * 5)
        let element = document.getElementById('messages')
        let alertCount = document.getElementById('message-count')
        let assetUrl = import.meta.env.VITE_URL_ASSET;
        element.innerHTML = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
        axios({
            method: 'post',
            url: `${assetUrl}profile/messages`,
            data: {
                _token: document.getElementsByName('_token').value,
            }
        }).then(response => {
            console.log(response.data)
            element.innerHTML = response.data
            alertCount.innerHTML = '';
        })
    })

});
