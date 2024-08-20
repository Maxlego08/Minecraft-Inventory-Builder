window.addEventListener('load', function () {
    let element = document.getElementById('toggle_conversation')
    if (element == null) return

    let cooldown = false;

    element.addEventListener('change', function () {

        if (cooldown) {
            element.checked = !element.checked
            return
        }

        cooldown = true

        let url = element.getAttribute('data-url')
        let formData = new FormData();
        formData.append("is_enable", element.checked);
        formData.append("_token", element.getAttribute('data-token'));
        axios.post(url, formData).then(function (response) {
            setTimeout( function (){
                cooldown = false
            }, 2000)
        })
    })
})
