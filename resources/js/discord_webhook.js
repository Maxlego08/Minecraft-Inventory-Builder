window.addEventListener('load', function () {

    let element = document.getElementById('add-embed')
    if (element == null) return
    let embeds = document.getElementById('embeds')

    embeds.querySelectorAll('.remove-embed').forEach(function (element) {
        let parent = element.parentNode.parentNode.parentNode
        element.addEventListener('click', function () {
            embeds.removeChild(parent)
        })
    });

    element.addEventListener('click', function () {

        let formEmbed = `
<div>
<hr>
<div class="row">
    <div class="col-6 mb-3">
            <label class="form-check-label" for="title">${embeds.getAttribute('data-name-title')}</label>
            <input type="text" class="form-control rounded-1" id="title"
                   name="title[]">
    </div>
    <div class="col-6 mb-3">
            <label class="form-check-label" for="url_embed">${embeds.getAttribute('data-name-url')}</label>
            <input type="text" class="form-control rounded-1" id="url_embed"
                   name="url_embed[]">
    </div>
</div>
<div class="row">
    <div class="col-6 mb-3">
            <label class="form-check-label"
                   for="thumbnail">${embeds.getAttribute('data-name-thumbnail')}</label>
            <input type="text" class="form-control rounded-1" id="thumbnail"
                   name="thumbnail[]">
    </div>
    <div class="col-6 mb-3">
            <label class="form-check-label" for="footer">${embeds.getAttribute('data-name-footer')}</label>
            <input type="text" class="form-control rounded-1" id="footer"
                   name="footer[]">
    </div>
</div>

<div class="mb-3">
    <label for="description">${embeds.getAttribute('data-name-description')}</label>
    <textarea id="description" name="description[]"
              class="form-control rounded-1"
              rows="3"></textarea>
</div>

<div class="row">
    <div class="col-6 mb-3">
            <label for="color" class="form-check-label">${embeds.getAttribute('data-name-color')}</label>
            <input type="text" class="form-control rounded-1" id="color" name="color[]"
                   value="#33c79d" data-coloris required
                   title="Choose your color">
        </div>
    </div>
    <div class="col-6 d-flex justify-content-end align-items-end mb-3">
        <span class="btn btn-sm btn-danger remove-embed"><i class="bi bi-trash me-2"></i>Delete</span>
    </div>
</div>
</div>
`

        const newElement = document.createElement('div');
        newElement.innerHTML = formEmbed;
        newElement.classList.add('mb-3')
        embeds.appendChild(newElement)

        newElement.querySelectorAll('.remove-embed').forEach(function (element) {
            element.addEventListener('click', function () {
                embeds.removeChild(newElement)
            })
        });
    })

});
