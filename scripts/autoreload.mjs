import { createServer as createNodeServer } from "http";
import { Server as SocketIOServer } from "socket.io";
import chokidar from "chokidar";
import { readFile } from "fs/promises";

const server = createNodeServer();
const io = new SocketIOServer(server, {
  cors: {
    origin: ["https://autorealm.lk", "https://dashboard.autorealm.lk"],
    methods: ["GET", "POST"],
  },
});

io.on("connection", (socket) => {
  console.log("Browser connected: reloading on file change");
});

// directories to watch files in
const paths = [
  "components",
  "controllers",
  "models",
  `public/index.php`,
  `public/js/index.js`,
  `public/css/style.css`,
  "core",
  "layouts",
  "views",
  "utils",
];

const cssPath = `public/css/style.css`;

// start watching files
const cssWatcher = chokidar.watch(cssPath, {
  persistent: true,
  useFsEvents: true,
  ignoreInitial: true,
});

const otherWatcher = chokidar.watch(paths, {
  persistent: true,
  interval: 100,
  useFsEvents: true,
  ignoreInitial: true,
});

let lastCss = "";

cssWatcher.on("change", async (path) => {
  console.log(`File ${path} has been changed`);
  const content = (await readFile(path, "utf-8")).toString();
  io.emit("css-reload", content);
});

otherWatcher.on("change", async (path) => {
  console.log(`File ${path} has been changed`);
  io.emit("browser-reload");
});

server.listen(3001, () => {
  console.log("Reloading service started on port 3001");
});
