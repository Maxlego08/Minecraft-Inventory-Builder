import React, {useEffect, useState} from "react";
import api from '../services/api';
import Folder from './folder/Folder';
import Breadcrumb from './folder/Breadcrumb';
import FolderHeader from "./folder/FolderHeader";

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
                    expiry: new Date().getTime() + (import.meta.env.VITE_APP_ENV ?? 'prod' === 'local' ? 1000 * 5 : 1000 * 60),
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

    const handleDeleteFolder = (folderId) => {
        console.log("Deleting folder", folderId);

        api.deleteFolder(folderId).then(response => {
            let result = response.data.result
            let toast = response.data.toast
            window.toast(toast.type, toast.title, toast.description, toast.duration)

            if (result === 'success') {
                let newFolder = {...folder};
                newFolder.children = newFolder.children.filter(item => item.id !== folderId);
                setFolder(newFolder);
            }
        })
    };

    const createFolder = (folderName) => {

        let formatData = new FormData()
        formatData.append('folderName', folderName)

        api.createFolder(formatData, folder.id).then(response => {
            let toast = response.data.toast
            window.toast(toast.type, toast.title, toast.description, toast.duration)

            if (response.data.result === 'success') {
                let newFolder = {...folder};
                console.log(newFolder.children)
                newFolder.children.push(response.data.folder)
                setFolder(newFolder);
            }
        })

    }

    return (
        <div className={'builder'}>
            <Breadcrumb key={1} parent={parentHierarchy ?? []} folder={folder} onFolderClick={handleFolderClick}/>
            <div className={'builder-content'}>
                <div className={'folders'}>
                    {folder ? (
                        <div>
                            <FolderHeader handleParentFolder={handleParentFolderClick} parent={parentFolder} createFolder={createFolder}/>
                            <div className={'folders-content'}>
                                {folder.children?.map((f, index) => (
                                    <Folder key={index} folderId={f.id} folderName={f.name}
                                            onFolderClick={handleFolderClick} handleDeleteFolder={handleDeleteFolder}/>
                                ))}
                            </div>
                        </div>
                    ) : (
                        /* Ajouter une animation de chargement */
                        <div>En attente</div>
                    )}
                </div>
                <div className={'builder-inventories'}>
                    {/* TODO */}
                </div>
            </div>
        </div>
    );
};

export default Builder
