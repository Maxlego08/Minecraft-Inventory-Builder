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

const fetchFolders = (serverId = null) => {
    return apiClient.get(serverId ? `/folders/${serverId}` : '/folders');
};

// Dans api.js
const apiFunctions = {
    fetchFolders
};

export default apiFunctions;

