import './tata';
import './bootstrap';
import './alerts'
import './editor'
import './messages'
import './command'
import './discord'
import './review'
import './gift'
import './tippy'
import './discord_webhook'
import './conversations'
import './like'
import './ImageDeleteAll.js'
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import hljs from 'highlight.js/lib/core';
import javascript from 'highlight.js/lib/languages/javascript';
import yaml from 'highlight.js/lib/languages/yaml';
import java from 'highlight.js/lib/languages/java';

// Then register the languages you need

import "@melloware/coloris/dist/coloris.css";
import Coloris from "@melloware/coloris";

Coloris.init();
Coloris({
    el: "#coloris",
    alpha: false,
    themeMode: 'dark',
    format: 'hex',
});

window.addEventListener('load', () => {
    hljs.registerLanguage('javascript', javascript);
    hljs.registerLanguage('yaml', yaml);
    hljs.registerLanguage('java', java);
    hljs.highlightAll()
})
