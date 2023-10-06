import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build: {
    rollupOptions: {
      input: "src/backend/main.js",
      output: {
        dir: "./assets/",
        entryFileNames: "js/bundle.js",
        assetFileNames: "css/style.css",
        chunkFileNames: "js/chunk.js",
        manualChunks: undefined,
      },
    },
  },
  watch: {
    rollupOptions: {
      input: "src/backend/main.js",
      output: {
        dir: "./assets/",
        entryFileNames: "js/bundle.js",
        assetFileNames: "css/style.css",
        chunkFileNames: "js/chunk.js",
        manualChunks: undefined,
      },
    },
  },
});
