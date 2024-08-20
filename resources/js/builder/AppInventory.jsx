import React from "react";
import ReactDOM from 'react-dom/client'
import InventoryBuilder from './inventory/InventoryBuilder'
import {Modal} from "bootstrap";

const container = document.getElementById('builder')
const root = ReactDOM.createRoot(container)
root.render(<InventoryBuilder/>)

window.addEventListener("load", function () {

    let isLocal = ((import.meta.env.VITE_APP_ENV ?? 'prod') === 'local')
    if (isLocal) return

    let monModal = new Modal(document.getElementById('monModal'));
    setTimeout(() => monModal.show(), 1000)
});
