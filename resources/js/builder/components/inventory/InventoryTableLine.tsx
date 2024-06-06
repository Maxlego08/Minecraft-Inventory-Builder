import {useEffect, useRef, useState} from "react";
import api from "../../services/api"
import DeleteConfirmationModal from '../modals/DeleteConfirmationModal';
import CopyConfirmationModal from '../modals/CopyConfirmationModal';
import date from '../../services/dateFormat'
import color from '../../services/minecraftColor'
import InventoryVisibility from "./InventoryVisibility";
import DOMPurify from 'dompurify';

const InventoryCard = ({inventory, handleDeleteInventory, handleCopyInventory, updateInventory}) => {

    const [inventoryName, setInventoryName] = useState(inventory.file_name);
    const [isEditing, setIsEditing] = useState(false);
    const [editedName, setEditedName] = useState(inventory.file_name);
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [showCopyModal, setShowCopyModal] = useState(false);
    const wrapperRef = useRef(null);

    useEffect(() => {
        setInventoryName(inventory.file_name)
    }, [inventory])

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
        if (oldName === currentName) return

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

    const handleCopy = (event) => {
        event.stopPropagation()
        setShowCopyModal(true);
    }

    const handleConfirmDelete = () => {
        setShowDeleteModal(false);
        handleDeleteInventory(inventory.id)
    };

    const handleConfirmCopy = () => {
        setShowCopyModal(false);
        handleCopyInventory(inventory.id)
    };

    return (

        <tr ref={wrapperRef}>
            <td>
                <input className="form-check-input" type="checkbox" value="" id="select"/>
            </td>
            <td>
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
                    <span className={'actions-element'} onClick={handleEditClick}>{inventoryName}</span>
                )}
            </td>
            <td dangerouslySetInnerHTML={{__html: inventory.name ? DOMPurify.sanitize(color.processMinecraftColorCodes(inventory.name)) : 'Inventory'}}></td>
            <td>{inventory.size}</td>
            <td>
                <InventoryVisibility inventory={inventory} updateInventory={updateInventory}/>
            </td>
            <td>{date.formatDate(inventory.created_at)}</td>
            <td>{date.formatDate(inventory.updated_at)}</td>
            <td>
                <div className={'inventory-table-content-actions'}>
                    <a className={'actions-element'} href={`/builder/inventory/${inventory.id}#builder`}>
                        <i className="bi bi-pencil-square"/>
                    </a>
                    <div className={'actions-element'} onClick={handleCopy}>
                        <i className="bi bi-copy"/>
                    </div>
                    <div className={'actions-element'} onClick={handleDelete}>
                        <i className="bi bi-trash text-danger"/>
                    </div>
                    <DeleteConfirmationModal
                        show={showDeleteModal}
                        handleClose={() => setShowDeleteModal(false)}
                        handleConfirm={handleConfirmDelete}
                        itemToDelete={inventory.file_name}
                    />
                    <CopyConfirmationModal
                        show={showCopyModal}
                        handleClose={() => setShowCopyModal(false)}
                        handleConfirm={handleConfirmCopy}
                        itemToDelete={inventory.file_name}
                    />
                </div>
            </td>
        </tr>
    )

}

export default InventoryCard
