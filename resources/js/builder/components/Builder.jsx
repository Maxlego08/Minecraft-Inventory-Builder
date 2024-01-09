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

    /**
     * Permet de récupérer le contenu d'un dossier
     *
     * @param folderId
     */
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

    /**
     * Permet d'effectuer le clic sur le dossier parent, si le dossier parent n'existe pas alors effectuer le clic pour aller au fichier home
     */
    const handleParentFolderClick = () => {
        if (parentFolder) handleFolderClick(parentFolder.id);
        else handleFolderClick();
    };

    /**
     * Permet de supprimer un dossier
     *
     * @param folderId
     * @returns {Promise<void>}
     */
    const handleDeleteFolder = async (folderId) => {
        try {
            const response = await api.deleteFolder(folderId);
            api.displayToast(response);

            if (response.data.result === 'success') {
                setFolder(prevFolder => ({
                    ...prevFolder,
                    children: prevFolder.children.filter(item => item.id !== folderId)
                }));

                localStorage.clear();
            }
        } catch (error) {
            console.error("Error deleting folder:", error);
            window.toast('error', 'Error !', `Error deleting folder: ${error}`, 5000)
        }
    };


    /**
     * Permet d'éditer le nom d'un dossier
     *
     * @param folderId
     * @param folderName
     * @returns {Promise<void>}
     */
    const handleEditFolder = async (folderId, folderName) => {
        try {
            const formData = new FormData();
            formData.append('folderName', folderName);

            const response = await api.updateFolder(formData, folderId);
            api.displayToast(response);

            if (response.data.result === 'success') {
                const updatedFolder = response.data.folder;

                setFolder(prevFolder => ({
                    ...prevFolder,
                    children: prevFolder.children.map(child =>
                        child.id === updatedFolder.id
                            ? {...child, name: updatedFolder.name}
                            : child
                    )
                }));

                localStorage.clear();
            }
        } catch (error) {
            console.error("Error updating folder:", error);
            window.toast('error', 'Error !', `Error updating folder: ${error}`, 5000)
        }
    };


    /**
     * Permet de créer un nouveau dossier
     *
     * @param folderName
     * @returns {Promise<void>}
     */
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
                        <div className="d-flex justify-content-center mt-5">
                            <div className="spinner-folder">
                                <div className="rect1"/>
                                <div className="rect2"/>
                                <div className="rect3"/>
                                <div className="rect4"/>
                                <div className="rect5"/>
                            </div>
                        </div>
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
