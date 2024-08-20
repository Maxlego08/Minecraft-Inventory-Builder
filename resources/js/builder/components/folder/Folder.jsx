import React, {useRef, useState} from 'react';
import DeleteConfirmationModal from '../modals/DeleteConfirmationModal';
import EditFolderModal from "../modals/EditFolderModal";

const Folder = ({folderId, folderName, onFolderClick, handleDeleteFolder, handleEditFolder}) => {

    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const wrapperRef = useRef(null);

    const handleClick = () => {
        onFolderClick(folderId);
    };

    const handleGearClick = (event) => {
        // event.stopPropagation()
    }

    const handleRename = (event) => {
        event.stopPropagation()
        setShowEditModal(true)
    }

    const handleDelete = (event) => {
        event.stopPropagation()
        setShowDeleteModal(true);
    }

    const handleConfirmDelete = () => {
        setShowDeleteModal(false);
        handleDeleteFolder(folderId)
    };

    const handleEditName = (newName) => {
        setShowEditModal(false);
        handleEditFolder(folderId, newName)
    };

    return (
        <div className={'folder'} id={`folder-${folderId}`} ref={wrapperRef}>
            <div className={'folder-name'} onClick={handleClick}>
                <i className="bi bi-folder me-2"/> {folderName}
            </div>
            <div className="dropdown">
                <div className={'folder-action ps-2 pe-2 rotatable'} onClick={handleGearClick} type="button"
                     data-bs-toggle="dropdown" aria-expanded="false">
                    <i className="bi bi-gear"/>
                </div>
                <ul className="dropdown-menu">
                    <li onClick={handleRename}><span className="dropdown-item">Rename</span></li>
                    <li onClick={handleDelete}><span className="dropdown-item">Delete</span></li>
                    <DeleteConfirmationModal
                        show={showDeleteModal}
                        handleClose={() => setShowDeleteModal(false)}
                        handleConfirm={handleConfirmDelete}
                        itemToDelete={folderName}
                    />
                    <EditFolderModal
                        show={showEditModal}
                        handleClose={() => setShowEditModal(false)}
                        onSave={handleEditName}
                        folder={folderName}
                    />
                </ul>
            </div>
        </div>
    );
};

export default Folder
