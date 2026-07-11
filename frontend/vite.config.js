import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      'html5-qrcode': fileURLToPath(new URL('./node_modules/html5-qrcode/cjs/index.js', import.meta.url)),
    },
  },
})
