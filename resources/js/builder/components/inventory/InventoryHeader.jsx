import {useState} from "react";
import CreateInventoryModal from "../modals/CreateInventoryModal";

const InventoryHeader = ({createInventory}) => {

    const [modalShow, setModalShow] = useState(false);

    const handleModalClose = () => setModalShow(false);
    const handleModalShow = () => setModalShow(true);

    const handleSaveInventory = (inventoryData) => {
        console.log('Saving inventory:', inventoryData);
        handleModalClose();

        const formData = new FormData();
        formData.append('name', inventoryData.name)
        formData.append('size', inventoryData.size)
        formData.append('file_name', inventoryData.fileName)
        formData.append('update_interval', inventoryData.updateInterval)
        formData.append('clear_inventory', inventoryData.clearInventory)

        createInventory(formData)
    };

    return (
        <div className={'inventories-header'}>
            <div className={'inventories-header-create'} onClick={handleModalShow}>
                <i className="bi bi-plus-lg"/> Create an inventory
            </div>
            <CreateInventoryModal
                show={modalShow}
                handleClose={handleModalClose}
                handleSave={handleSaveInventory}
            />
        </div>
    )

}

export default InventoryHeader
