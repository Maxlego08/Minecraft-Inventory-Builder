import {useState} from "react";

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
        console.log("Finish edit name:", editedName)
        console.log("Old Name:", inventory.file_name)

        setInventoryName(editedName)
    };

    return (
        <div className={'inventory-card'}>
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
                <div className={'inventory-card-actions-element'}>
                    <i className="bi bi-pencil-square"/>
                </div>
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
