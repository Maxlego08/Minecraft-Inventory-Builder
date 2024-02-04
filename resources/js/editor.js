import axios from "axios";

window.textarea = null;
/**
 * Add image to textarea
 *
 * @param id
 */
window.addImage = function (id) {
    let instance = sceditor.instance(window.textarea);
    let bbcode = `[img]${id}[/img]`;
    instance.insert(bbcode);
}

window.addEventListener('load', function () {
    let element = document.getElementById('description');

    if (element == null) return

    window.textarea = element;
    let assetUrl = import.meta.env.VITE_URL_ASSET;
    sceditor.create(textarea, {
        format: 'bbcode',
        width: '100%',
        icons: 'material',
        emoticonsEnabled: false,
        resizeEnabled: false,
        style: `${assetUrl}css/theme.css`,
        // toolbar: 'bold,italic,underline|size,font,color|left,center,right|link,unlink,youtube|source,preview|image,code',
        toolbar: 'bold,italic,underline,strike|size,font,color|bulletlist,orderedlist|left,center,right|link,unlink,youtube|source,preview',
        // locale: 'fr-FR',
        plugins: 'undo',
    });

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let uploadElement = document.getElementById('image-upload');
    let contentElement = document.getElementById('images');
    let barElement = document.getElementById('bar');
    let progressElement = document.getElementById('progress');

    uploadElement.addEventListener('change', function (event) {
        progressElement.style.display = "block";

        let formData = new FormData();
        let files = event.target.files;

        if (files.length === 0) return;

        for (let i = 0; i < files.length; i++) {
            formData.append("images[]", files[i]);
        }
        formData.append("_token", token);
        axios.post(import.meta.env.VITE_URL_UPLOAD_IMAGE, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: function (progressEvent) {
                if (progressEvent.lengthComputable) {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    barElement.style.width = percentCompleted + '%';
                }
            }
        }).then(function (response) {
            resetAndSendToast(response.data.toast);
            if (response.data.status === 'success') {
                let elements = response.data.elements;
                elements.forEach(function (element) {
                    let elementUrl = element.url;
                    let elementName = element.name;
                    let input = '<div class="p-1">';
                    input += `<img src='${elementUrl}' onclick="addImage('${elementName}')" height="50" style="max-height: 50px; cursor: pointer" alt="Image ${elementName}">`
                    input += '</div>';

                    const newElement = document.createElement('div');
                    newElement.innerHTML = input;

                    contentElement.appendChild(newElement);
                });
            }
        });
    });

    /**
     * Reset and send toast to user
     * @param toast
     */
    function resetAndSendToast(toast) {
        progressElement.style.display = "none";
        barElement.style.width = '0%';
        window.toast(toast.type, toast.title, toast.description, toast.duration);
    }
});

window.textEditor = function (token, upload = true) {

    window.textarea = document.getElementById('description');
    let assetUrl = process.env.MIX_URL_ASSET;
    sceditor.create(textarea, {
        format: 'bbcode',
        width: '100%',
        icons: 'material',
        emoticonsEnabled: false,
        resizeEnabled: false,
        style: `${assetUrl}css/theme.css`,
        toolbar: 'bold,italic,underline|size,font,color|left,center,right|link,unlink,youtube|source,preview',
        locale: 'fr-FR',
        plugins: 'undo',
    });

    if (!upload)
        return;

    /*let uploadElement = document.getElementById('image-upload');
    let contentElement = document.getElementById('image-content');
    let barElement = document.getElementById('bar');
    let progressElement = document.getElementById('progress');

    // Upload event
    uploadElement.addEventListener('change', function (event) {
        progressElement.style.display = "block";

        let formData = new FormData();
        let image = event.target.files[0];
        formData.append("image", image);
        formData.append("_token", token);
        axios.post(process.env.MIX_URL_UPLOAD_IMAGE, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: function (progressEvent) {
                if (progressEvent.lengthComputable) {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    barElement.style.width = percentCompleted + '%';
                }
            }
        }).then(function (response) {
            resetAndSendToast(response.data.toast);
            if (response.data.status === 'success') {
                let elementUrl = response.data.element.url;
                let elementName = response.data.element.name;
                let input = '<div class="image-media">';
                input += `<a href="${elementUrl}" target="_blank">`;
                input += `<img src="${elementUrl}" alt="Media ${elementName}" title="Media ${elementName}">`;
                input += '</a>';
                input += '<div class="image-media-description">';
                input += `<span title="Ajouter l'image" onclick="addImage('${elementName}')">Ajouter</span>`;
                input += '</div>';
                input += '</div>';

                const newElement = document.createElement('div');
                newElement.innerHTML = input;

                contentElement.appendChild(newElement);
            }
        }).catch(function (response) {
            console.log(response)
            if (response.data.toast != null)
                resetAndSendToast(response.data.toast);
        });
    });*/

    /**
     * Reset and send toast to user
     * @param toast
     */
    /*function resetAndSendToast(toast) {
        progressElement.style.display = "none";
        barElement.style.width = '0%';
        createToast(toast.type, toast.title, toast.description, toast.duration);
    }*/

}
