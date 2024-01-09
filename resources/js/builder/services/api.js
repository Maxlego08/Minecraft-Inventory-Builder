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

const fetchFolders = (folderId = null) => {
    return apiClient.get(folderId ? `/folders/${folderId}` : '/folders');
};

const deleteFolder = (folderId = null) => {
    return apiClient.post(`/folders/${folderId}/delete`);
};

const createFolder = (formData, folderId) => {
    return apiClient.post(`/folders/create/${folderId}`, formData);
};

// Dans api.js
const apiFunctions = {
    fetchFolders,
    deleteFolder,
    createFolder
};

export default apiFunctions;

