import React from 'react';

const Folder = ({folderId, folderName, onFolderClick}) => {

    const handleClick = () => {
        onFolderClick(folderId);
    };

    const handleGearClick = (event) => {
        event.stopPropagation()
        console.log("JE CLICK ICI !")
    }

    return (
        <div className={'folder'} onClick={handleClick}>
            <div className={'folder-name'}>
                <i className="bi bi-folder me-2"></i> {folderName}
            </div>
            <div className={'folder-action'} onClick={handleGearClick}>
                <i className="bi bi-gear"></i>
            </div>
        </div>
    );
};

export default Folder
