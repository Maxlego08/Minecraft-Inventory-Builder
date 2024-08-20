window.addEventListener('load', function () {

    let element = document.getElementById('username');
    let baseUrl = element.getAttribute('data-url')
    element.addEventListener('input', function (event) {
        searchUser(event, baseUrl)
    });

    /**
     * Async search user
     *
     * @param e
     * @returns {Promise<void>}
     */
    async function searchUser(e, baseUrl) {
        let search = e.target.value;
        let element = document.getElementById('result');

        if (search.length === 0) {
            removeAllChildNodes(element);
            return;
        }

        let url = `${baseUrl}?name=${search}`
        const response = await axios.get(url);
        let json = response.data;

        if (json.length === 0) {
            removeAllChildNodes(element);
            return;
        }

        removeAllChildNodes(element);
        element.style.display = 'flex';

        for (const user of json) {
            let newElement = document.createElement('span');
            let startSearch = user.name.substring(0, search.length);
            let endSearch = user.name.substring(search.length);
            newElement.innerHTML = '<strong class="text-white">' + startSearch + '</strong>' + endSearch;
            newElement.className = 'text-secondary';
            newElement.style.cursor = "pointer";
            newElement.addEventListener('click', function () {
                let element = document.getElementById('username');
                element.value = user.name;
                let currentElement = document.getElementById('result');
                removeAllChildNodes(currentElement);
            })
            element.appendChild(newElement);
        }
    }

    /**
     * Remove child from nodes
     *
     * @param parent
     */
    function removeAllChildNodes(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
        parent.style.display = 'none';
    }

})
