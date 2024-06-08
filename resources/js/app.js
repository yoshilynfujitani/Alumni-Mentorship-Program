import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";
import { createStore } from "vuex";
import PrimeVue from "primevue/config";
import App from "@/component/App.vue";
import { setupCalendar } from "v-calendar";

//in main.js
import "primevue/resources/themes/aura-light-green/theme.css";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout from "@/Layout/LayoutStudent.vue";
import LayoutMentor from "@/Layout/LayoutMentor.vue";
import LayoutEmployee from "@/Layout/LayoutEmployee.vue";
import "primevue/resources/themes/aura-light-green/theme.css";
import ConfirmationService from "primevue/confirmationservice";
import ToastService from "primevue/toastservice";
import store from "../Store/store";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const app = createApp({});

app.use(router);
app.use(store);

app.component("app", App);
app.component("Layout", Layout);
app.component("LayoutMentor", LayoutMentor);
app.component("LayoutPDC", LayoutEmployee);
app.use(setupCalendar, {});
app.use(PrimeVue);
app.use(ConfirmationService);
app.use(ToastService);

store.dispatch("initializeStoreAction").then(() => {
    app.mount("#app");
});
