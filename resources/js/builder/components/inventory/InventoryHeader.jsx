import {useState} from "react";
import CreateInventoryModal from "../modals/CreateInventoryModal";

const InventoryHeader = () => {

    const [modalShow, setModalShow] = useState(false);

    const handleModalClose = () => setModalShow(false);
    const handleModalShow = () => setModalShow(true);

    const handleSaveInventory = (inventoryData) => {
        console.log('Saving inventory:', inventoryData);
        handleModalClose();
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
