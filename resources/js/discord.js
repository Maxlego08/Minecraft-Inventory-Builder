window.addEventListener('load', async function () {
    let element = document.getElementById("discord_server_id");
    if (element != null) {
        let url = element.getAttribute('data-url');
        const response = await axios.get(url);
        element.setAttribute("href", response.data.invite);
    }

    let elementBstatsServers = document.getElementById("bstats-players");
    let elementBstatsPlayers = document.getElementById("bstats-servers");
    let elementBstatsUrl = document.getElementById("bstats-url");

    if (elementBstatsServers != null) {
        async function fetchStats(element) {
            let url = element.getAttribute('data-url');
            const response = await axios.get(url);
            element.innerText = response.data
        }

        await fetchStats(elementBstatsPlayers)
        await fetchStats(elementBstatsServers)

        let url = elementBstatsUrl.getAttribute('data-url');
        const response = await axios.get(url);
        elementBstatsUrl.setAttribute("href", response.data);
    }
})
