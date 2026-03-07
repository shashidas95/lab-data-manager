import { defineStore } from 'pinia';
import axios from 'axios';

export const useSampleStore = defineStore('samples', {
  state: () => ({
    samples: [],
    loading: false,
    error: null,
  }),

  getters: {
    // These are reactive and perfect for your Dashboard stats
    totalCount: (state) => state.samples.length,
    pendingCount: (state) => state.samples.filter(s => s.status === 'received').length,
    inProgressCount: (state) => state.samples.filter(s => s.status === 'in_progress').length,

    // Helper to get a sample by its ID for detail views
    getSampleById: (state) => {
      return (id) => state.samples.find(s => s.id === id);
    }
  },

  actions: {
    async fetchSamples() {
      this.loading = true;
      this.error = null;
      try {
        // Ensure your axios.defaults.baseURL is set to http://localhost:8080/api
        const response = await axios.get('/samples');
        this.samples = response.data;
      } catch (err) {
        this.error = 'Failed to load samples from Vesper API';
        console.error("API Error:", err.response?.data || err.message);
      } finally {
        this.loading = false;
      }
    },

    async updateSampleStatus(id, status) {
      try {
        await axios.patch(`/samples/${id}`, { status });
        const index = this.samples.findIndex(s => s.id === id);
        if (index !== -1) {
          this.samples[index].status = status;
        }
      } catch (err) {
        console.error('Status update failed:', err);
      }
    }
  }
});
