import React from "react";
import ReactDOM from 'react-dom/client'
import InventoryBuilder from './inventory/InventoryBuilder'

const container = document.getElementById('builder')
const root = ReactDOM.createRoot(container)
root.render(<InventoryBuilder />)
