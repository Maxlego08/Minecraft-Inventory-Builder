window.addEventListener('load', function () {
    const exampleModal = document.getElementById('reviewModal');

    if (exampleModal == null) return

    let elementButton = document.getElementById('rate-submit')
    let elementTextarea = document.getElementById('message')

    elementTextarea.addEventListener('keyup', function () {
        if (elementTextarea.value.length >= 30) {
            elementButton.classList.remove("disabled")
        } else {
            if (!elementButton.classList.contains('disabled')) {
                elementButton.classList.add('disabled')
            }
        }
    })

    exampleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const recipient = button.getAttribute('data-bs-whatever')
        const modalBodyInput = exampleModal.querySelector('.modal-body input')
        modalBodyInput.value = recipient
        const reviewStar = exampleModal.querySelector('.text-warning')
        reviewStar.setAttribute('data-percent', ((recipient * 100) / 5))
    })
})
