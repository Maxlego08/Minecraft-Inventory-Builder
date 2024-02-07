import React from "react";
import ReactDOM from 'react-dom/client'
import Inventory from './inventory/Inventory'

const container = document.getElementById('builder')
const root = ReactDOM.createRoot(container)
root.render(<Inventory />)
