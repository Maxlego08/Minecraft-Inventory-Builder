let lastClickTime = 0;

function fadeIn(element, duration) {
    let op = 0;  // initial opacity
    const interval = 50; // ms between each frame
    const step = interval / duration; // amount to increase opacity by at each step

    const timer = setInterval(() => {
        if (op >= 1) clearInterval(timer); // stop when fully opaque
        element.style.opacity = op;
        op += step; // increase opacity
    }, interval);
}


window.addEventListener('load', function () {
    document.querySelectorAll('.like-button').forEach(button => {
        let parentElement = button.parentNode.parentNode.parentNode
        let elementLikes = parentElement.querySelector('#likes')
        let url = elementLikes.getAttribute('data-url')
        let token = elementLikes.getAttribute('data-token')
        button.addEventListener('click', function () {
            toggleLike(url, this, token,);
        });

        function toggleLike(url, currentElement, token) {
            const currentTime = new Date().getTime();
            if (currentTime - lastClickTime < 1000) return;

            let elementLike = parentElement.querySelector('#like')
            let elementUnlike = parentElement.querySelector('#unlike')
            let elementLikes = parentElement.querySelector('#likes')

            currentElement.classList.add('cursor-load')

            lastClickTime = currentTime;

            let formatData = new FormData()
            formatData.append('_token', token)
            axios.post(url, formatData).then(response => {

                let value = response.data.message
                currentElement.classList.remove('cursor-load')

                if (value === 'added') {
                    elementLike.style.display = 'none';

                    elementUnlike.style.opacity = '0'
                    elementUnlike.style.display = 'block';
                    fadeIn(elementUnlike, 1000)
                } else {
                    elementUnlike.style.display = 'none';

                    elementLike.style.opacity = '0';
                    elementLike.style.display = 'block';
                    fadeIn(elementLike, 1000)

                }

                elementLikes.innerHTML = response.data.likes
                elementLikes.style.opacity = '0';
                fadeIn(elementLikes, 1000)

            }).catch(error => {
                console.error('Une erreur est survenue', error);
            });
        }
    });
});
