import App from "@/component/App.vue";

import Login from "@/pages/Login.vue";
import Signup from "@/pages/Signup.vue";
import AppointmentForm from "@/component/StudentComponents/AppointmentForm.vue";
import Mentors from "@/pages/Mentors.vue";

import PDCApp from "@/pages/PDCPages/PDCApp.vue";
import PDCMentors from "@/pages/PDCPages/PDCMentors.vue";
import PDCStudents from "@/pages/PDCPages/PDCStudents.vue";
import PDCStudentTickets from "@/pages/PDCPages/PDCStudentTickets.vue";
import MentorStudentRequests from "@/pages/MentorPages/MentorStudentRequests.vue";
import MentorApp from "@/pages/MentorPages/MentorApp.vue";
import Conversation from "@/pages/Conversation.vue";
import MentorConversation from "@/pages/MentorPages/MentorConversation.vue";
import Appointments from "@/pages/Appointments.vue";
import TicketLogsStudent from "@/pages/TicketLogsStudent.vue";
import AlumniInvite from "@/pages/PDCPages/AlumniInvite.vue";

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
        path: "/chat/:id?",
        name: "chat",
        component: Conversation,
    },
    {
        path: "/mentorchat/:id?",
        name: "mentorchat",
        component: MentorConversation,
    },
    {
        path: "/appointments",
        name: "appointments",
        component: Appointments,
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
    {
        path: "/pdcstudents",
        name: "pdcstudents",
        component: PDCStudents,
    },
    {
        path: "/pdcstudenttickets",
        name: "pdcstudenttickets",
        component: PDCStudentTickets,
    },
    {
        path: "/studenttickets",
        name: "studenttickets",
        component: TicketLogsStudent,
    },
    {
        path: "/alumniinvite",
        name: "alumniinvite",
        component: AlumniInvite,
    },
    //Mentor Routes
    {
        path: "/mentorhome",
        name: "mentorhome",
        component: MentorApp,
    },
    {
        path: "/mentorstudentrequests",
        name: "mentorstudentreuqests",
        component: MentorStudentRequests,
    },
];
