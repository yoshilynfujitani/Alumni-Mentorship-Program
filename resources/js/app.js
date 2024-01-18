import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";
import { createStore } from "vuex";
import App from "@/component/App.vue";
import { setupCalendar } from "v-calendar";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout1 from "@/Layout/Layout1.vue";
import LayoutMentor from "@/Layout/LayoutMentor.vue";
import LayoutEmployee from "@/Layout/LayoutEmployee.vue";

import store from "../Store/store";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const app = createApp({});

app.use(router);
app.use(store);

app.component("app", App);
app.component("Layout", Layout1);
app.component("LayoutMentor", LayoutMentor);
app.component("LayoutPDC", LayoutEmployee);
app.use(setupCalendar, {});

store.dispatch("initializeStoreAction").then(() => {
    app.mount("#app");
});
