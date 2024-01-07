import React from 'react';

const Folder = ({folderId, folderName, onFolderClick }) => {

    const handleClick = () => {
        onFolderClick(folderId);
    };

    return (
        <div style={{cursor: 'pointer', fontWeight: 'bold'}} onClick={handleClick}>
            {folderName} - {folderId}
        </div>
    );
};

export default Folder
