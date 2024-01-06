import React from "react";
import ReactDOM from 'react-dom/client'
import FolderList from './components/folder/FolderList.jsx'

const container = document.getElementById('builder')
const root = ReactDOM.createRoot(container)
root.render(<FolderList />)
