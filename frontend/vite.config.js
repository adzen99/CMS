import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  server: {
    proxy: {
      '/api':{
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, "/api"),
        secure: false,
      },
      // '/login':{
      //   target: 'http://127.0.0.1:8000',
      //   rewrite: (path) => path.replace(/^\/api/, "/api"),
      //   changeOrigin: true,
      //   secure: false,
      // }
    }
  },
  plugins: [vue()],
})
