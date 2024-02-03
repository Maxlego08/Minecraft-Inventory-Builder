const minecraftColorCodes = {
    '&0': 'black',       // Black
    '&1': '#0000AA',     // Dark Blue
    '&2': '#00AA00',     // Dark Green
    '&3': '#00AAAA',     // Dark Aqua
    '&4': '#AA0000',     // Dark Red
    '&5': '#AA00AA',     // Dark Purple
    '&6': '#FFAA00',     // Gold
    '&7': '#AAAAAA',     // Gray
    '&8': '#555555',     // Dark Gray
    '&9': '#5555FF',     // Blue
    '&a': '#55FF55',     // Green
    '&b': '#55FFFF',     // Aqua
    '&c': '#FF5555',     // Red
    '&d': '#FF55FF',     // Light Purple
    '&e': '#FFFF55',     // Yellow
    '&f': 'white',       // White
    '&r': '',            // Reset
};

const translateMiniMessage = (text) => {
    // Translate MiniMessage tags into HTML
    return text
        .replace(/<([a-z]+|#[\da-fA-F]{6})>/g, (match, color) => `<span style="color:${color};">`)
        .replace(/<\/[a-z]+>/g, () => '</span>');
};

const processMinecraftColorCodes = (text) => {

    let processedText = translateMiniMessage(text);
    return processedText.split(/(&[0-9a-fr]|#[\da-fA-F]{6})/)
        .reduce((acc, part) => {
            if (part.startsWith('&') && minecraftColorCodes.hasOwnProperty(part)) {
                acc.currentColor = minecraftColorCodes[part];
                return acc;
            } else if (part.match(/#[\da-fA-F]{6}/)) {
                acc.currentColor = part;
                return acc;
            }

            if (acc.currentColor) {
                acc.html += `<span style="color:${acc.currentColor}">${part}</span>`;
            } else {
                acc.html += part;
            }

            return acc;
        }, {html: '', currentColor: ''})
        .html;
};


const apiFunctions = {
    processMinecraftColorCodes,
};

export default apiFunctions;
