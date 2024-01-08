import React, {useEffect, useState} from "react";
import api from '../services/api';
import Folder from './folder/Folder';
import Breadcrumb from './folder/Breadcrumb';

const Builder = () => {

    const [folder, setFolder] = useState();
    const [parentFolder, setParentFolder] = useState();
    const [parentHierarchy, setParentHierarchy] = useState();

    useEffect(() => {
        handleFolderClick();
    }, []);

    const handleFolderClick = (folderId = null) => {
        const cacheKey = `folders_${folderId || 'root'}`;
        const cachedData = localStorage.getItem(cacheKey);

        if (cachedData) {
            const data = JSON.parse(cachedData);
            const now = new Date();
            if (data.expiry > now.getTime()) {
                console.log(data.parentHierarchy)
                setFolder(data.folder);
                setParentFolder(data.parentFolder);
                setParentHierarchy(data.parentHierarchy);
                return
            }
        }

        api.fetchFolders(folderId).then(response => {
            if (response.data.result === 'success') {
                const folder = response.data.content;
                const parentFolder = response.data.parentFolder;
                const parentHierarchy = response.data.parentHierarchy;

                // Stockage des données dans le cache
                localStorage.setItem(cacheKey, JSON.stringify({
                    folder: folder,
                    parentFolder: parentFolder,
                    parentHierarchy: parentHierarchy,
                    expiry: new Date().getTime() + 1000 * 2, // 10 secondes
                }));

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
        if (parentFolder) handleFolderClick(parentFolder.id);
        else handleFolderClick();
    };

    const handleHomeClick = () => {
        handleFolderClick();
    };

    return (
        <div className={'builder'}>
            <Breadcrumb key={1} parent={parentHierarchy ?? []} folder={folder} onFolderClick={handleFolderClick} />
            <div className={'builder-content'}>

                {folder ? (
                    <div className={'folders'}>
                        <div className={'folders-header'}>
                            <span>{folder.name}.{folder.id}</span>
                            {parentFolder ? (
                                <div>
                                    <button className={'btn btn-sm btn-success'} onClick={handleParentFolderClick}><i
                                        className="bi bi-arrow-90deg-left"></i></button>
                                </div>
                            ) : (
                                <div>
                                    <button className={'btn btn-sm btn-success disabled'}><i
                                        className="bi bi-arrow-90deg-left"></i></button>
                                </div>
                            )}
                        </div>
                        <div className={'folders-content'}>
                            {folder.children?.map((f, index) => (
                                <Folder key={index} folderId={f.id} folderName={f.name}
                                        onFolderClick={handleFolderClick}/>
                            ))}
                        </div>
                    </div>
                ) : (
                    <div>En attente</div>
                )}

                <div className={'builder-inventories'}>
                    <div>
                        <span>d</span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Builder
