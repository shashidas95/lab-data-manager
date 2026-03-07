import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './style.css'; // If using Tailwind
import App from './App.vue'
import router from './router'
// Import Axios configuration
import './plugins/axios'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
