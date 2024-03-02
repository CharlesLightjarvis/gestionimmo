import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from "vue-router";
import { routes } from "./routes";
import 'bootstrap/dist/css/bootstrap.min.css'
import "@fortawesome/fontawesome-free/css/all.css";
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/lara-light-green/theme.css'
import 'primeicons/primeicons.css'
import store from "./store"

import Dialog from 'primevue/dialog';
import Button from 'primevue/button';


import App from './App.vue'
let app = createApp(App)
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
})

app.component("Dialog", Dialog);
app.component("Button", Button);

app.use(router);
app.use(PrimeVue);
app.use(store);
app.mount("#app")
