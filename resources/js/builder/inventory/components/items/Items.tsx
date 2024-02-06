import {useEffect, useState} from "react";
import api from '../../../services/api';
import Item from "./Item";

const Items = ({versions}) => {

    const [items, setItems] = useState([]);
    const [version, setVersion] = useState('');
    const [search, setSearch] = useState('');

    useEffect(() => {
        fetchItems();
    }, [version]);

    const fetchItems = () => {
        api.fetchItems().then(response => {
            setItems(response.data.items)
        }).catch(error => {
            console.log(error);
        });
    }


    const filterAndSortItems = () => {

        if (search == null || search.length === 0) {
            if (version !== '') return items.filter(item => item.version.minecraft_version <= version);
            return items
        }

        const filteredItems = items.filter(item => item.name.toLowerCase().includes(search.toLowerCase()));
        filteredItems.sort((a, b) => a.name.localeCompare(b.name));

        if (version !== '') return filteredItems.filter(item => item.version.minecraft_version <= version);
        return filteredItems;
    }

    return (
        <div className={'sidebar'}>
            <div className="sidebar-header">
                <div className="search">
                    <input
                        type="text"
                        className="form-control rounded-0"
                        placeholder="Item name"
                        id="search-item"
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                    />
                </div>
                <div className="select">
                    <select
                        className="form-select rounded-0"
                        id="select-version"
                        value={version}
                        onChange={(event) => {
                            setVersion(event.target.value)
                        }}
                    >
                        {versions.map((version, index) => (
                            <option key={index} value={version.minecraft_version}>
                                {version.version}
                            </option>
                        ))}
                    </select>
                </div>
            </div>
            <div className="items" id="items">
                {filterAndSortItems().map((item, index) => (
                    <Item item={item} key={index}/>
                ))}
            </div>
        </div>
    )
}

export default Items;
