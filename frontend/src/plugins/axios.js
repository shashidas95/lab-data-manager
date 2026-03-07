import axios from 'axios'

// Configure global defaults
axios.defaults.baseURL = 'http://localhost:8080/api'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

// Optional: Add an interceptor to handle 401 (Unauthorized) errors globally
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      // Logic to redirect to login if session expires
      console.log('Session expired, redirecting...');
    }
    return Promise.reject(error);
  }
);
