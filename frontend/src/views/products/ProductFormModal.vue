<script setup>
import { ref, onMounted, watch } from 'vue'; // Added watch
import axios from 'axios';

const props = defineProps(['isOpen', 'editData']);
const emit = defineEmits(['close', 'success']);

const manufacturers = ref([]);
const form = ref({
  name: '',
  manufacturer_id: '',
  type: '',
  flavour: '',
  color: 'Standard'
});

// Watch for editData to fill the form when editing
watch(() => props.editData, (newVal) => {
  if (newVal) {
    form.value = { ...newVal };
  } else {
    form.value = { name: '', manufacturer_id: '', type: '', flavour: '', color: 'Standard' };
  }
}, { immediate: true });

onMounted(async () => {
  const res = await axios.get('/manufacturers');
  manufacturers.value = res.data;
});

const handleSubmit = async () => {
  try {
    if (props.editData) {
      await axios.put(`/products/${props.editData.id}`, form.value);
    } else {
      await axios.post('/products', form.value);
    }
    emit('success'); // This triggers fetchProducts in the Parent
    emit('close');
  } catch (err) {
    alert('Failed to save product.');
  }
};
</script>
