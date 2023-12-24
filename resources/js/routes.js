import App from "@/component/App.vue";

import Login from "@/pages/Login.vue";
import Signup from "@/pages/Signup.vue";
import AppointmentForm from "@/component/StudentComponents/AppointmentForm.vue";
import Mentors from "@/pages/Mentors.vue";

import PDCApp from "@/pages/PDCPages/PDCApp.vue";
import PDCMentors from "@/pages/PDCPages/PDCMentors.vue";
export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },

    {
        path: "/home",
        name: "home",
        component: App,
    },

    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },

    {
        path: "/appointment/:id",
        name: "appointment",
        component: AppointmentForm,
    },
    {
        path: "/mentors",
        name: "mentors",
        component: Mentors,
    },
    //PDC Routes
    {
        path: "/pdchome",
        name: "pdchome",
        component: PDCApp,
    },
    {
        path: "/pdcmentors",
        name: "pdcmentors",
        component: PDCMentors,
    },
];
