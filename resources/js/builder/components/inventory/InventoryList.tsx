import * as React from "react";
import {useEffect, useState} from "react";
import InventoryHeader from './InventoryHeader'
import Loader from "../utils/Loader";
import api from '../../services/api';
import InventoryCard from "./InventoryCard";

const InventoryList = ({folder = null}) => {

    const [inventories, setInventories] = useState();

    useEffect(() => {
        fetchInventories();
    }, [folder]);


    const fetchInventories = () => {

        if (!folder) return

        api.fetchInventories(folder.id).then(response => {
            if (response.data.result === 'success') {
                const inventories = response.data.inventories;
                console.log(inventories)
                setInventories(inventories)
            }
        }).catch(error => {
            console.log(error);
        });
    }

    /**
     *
     * @param formData
     */
        // @ts-ignore
    const handleCreateInventory = async (formData: FormData) => {
            try {
                const response = await api.createInventory(formData, folder.id)
                api.displayToast(response)

                if (response.data.result === 'success') {
                    // ToDo
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
        <div className={'inventories'}>
            <InventoryHeader createInventory={handleCreateInventory}/>
            {inventories ? (
                <div className={'inventories-list'}>
                    {// @ts-ignore
                        inventories?.map((inventory, index) => (
                            <InventoryCard key={index} inventory={inventory}
                                           handleDeleteInventory={handleDeleteInventory}/>
                        ))}
                </div>
            ) : (
                <Loader/>
            )}
        </div>
    )

}

export default InventoryList
