import Modal from 'bootstrap/js/dist/modal';

window.addEventListener('load', () => {

    const checkboxes = document.querySelectorAll('.image-checkbox');

    if (checkboxes.length === 0) return

    const deleteButton = document.getElementById('deleteSelectedButton');
    const confirmDeleteButton = document.getElementById('confirmDeleteAll');
    const deleteModalAll = document.getElementById('deleteModalAll');

    function updateDeleteButtonVisibility() {
        const isAnyCheckboxChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        deleteButton.style.display = isAnyCheckboxChecked ? 'block' : 'none';
    }

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateDeleteButtonVisibility);
    });

    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            const isChecked = this.checked;
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = isChecked;
            });
            updateDeleteButtonVisibility();
        });
    }

    confirmDeleteButton.addEventListener('click', () => {

        let url = confirmDeleteButton.getAttribute('data-url')
        let token = confirmDeleteButton.getAttribute('data-token')

        let formData = new FormData()
        formData.append('_token', token)

        let ids = []
        for (let i = 0; i < checkboxes.length; i++) {
            let element = checkboxes.item(i)
            let imageId = element.getAttribute('data-id')
            if (element.checked) {
                ids.push(`image-${imageId}`)
                formData.append("images[]", imageId);
            }
        }

        axios.post(url, formData).then(response => {
            let toast = response.data.toast
            if (toast) window.toast(toast.type, toast.title, toast.description, toast.duration)
            removeElementsById(ids)

            let modal = Modal.getInstance(deleteModalAll)
            modal.toggle();
        });
    });

    window.addEventListener('hidden.bs.modal', function () {

        let backdrops = document.querySelectorAll('.modal-backdrop.fade.show');
        backdrops.forEach(function (backdrop) {
            backdrop.remove();
        });

        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '0';
    });

    function removeElementsById(ids) {
        ids.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.parentNode.removeChild(element);
            }
        });
    }


})
