import {useRef, useState} from "react";
import api from "../../services/api"
import DeleteConfirmationModal from '../modals/DeleteConfirmationModal';
import date from '../../services/dateFormat'
import color from '../../services/minecraftColor'
import InventoryVisibility from "./InventoryVisibility";
import DOMPurify from 'dompurify';

const InventoryCard = ({inventory, handleDeleteInventory, updateInventory}) => {

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

        <tr ref={wrapperRef}>
            <td>
                <input className="form-check-input" type="checkbox" value="" id="select" />
            </td>
            <td>{inventory.file_name}</td>
            <td dangerouslySetInnerHTML={{__html: inventory.name ? DOMPurify.sanitize(color.processMinecraftColorCodes(inventory.name)) : 'Inventory'}}></td>
            <td>{inventory.size}</td>
            <td>
                <InventoryVisibility inventory={inventory} updateInventory={updateInventory}/>
            </td>
            <td>{date.formatDate(inventory.created_at)}</td>
            <td>{date.formatDate(inventory.updated_at)}</td>
            <td className={'inventory-table-content-actions'}>
                <a className={'actions-element'} href={`/builder/inventory/${inventory.id}#builder`}>
                    <i className="bi bi-pencil-square"/>
                </a>
                <div className={'actions-element'}>
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
            </td>
        </tr>
    )

}

export default InventoryCard
