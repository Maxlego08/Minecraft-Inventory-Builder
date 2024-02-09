import axios from 'axios';

const getCsrfToken = () => {
    const tokenElement = document.querySelector('meta[name="csrf-token"]');

    if (tokenElement) {
        return tokenElement.getAttribute('content');
    } else {
        console.error('CSRF token not found');
        return '';
    }
};

const apiClient = axios.create({
    baseURL: import.meta.env.VITE_REACT_APP_API_URL,
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
    }
});

/**
 * Permet de récupérer la liste des dossiers
 *
 * @param folderId
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
const fetchFolders = (folderId = null) => {
    return apiClient.get(folderId ? `/folders/${folderId}` : '/folders');
};

/**
 * Permet de supprimer un dossier
 *
 * @param folderId
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
const deleteFolder = (folderId = null) => {
    return apiClient.post(`/folders/${folderId}/delete`);
};

/**
 * Permet de créer un nouveau dossier
 *
 * @param formData
 * @param folderId
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
const createFolder = (formData, folderId) => {
    return apiClient.post(`/folders/create/${folderId}`, formData);
};

/**
 * Permet de mettre à jour le nom d'un dossier
 *
 * @param formData
 * @param folderId
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
const updateFolder = (formData, folderId) => {
    return apiClient.post(`/folders/update/${folderId}`, formData);
};

const createInventory = (formData, folderId) => {
    return apiClient.post(`/inventories/${folderId}/create`, formData);
};

const updateInventory = (formData, inventoryId) => {
    return apiClient.post(`/inventories/${inventoryId}/update`, formData);
};

const fetchInventories = (folderId) => {
    return apiClient.get(`/inventories/${folderId}`);
};


const fetchItems = () => {
    return apiClient.get(`/items/all`);
};

const displayToast = (response) => {
    let toast = response.data.toast
    if (toast) window.toast(toast.type, toast.title, toast.description, toast.duration)
}

const apiFunctions = {
    fetchFolders,
    deleteFolder,
    createFolder,
    updateFolder,
    displayToast,
    createInventory,
    updateInventory,
    fetchInventories,
    fetchItems,
};

export default apiFunctions;

