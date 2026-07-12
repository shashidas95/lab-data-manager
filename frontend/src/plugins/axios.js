import axios from 'axios'
import router from '../router'

// Configure global defaults
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

// Intercept requests to add the Authorization token
axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

// Intercept responses to handle 401 (Unauthorized) errors globally
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      console.log('Session expired or unauthorized, clearing local storage and redirecting to login...');
      localStorage.removeItem('token');
      localStorage.removeItem('user');

      // Redirect to login if not already there
      if (router.currentRoute.value.name !== 'login') {
        router.push('/login');
      }
    }
    return Promise.reject(error);
  }
);
