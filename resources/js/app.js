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
import axios from "axios";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const store = createStore({
    state() {
        return {
            ticketStatus: null,
            fieldToTake: null,
            userId: null,
            allowToAppoint: null,
        };
    },
    getters: {
        userDetails(state) {
            return [
                state.ticketStatus,
                state.fieldToTake,
                state.userId,
                state.allowToAppoint,
            ];
        },
    },
    mutations: {
        ["SET_USER_DETAILS"](state, payload) {
            state.ticketStatus = payload.ticketStatus;
            state.fieldToTake = payload.fieldToTake;
            state.userId = payload.userId;
            state.allowToAppoint = payload.allowToAppoint;
            localStorage.setItem("vuex_state", JSON.stringify(state));
        },
        ["SET_VAR_ITEMS"](state, payload) {
            state = { ...state, ...payload };
        },
    },
    actions: {
        setUserDetails({ commit }, data) {
            // commit("SET_USER_DETAILS");
            axios
                .get("/checkuserstatus")
                .then(({ data }) => {
                    console.log(data);
                    commit("SET_USER_DETAILS", data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        initializeStore({ commit }) {
            const storedState = localStorage.getItem("vuex_state");
            if (storedState) {
                const parsedState = JSON.parse(storedState);
                commit("SET_USER_DETAILS", parsedState);
            }
        },
    },
});
const app = createApp({});

app.use(router);
app.use(store);

app.component("app", App);
app.component("Layout", Layout1);
app.component("LayoutMentor", LayoutMentor);
app.component("LayoutPDC", LayoutEmployee);
app.use(setupCalendar, {});

store.dispatch("initializeStore").then(() => {
    app.mount("#app");
});
