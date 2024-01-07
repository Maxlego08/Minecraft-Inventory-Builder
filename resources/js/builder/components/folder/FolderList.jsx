import React, {useEffect, useState} from "react";
import api from '../../services/api';
import Folder from './Folder';

const FolderList = (props) => {
    const [folder, setFolder] = useState();
    const [parentFolder, setParentFolder] = useState();
    const [parentHierarchy, setParentHierarchy] = useState();

    useEffect(() => {
        handleFolderClick();
    }, []);

    const handleFolderClick = (serverId = null) => {
        console.log(serverId);
        api.fetchFolders(serverId).then(response => {
            console.log(response.data);
            if (response.data.result === 'success') {
                const folder = response.data.content;
                const parentFolder = response.data.parentFolder;
                const parentHierarchy = response.data.parentHierarchy;
                setFolder(folder);
                setParentFolder(parentFolder);
                setParentHierarchy(parentHierarchy);
            } else {
                console.log('Error !');
            }
        }).catch(error => {
            console.log(error);
        });
    };

    const handleParentFolderClick = () => {
        if (parentFolder) {
            handleFolderClick(parentFolder.id);
        }
    };

    if (folder) {
        console.log("PARENT")
        console.log(parentFolder)
        console.log("END PARENT")
        return (
            <div style={{padding: '20px'}}>
                <div>
                    <span>{folder.name}.{folder.id}</span>
                </div>
                {parentFolder ? (
                    <div>
                        <button className={'btn btn-sm btn-success'} onClick={handleParentFolderClick}><i className="bi bi-arrow-90deg-left"></i></button>
                    </div>
                ) : (
                    <div>
                        <button className={'btn btn-sm btn-success disabled'}><i className="bi bi-arrow-90deg-left"></i></button>
                    </div>
                )}
                <div style={{margin: '15px'}}>
                    {folder.children?.map((f, index) => (
                        <Folder key={index} folderId={f.id} folderName={f.name} onFolderClick={handleFolderClick}/>
                    ))}
                </div>
            </div>
        )
            ;
    } else {
        return (
            <div>Waiting</div>
        )
    }
};

export default FolderList;
