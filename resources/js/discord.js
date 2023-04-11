window.addEventListener('load', async function () {
    let element = document.getElementById("discord_server_id");
    let url = element.getAttribute('data-url');
    const response = await axios.get(url);
    element.setAttribute("href", response.data.invite);
})
