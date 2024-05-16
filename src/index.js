import { createRoot } from "@wordpress/element";

const App = () => {
  return <div>App </div>;
};

window.addEventListener(
  "load",
  function () {
    const rootDomElement = document.getElementById("wptdl_app");
    const root = createRoot(rootDomElement);
    root.render(<App />);
  },
  false
);
