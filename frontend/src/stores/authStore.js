import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
    loading: false,
    error: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    currentUser: (state) => state.user,
  },

  actions: {
    async login(email, password) {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.post('/login', { email, password });
        const { user, token } = response.data;

        this.token = token;
        this.user = user;

        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));

        return true;
      } catch (err) {
        this.error = err.response?.data?.message || err.response?.data?.errors?.email?.[0] || 'Invalid credentials or connection error.';
        console.error('Login error:', err);
        throw err;
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      this.loading = true;
      try {
        await axios.post('/logout');
      } catch (err) {
        console.error('Logout error on backend:', err);
      } finally {
        this.token = null;
        this.user = null;
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.loading = false;
      }
    },

    async fetchCurrentUser() {
      if (!this.token) return;
      try {
        const response = await axios.get('/user');
        this.user = response.data;
        localStorage.setItem('user', JSON.stringify(response.data));
      } catch (err) {
        console.error('Failed to fetch user, logging out...', err);
        this.token = null;
        this.user = null;
        localStorage.removeItem('token');
        localStorage.removeItem('user');
      }
    }
  }
});
