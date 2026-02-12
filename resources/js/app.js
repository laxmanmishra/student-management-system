import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
 
Alpine.plugin(persist);
window.Alpine = Alpine;

Alpine.onerror = (error, { expression }) => {
  console.error("Alpine Error:", error);
  console.error("Alpine Expression:", expression);
};

Alpine.start();

import './bootstrap';
import '../css/app.css';


import '../css/tailadmin.css';
import '../js/tailadmin/index.js';