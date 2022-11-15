import { defineConfig } from "vite";
import compress from "rollup-plugin-brotli";
import dotenv from "dotenv";

dotenv.config();

export default defineConfig({
  plugins: process.env.MODE === "development" ? [] : [compress()],
  build: {
    sourcemap: process.env.MODE === "development" ? true : false,
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
