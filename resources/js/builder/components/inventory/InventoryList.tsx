import * as React from "react";
import {useEffect, useRef, useState} from "react";
import InventoryHeader from './InventoryHeader'
import Loader from "../utils/Loader";
import api from '../../services/api';
import InventoryCard from "./InventoryCard";
import {Form} from "react-bootstrap";
import InventoryTableLine from "./InventoryTableLine";

const InventoryList = ({folder = null}) => {

    const [inventories, setInventories] = useState(null);
    const [data, setData] = useState([]);
    const [sortConfig, setSortConfig] = useState({key: 'created_at', direction: 'ascending'});
    const wrapperRef = useRef(null);


    useEffect(() => {
        setInventories(null);
        fetchInventories();
    }, [folder]);

    useEffect(() => {
        setData(inventories ?? [])
        // sortData('created_at')
    }, [inventories])

    const fetchInventories = () => {

        if (!folder) return

        api.fetchInventories(folder.id).then(response => {
            if (response.data.result === 'success') {
                const inventories = response.data.inventories;
                setInventories(inventories)
            }
        }).catch(error => {
            console.log(error);
        });
    }

    const sortData = (key) => {
        let direction = 'ascending';
        if (sortConfig.key === key && sortConfig.direction === 'ascending') {
            direction = 'descending';
        }

        const sortedData = [...data].sort((a, b) => {
            if (a[key] < b[key]) {
                return direction === 'ascending' ? -1 : 1;
            }
            if (a[key] > b[key]) {
                return direction === 'ascending' ? 1 : -1;
            }
            return 0;
        });
        setData(sortedData);
        setSortConfig({key, direction});
    };

    const getClassName = (key) => `sort${sortConfig.key === key ? ' sort-current' : ''}`;

    const getArrow = (key) => sortConfig.key !== key ? '' : sortConfig.direction === 'ascending' ?
        <i className="bi bi-arrow-down"></i> : <i className="bi bi-arrow-up"></i>

    // @ts-ignore
    const handleCreateInventory = async (formData: FormData) => {
        try {
            const response = await api.createInventory(formData, folder.id)
            api.displayToast(response)

            if (response.data.result === 'success') {
                // @ts-ignore
                setInventories(currentInventories => [
                    // @ts-ignore
                    ...currentInventories,
                    response.data.inventory
                ]);
            }
        } catch (error) {
            console.error("Error deleting folder:", error);
            // @ts-ignore
            window.toast('error', 'Error !', `Error deleting folder: ${error}`, 5000)
        }
    }

    const handleDeleteInventory = (inventoryId) => {
        api.deleteInventory(inventoryId).then(response => {
            api.displayToast(response)

            setInventories(currentInventories =>
                // @ts-ignore
                currentInventories.filter(inventory => inventory.id !== inventoryId)
            );
        })
    }


    return (
        <div className={'inventories'} ref={wrapperRef}>
            <InventoryHeader createInventory={handleCreateInventory}/>

            <div className={'inventory-table'}>

                <div className={'inventory-table-search'}>
                    <div className={'search-icon'}>
                        <i className="bi bi-filter"></i>
                    </div>
                    <div className={'search-bar'}>
                        <Form.Control
                            type="text"
                            value={''}
                            placeholder={'Filter'}
                            onChange={(e) => {

                            }}
                            className={'rounded-0'}
                        />
                    </div>
                </div>
                <hr/>
                <div className={'inventory-table-content'}>
                    <table className="table table-responsive table-striped table-hover">
                        <thead>
                        <tr>
                            <th className={'select'}></th>
                            <th className={getClassName('file_name')} onClick={() => sortData('file_name')}>File
                                Name {getArrow('file_name')}</th>
                            <th className={getClassName('name')}
                                onClick={() => sortData('name')}>Name {getArrow('name')}</th>
                            <th className={getClassName('size')}
                                onClick={() => sortData('size')}>Size {getArrow('size')}</th>
                            <th className={getClassName('inventory_visibility_id')}
                                onClick={() => sortData('inventory_visibility_id')}>Visibility {getArrow('inventory_visibility_id')}</th>
                            <th className={getClassName('created_at')} onClick={() => sortData('created_at')}>Created
                                at {getArrow('created_at')}</th>
                            <th className={getClassName('updated_at')} onClick={() => sortData('updated_at')}>Updated
                                at {getArrow('updated_at')}</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {data.map((inventory, index) => (
                            <InventoryTableLine key={`${index}-${folder.id}`} inventory={inventory}
                                                handleDeleteInventory={handleDeleteInventory}/>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}

export default InventoryList
