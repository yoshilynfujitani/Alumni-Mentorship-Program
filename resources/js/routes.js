import App from "@/component/App.vue";

import Login from "@/pages/Login.vue";
import Signup from "@/pages/Signup.vue";
import AppointmentForm from "@/component/StudentComponents/AppointmentForm.vue";
import Mentors from "@/pages/Mentors.vue";

import PDCApp from "@/pages/PDCPages/PDCApp.vue";
import PDCMentors from "@/pages/PDCPages/PDCMentors.vue";
import PDCStudents from "@/pages/PDCPages/PDCStudents.vue";
import PDCStudentTickets from "@/pages/PDCPages/PDCStudentTickets.vue";
import PDCPendingMentors from "@/pages/PDCPages/PDCPendingMentors.vue";
import MentorStudentRequests from "@/pages/MentorPages/MentorStudentRequests.vue";
import MentorApp from "@/pages/MentorPages/MentorApp.vue";
import Conversation from "@/pages/Conversation.vue";
import MentorConversation from "@/pages/MentorPages/MentorConversation.vue";
import ScheduleHistory from "@/pages/MentorPages/ScheduleHistory.vue";
import Appointments from "@/pages/Appointments.vue";
import TicketLogsStudent from "@/pages/TicketLogsStudent.vue";
import AlumniInvite from "@/pages/PDCPages/AlumniInvite.vue";
import MentorRequest from "@/pages/PDCPages/MentorRequest.vue";
import PDCConversation from "./pages/PDCPages/PDCConversation.vue";
import { createRouter, createWebHistory } from "vue-router";
import ManagePDC from "./pages/PDCPages/ManagePDC.vue";
import LayoutStudent from "./Layout/LayoutStudent.vue";
import LayoutMentor from "./Layout/LayoutMentor.vue";
import LayoutEmployee from "./Layout/LayoutEmployee.vue";

// Define routes
export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
    {
        path: "/student",
        component: LayoutStudent,
        children: [
            { path: "home", component: App },
            {
                path: "appointments",
                name: "appointments",
                component: Appointments,
            },
            {
                path: "mentors",
                name: "mentors",
                component: Mentors,
            },
            {
                path: "studenttickets",
                name: "studenttickets",
                component: TicketLogsStudent,
            },
            {
                path: "chat/:id?",
                name: "chat",
                component: Conversation,
            },
        ],
    },
    {
        path: "/mentor",
        component: LayoutMentor,
        children: [
            { path: "home", component: MentorApp },
            {
                path: "studentrequests",
                name: "mentorstudentrequests",
                component: MentorStudentRequests,
            },
            {
                path: "chat/:id?",
                name: "mentorchat",
                component: MentorConversation,
            },
            {
                path: "schedule",
                name: "schedule",
                component: ScheduleHistory,
            },
            {
                path: "request",
                name: "mentorrequest",
                component: MentorRequest,
            },
        ],
    },
    {
        path: "/admin",
        component: LayoutEmployee,
        children: [
            { path: "home", component: PDCApp },
            {
                path: "mentors",
                name: "pdcmentors",
                component: PDCMentors,
            },
            {
                path: "students",
                name: "pdcstudents",
                component: PDCStudents,
            },
            {
                path: "studenttickets",
                name: "pdcstudenttickets",
                component: PDCStudentTickets,
            },
            {
                path: "pendingmentors",
                name: "pendingmentors",
                component: PDCPendingMentors,
            },
            {
                path: "allconvo",
                name: "allconvo",
                component: PDCConversation,
            },
            {
                path: "alumniinvite",
                name: "alumniinvite",
                component: AlumniInvite,
            },
            {
                path: "managepdc",
                name: "managepdc",
                component: ManagePDC,
            },
        ],
    },
];

// Create and export the router
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
