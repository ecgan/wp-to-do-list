import { createRoot } from "@wordpress/element";
import { App } from "./App";

window.addEventListener(
  "load",
  function () {
    const rootDomElement = document.getElementById("wptdl_app");
    const root = createRoot(rootDomElement);
    root.render(<App />);
  },
  false
);
