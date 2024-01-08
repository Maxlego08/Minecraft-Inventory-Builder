import React, {useState} from 'react';
import CreateFolderModal from '../modals/CreateFolderModal';

const FolderHeader = ({handleParentFolder, parent}) => {

    const [modalShow, setModalShow] = useState(false);

    const handleCreateFolder = (folderName) => {
        console.log('Creating folder:', folderName);
        // Logique pour créer le dossier ici
        setModalShow(false);
    };

    const handleParentFolderClick = () => {
        handleParentFolder()
    }

    return (
        <div className={'folders-header'}>
            <div className={'action'} onClick={() => setModalShow(true)}>
                <i className="bi bi-plus-lg"></i>
                <CreateFolderModal
                    show={modalShow}
                    onHide={() => setModalShow(false)}
                    onCreate={handleCreateFolder}
                />
            </div>
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
