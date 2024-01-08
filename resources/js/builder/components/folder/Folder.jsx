import React, {useState} from 'react';
import DeleteConfirmationModal from '../modals/DeleteConfirmationModal';

const Folder = ({folderId, folderName, onFolderClick, handleDeleteFolder}) => {

    const [showDeleteModal, setShowDeleteModal] = useState(false);

    const handleClick = () => {
        onFolderClick(folderId);
    };

    const handleGearClick = (event) => {
        // event.stopPropagation()
        console.log("JE CLICK ICI !")
    }

    const handleRename = (event) => {
        event.stopPropagation()
        console.log("JE RENAME")
    }

    const handleDelete = (event) => {
        event.stopPropagation()

        setShowDeleteModal(true);
    }

    const handleCloseModal = () => {
        setShowDeleteModal(false);
    };

    const handleConfirmDelete = () => {
        console.log("Deleting:", folderId);
        setShowDeleteModal(false);

        handleDeleteFolder(folderId)
    };

    return (
        <div className={'folder'} id={`folder-${folderId}`}>
            <div className={'folder-name'} onClick={handleClick}>
                <i className="bi bi-folder me-2"></i> {folderName}
            </div>
            <div className="dropdown">
                <div className={'folder-action ps-2 pe-2'} onClick={handleGearClick} type="button"
                     data-bs-toggle="dropdown" aria-expanded="false">
                    <i className="bi bi-gear"></i>
                </div>
                <ul className="dropdown-menu">
                    <li onClick={handleRename}><span className="dropdown-item">Rename</span></li>
                    <li onClick={handleDelete}><span className="dropdown-item">Delete</span></li>
                    <DeleteConfirmationModal
                        show={showDeleteModal}
                        handleClose={handleCloseModal}
                        handleConfirm={handleConfirmDelete}
                        itemToDelete={folderName}
                    />
                </ul>
            </div>
        </div>
    );
};

export default Folder
