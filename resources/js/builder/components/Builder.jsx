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
                    expiry: new Date().getTime() + (import.meta.env.VITE_APP_ENV ?? 'prod' === 'local' ? 1000 * 5 : 1000 * 60 * 5), // Cache de 5 minutes en production
                }));

                setFolder(folder);
                setParentFolder(parentFolder);
                setParentHierarchy(parentHierarchy);
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
        api.deleteFolder(folderId).then(response => {
            api.displayToast(response)

            if (response.data.result === 'success') {
                let newFolder = {...folder};
                newFolder.children = newFolder.children.filter(item => item.id !== folderId);
                setFolder(newFolder);

                localStorage.clear();
            }
        })
    };

    const handleEditFolder = (folderId, folderName) => {

        let formatData = new FormData()
        formatData.append('folderName', folderName)

        api.updateFolder(formatData, folderId).then(response => {
            api.displayToast(response)

            if (response.data.result === 'success') {
                let newFolder = {...folder};
                let updatedFolder = response.data.folder
                newFolder.children.forEach(value => {
                    if (value.id === updatedFolder.id) {
                        value.name = updatedFolder.name
                    }
                })
                setFolder(newFolder);

                localStorage.clear();
            }
        })
    }

    const createFolder = async (folderName) => {
        try {
            const formData = new FormData();
            formData.append('folderName', folderName);

            const response = await api.createFolder(formData, folder.id);
            api.displayToast(response)

            const {result, folder: newFolderData} = response.data;

            if (result === 'success') {
                setFolder(prevFolder => ({
                    ...prevFolder,
                    children: [...prevFolder.children, newFolderData]
                }));
            }
        } catch (error) {
            console.error("Error creating folder:", error);
            window.toast('error', 'Error !', `Error creating folder: ${error}`, 5000)
        }
    };


    return (
        <div className={'builder'}>
            <Breadcrumb key={1} parent={parentHierarchy ?? []} folder={folder} onFolderClick={handleFolderClick}/>
            <div className={'builder-content'}>
                <div className={'folders'}>
                    {folder ? (
                        <div>
                            <FolderHeader handleParentFolder={handleParentFolderClick} parent={parentFolder}
                                          createFolder={createFolder}/>
                            <div className={'folders-content'}>
                                {folder.children?.map((f, index) => (
                                    <Folder key={index} folderId={f.id} folderName={f.name}
                                            onFolderClick={handleFolderClick} handleDeleteFolder={handleDeleteFolder}
                                            handleEditFolder={handleEditFolder}/>
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
