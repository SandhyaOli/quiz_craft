import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  // build on ../public location   
  server: {
    proxy: {
     '/api': {
				target: 'http://127.0.0.1:8000',
				changeOrigin: true,
				secure: false,
			},
    }
  },
  build: {
		rollupOptions: {
			output: {
				manualChunks(id) {
					if ((id ).indexOf('node_modules') !== -1) {
						return (id)
							.toString()
							.split('node_modules/')[1]
							.split('/')[0]
							.toString()
					}
				},
			},
		},
		chunkSizeWarningLimit: 600,
		// build on ../public location
		outDir: '../public',
	},
})
