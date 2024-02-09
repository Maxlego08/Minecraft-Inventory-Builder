import {useState} from "react";
import api from "../../services/api"

const InventoryCard = ({inventory}) => {

    const [inventoryName, setInventoryName] = useState(inventory.file_name);
    const [isEditing, setIsEditing] = useState(false);
    const [editedName, setEditedName] = useState(inventory.file_name);

    const handleEditClick = () => {
        setIsEditing(true);
    };

    const handleNameChange = (e) => {
        setEditedName(e.target.value);
    };

    const handleFinishEdit = () => {
        setIsEditing(false);

        api.renameInventory(inventory.id, editedName).then(response => {
            api.displayToast(response)
            if (response.data.result === 'success') {
                setInventoryName(editedName)
            }
        })
    };

    return (
        <div className={'inventory-card rounded-1'}>
            <div className={'inventory-card-header'}>
                {isEditing ? (
                    <input
                        type="text"
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
                <div className={'inventory-card-actions-element'}>
                    <i className="bi bi-trash text-danger"/>
                </div>
            </div>
        </div>
    )

}

export default InventoryCard
