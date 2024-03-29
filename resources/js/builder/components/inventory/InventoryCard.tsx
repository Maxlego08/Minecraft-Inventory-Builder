import {useRef, useState} from "react";
import api from "../../services/api"
import DeleteConfirmationModal from '../modals/DeleteConfirmationModal';

const InventoryCard = ({inventory, handleDeleteInventory}) => {

    const [inventoryName, setInventoryName] = useState(inventory.file_name);
    const [isEditing, setIsEditing] = useState(false);
    const [editedName, setEditedName] = useState(inventory.file_name);
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const wrapperRef = useRef(null);

    const handleEditClick = () => {
        setIsEditing(true);
    };

    const handleNameChange = (e) => {
        setEditedName(e.target.value);
    };

    const handleFinishEdit = () => {
        setIsEditing(false);
        let oldName = inventoryName

        let currentName = editedName
        if (editedName.length === 0) currentName = 'inventory'
        if (editedName.length > 100) currentName = 'too long'

        setEditedName(currentName)
        setInventoryName(currentName)

        api.renameInventory(inventory.id, editedName).then(response => {
            api.displayToast(response)
        }).catch(() => {
            setEditedName(oldName)
            setInventoryName(oldName)
        })
    };

    const handleDelete = (event) => {
        event.stopPropagation()
        setShowDeleteModal(true);
    }

    const handleConfirmDelete = () => {
        setShowDeleteModal(false);
        handleDeleteInventory(inventory.id)
    };

    return (
        <div className={'inventory-card rounded-1'} ref={wrapperRef}>
            <div className={'inventory-card-header'}>
                {isEditing ? (
                    <input
                        type="text"
                        minLength={1}
                        maxLength={100}
                        value={editedName}
                        onChange={handleNameChange}
                        onBlur={handleFinishEdit}
                        className={'form-control rounded-0'}
                        autoFocus
                    />
                ) : (
                    <span onClick={handleEditClick}>{inventoryName}</span>
                )}
            </div>
            <div className={'inventory-card-actions'}>
                <a className={'inventory-card-actions-element'} href={`/builder/inventory/${inventory.id}#builder`}>
                    <i className="bi bi-pencil-square"/>
                </a>
                <div className={'inventory-card-actions-element'}>
                    <i className="bi bi-copy"/>
                </div>
                <div className={'inventory-card-actions-element'} onClick={handleDelete}>
                    <i className="bi bi-trash text-danger"/>
                </div>
                <DeleteConfirmationModal
                    show={showDeleteModal}
                    handleClose={() => setShowDeleteModal(false)}
                    handleConfirm={handleConfirmDelete}
                    itemToDelete={inventory.file_name}
                />
            </div>
        </div>
    )

}

export default InventoryCard
