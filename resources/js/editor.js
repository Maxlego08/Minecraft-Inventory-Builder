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

window.addEventListener('load', function (){
    window.textarea = document.getElementById('description');
    let assetUrl = import.meta.env.VITE_URL_ASSET;
    console.log(`${assetUrl}css/theme.css`)
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
