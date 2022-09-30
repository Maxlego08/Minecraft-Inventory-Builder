import axios from "axios";


let openedAt = 0
window.addEventListener('load', function () {

    let alertDropdown = document.getElementById('alertDropdown')
    alertDropdown.addEventListener('shown.bs.dropdown', function () {

        if (openedAt > new Date().getTime()) {
            return
        }

        openedAt = new Date().getTime() + (1000 * 10)

        console.log("show 2")

        /*axios.get('/test').then(function (result) {

        })*/

    })

});
