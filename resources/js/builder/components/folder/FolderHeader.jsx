import React, {useState} from 'react';
import CreateFolderModal from '../modals/CreateFolderModal';

const FolderHeader = ({handleParentFolder, parent, createFolder}) => {

    const [modalShow, setModalShow] = useState(false);

    const handleCreateFolder = (folderName) => {
        setModalShow(false);
        createFolder(folderName)
    };

    const handleParentFolderClick = () => {
        handleParentFolder()
    }

    const handleCloseModal = () => {
        console.log("CLOSE CREATE")
        setModalShow(false)
    }

    const handleOpenModal = () => {
        console.log("OPEN CREATE")
        setModalShow(true)
    }

    return (
        <div className={'folders-header'}>
            <div className={'action'} onClick={handleOpenModal}>
                <i className="bi bi-plus-lg"/>
            </div>
            <CreateFolderModal
                show={modalShow}
                handleClose={handleCloseModal}
                onCreate={handleCreateFolder}
            />
            {parent ? (
                <div className={'action'} onClick={handleParentFolderClick}>
                    <i className="bi bi-arrow-90deg-left"></i>
                </div>
            ) : (
                <div className={'action action-disable'}>
                    <i className="bi bi-arrow-90deg-left"></i>
                </div>
            )}
        </div>
    )

}

export default FolderHeader
