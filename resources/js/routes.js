import App from "@/component/App.vue";

import Login from "@/pages/Login.vue";
import Signup from "@/pages/Signup.vue";
import AppointmentForm from "@/component/AppointmentForm.vue";
import Mentors from "@/pages/Mentors.vue";
import MentorSignup from "@/pages/MentorAuth/MentorSignup.vue";
import MentorLogin from "@/pages/MentorAuth/MentorLogin.vue";

export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/mentorlogin",
        name: "mentorlogin",
        component: MentorLogin,
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
        path: "/mentorsignup",
        name: "mentorsignup",
        component: MentorSignup,
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
];
