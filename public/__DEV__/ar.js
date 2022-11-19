import { io } from "https://cdn.socket.io/4.3.2/socket.io.esm.min.js";

const socket = io("ws://localhost:3001");

const logSuccess = (arg) =>
  console.log(
    `%c[AR]: %c${arg}`,
    "color: rgb(0, 197, 138);font-weight: bold;",
    "font-weight: thin;"
  );

const logWarning = (arg) =>
  console.log(
    `%c[AR]: %c${arg}`,
    "color: rgb(250, 187, 65);font-weight: bold;",
    "font-weight: thin;"
  );

const logError = (arg) =>
  console.log(
    `%c[AR]: %c${arg}`,
    "color: rgb(229, 48, 48);font-weight: bold;",
    "font-weight: thin;"
  );

logWarning("Attempting to connect ...");

let error = false;

socket.on("connect", () => {
  if (error) {
    location.reload();
  }
  logSuccess("Connected to socket server");
});

socket.on("disconnect", () => {
  logError("Disconnected from socket server");
  error = true;
});

socket.on("browser-reload", () => {
  logWarning("Change detected, reloading...");
  window.location.reload();
});
