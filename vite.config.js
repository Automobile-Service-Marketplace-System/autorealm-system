import { defineConfig } from "vite";
import compress from "rollup-plugin-brotli";
import dotenv from "dotenv";

dotenv.config();

export default defineConfig({
  plugins: process.env.MODE === "development" ? [] : [compress()],
  css: {
    devSourcemap: process.env.MODE === "development",
  },
  build: {
    sourcemap: process.env.MODE === "development",
    cssCodeSplit: false,
    emptyOutDir: false,
    rollupOptions: {
      input: {
        main: "./assets/js/index.js",
      },
      output: {
        dir: "./public",
        entryFileNames: "js/index.js",
        assetFileNames: "[ext]/[name].[ext]",
        //    disable js chunking
        manualChunks: {},
      },
    },
    // watch: {}
  },
});
