import {useState} from "react";
import Items from "./components/Items";
import api from '../services/api';
const Inventory = () => {

    const [data, setData] = useState(window.Content || {});

    return (
        <div className={'inventory-builder'}>

            <Items versions={data.versions} />

        </div>
    );
}

export default Inventory
