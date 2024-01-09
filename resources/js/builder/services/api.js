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

const displayToast = (response) => {
    let toast = response.data.toast
    if (toast) window.toast(toast.type, toast.title, toast.description, toast.duration)
}

// Dans api.js
const apiFunctions = {
    fetchFolders,
    deleteFolder,
    createFolder,
    updateFolder,
    displayToast
};

export default apiFunctions;

