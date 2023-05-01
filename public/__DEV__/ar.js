import {io} from "https://cdn.socket.io/4.3.2/socket.io.esm.min.js";

const styleTag = document.querySelector("style#dev");


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

let lastCssUpdate = 0;

socket.on("css-reload", (arg) => {
    const now = Date.now();
    if (now - lastCssUpdate >= 1000) {
        lastCssUpdate = now;
        styleTag.innerHTML = arg;
        logSuccess("CSS reloaded");
    }
});

socket.on("browser-reload", () => {
    const now = Date.now();
    if (now - lastCssUpdate >= 1000) {
        logWarning("Change detected, reloading...");
        hardRefresh();
    }
});


function hardRefresh() {
    const t = parseInt(Date.now() / 10000); //10s tics
    const x = localStorage.getItem("t");
    localStorage.setItem("t", t);

    if (x != t) location.reload(true) //force page refresh from server
    else { //refreshed from server within 10s
        const a = document.querySelectorAll("a, link, script, img")
        var n = a.length
        while (n--) {
            var tag = a[n]
            var url = new URL(tag.href || tag.src);
            url.searchParams.set('r', t.toString());
            tag.href = url.toString(); //a, link, ...
            tag.src = tag.href; //rerun script, refresh img
        }
    }
}
