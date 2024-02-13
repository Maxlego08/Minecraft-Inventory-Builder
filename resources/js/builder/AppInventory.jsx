import React from "react";
import ReactDOM from 'react-dom/client'
import InventoryBuilder from './inventory/InventoryBuilder'

const container = document.getElementById('builder')
const root = ReactDOM.createRoot(container)
root.render(<InventoryBuilder />)

import {Modal} from "bootstrap";

window.addEventListener("load", function () {
    console.log("LOAD")
    let monModal = new Modal(document.getElementById('monModal'));
    setTimeout(() => monModal.show(), 1000)
});
