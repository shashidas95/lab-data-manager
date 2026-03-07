import { ref } from 'vue';
import axios from 'axios';

export function useCrud(endpoint) {
  const items = ref([]);
  const loading = ref(false);

  const fetchItems = async () => {
    loading.value = true;
    const res = await axios.get(endpoint);
    items.value = res.data;
    loading.value = false;
  };

  const deleteItem = async (id) => {
    if (confirm('Are you sure?')) {
      await axios.delete(`${endpoint}/${id}`);
      await fetchItems();
    }
  };

  return { items, loading, fetchItems, deleteItem };
}
