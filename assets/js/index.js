// import the css file
import "../css/main.css";

// import the js files for each page
import "./views";
// import component related logic
import "./components";
import Notifier from "./components/Notifier";



Notifier.show({
    text: "Hello from javascript",
    header: "Hi, this is an example notification !",
    duration: 6000,
    closable: true,
    type: ["info", "success", "warning", "danger", "dark"][
        Math.floor(Math.random() * 5)
        ],
});
