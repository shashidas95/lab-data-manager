import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path' // You might need to install 'path' or use 'fileURLToPath'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
})
