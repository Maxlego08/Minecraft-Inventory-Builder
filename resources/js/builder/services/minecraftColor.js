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
    '&r': 'white',            // Reset
};

const miniMessageColorCode = {
    'black': 'black',       // Black
    'dark_blue': '#0000AA',     // Dark Blue
    'dark_green': '#00AA00',     // Dark Green
    'dark_aqua': '#00AAAA',     // Dark Aqua
    'dark_red': '#AA0000',     // Dark Red
    'dark_purple': '#AA00AA',     // Dark Purple
    'gold': '#FFAA00',     // Gold
    'gray': '#AAAAAA',     // Gray
    'dark_gray': '#555555',     // Dark Gray
    'blue': '#5555FF',     // Blue
    'green': '#55FF55',     // Green
    'aqua': '#55FFFF',     // Aqua
    'red': '#FF5555',     // Red
    'light_purple': '#FF55FF',     // Light Purple
    'yellow': '#FFFF55',     // Yellow
    'white': 'white',       // White
    'reset': 'white',            // Reset
};

const translateMiniMessage = (text) => {
    // Translate MiniMessage tags into HTML
    return text.replace(/<([a-z]+|#[\da-fA-F]{6})>/g, (match, color) => `<span style="color:${miniMessageColorCode[color]};">`)
        .replace(/<\/[a-z]+>/g, () => '</span>');
};

const processMinecraftColorCodes = (text) => {


    text = text.replace(/&l/g, '<span style="font-weight: bold">');
    text = text.replace(/&m/g, '<span style="text-decoration: line-through">');
    text = text.replace(/&n/g, '<span style="text-decoration: underline">');
    text = text.replace(/&o/g, '<span style="font-style: italic">');
    text = text.replace(/&r/g, '<span style="font-style: normal; text-decoration: unset; font-weight: normal; color: white">');
    text = text.replace('<reset>', '<span style="font-style: normal; text-decoration: unset; font-weight: normal; color: white">');

    return translateMiniMessage(text.split(/(&[0-9a-fr]|#[\da-fA-F]{6})/)
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
        }, {html: '', currentColor: ''}).html);
};


const apiFunctions = {
    processMinecraftColorCodes,
};

export default apiFunctions;
