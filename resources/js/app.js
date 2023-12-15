import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";
import App from "@/component/App.vue";
import { setupCalendar } from "v-calendar";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout1 from "@/Layout/Layout1.vue";
import LayoutMentor from "@/Layout/LayoutMentor.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const app = createApp({});

app.use(router);

app.component("app", App);
app.component("Layout", Layout1);
app.component("LayoutMentor", LayoutMentor);
app.use(setupCalendar, {});

app.mount("#app");
