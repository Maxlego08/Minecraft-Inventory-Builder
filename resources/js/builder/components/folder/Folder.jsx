import React from 'react';

const Folder = ({folderId, folderName, onFolderClick}) => {

    const handleClick = () => {
        onFolderClick(folderId);
    };

    return (
        <div>
            <button onClick={handleClick} className={'btn btn-success btn-sm'}>
                {folderName} - {folderId}
            </button>
        </div>
    );
};

export default Folder
