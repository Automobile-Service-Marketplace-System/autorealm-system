import { createServer as createNodeServer } from "http";
import { Server as SocketIOServer } from "socket.io";
import chokidar from "chokidar";

const server = createNodeServer();
const io = new SocketIOServer(server, {
  cors: {
    origin: "http://localhost:3000",
    methods: ["GET", "POST"],
  },
});

io.on("connection", (socket) => {
  console.log("Browser connected: reloading on file change");
});

// directories to watch files in
const dirs = [
  "components",
  "controllers",
  "models",
  "public",
  "core",
  "layouts",
  "views",
  "utils",
];

// start watching files
const watcher = chokidar.watch(dirs, {
  ignored: /(^|[\/\\])\../,
  persistent: true,
});

// on file change, emit event to client
watcher.on("change", (path) => {
  console.log(`File ${path} has been changed`);
  if (path === "public\\css\\style.css") {
    io.emit("css-reload");
  } else {
    io.emit("browser-reload");
  }
});

server.listen(3001, () => {
  console.log("Reloader service started on port 3001");
});
