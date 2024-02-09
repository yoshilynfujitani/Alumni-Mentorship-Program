<template>
    <Layout :key="refetchData">
        <!-- <h1>{{ console.log(props.fieldToTake) }}</h1> -->

        <div class="" v-if="loading"><h1>Loading...</h1></div>

        <div class="w-full my-10">
            <!-- <div class="w-full mb-2.5 bg-gray-50">
                <Menubar :model="items" />
            </div> -->
            <div
                class="bg-white mb-5 p-2.5 rounded-md flex justify-center items-center w-full gap-5"
            >
                <Message severity="info" :closable="false"
                    >To be able to request appointments from a mentor you must
                    first request a ticket to PDC. Once approve you will be
                    recommended to mentors with your requested field and make
                    appointments
                </Message>
                <Modal
                    v-if="this.ticketStatus === 2 || this.ticketStatus === null"
                    :modalContent="{
                        title: 'Request Ticket',
                        content: 'Please fill out the form below:',
                        disableSaveBtn: this.selectedField === 0,
                    }"
                    buttonLabel="Request to PDC"
                    cancelLabel="Cancel Ticket"
                    saveLabel="Submit Ticket"
                    @save="sendTicket"
                >
                    <div class="my-4">
                        <label
                            for="field"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Select a field to request</label
                        >
                        <div class="card flex justify-content-center">
                            <Dropdown
                                v-model="selectedField"
                                :options="this.courses"
                                :highlightOnSelect="false"
                                optionLabel="name"
                                placeholder="Select a field"
                                class="w-full md:w-14rem"
                            />
                        </div>
                    </div>
                </Modal>
            </div>
            <h1>Dashboard</h1>
            <div class="flex gap-10 mb-10 w-full">
                <div class="w-1/3"><PieChart /></div>
                <div class="w-2/3"><BarChart /></div>
            </div>

            <!-- <div class="" v-if="this.ticketStatus === null">Loading...</div> -->
            <div class="flex justify-center items-center">
                <div
                    class="text-center text-sm my-5 shadow-sm"
                    v-if="this.ticketStatus === 1"
                >
                    <p
                        class="bg-green-100 mx-auto text-green-700 px-4 py-2 rounded-md flex items-center gap-2 justify-center"
                    >
                        <AkCircleCheck />Your request was approved.
                        <span class="underline cursor-pointer"
                            >Look for mentors.</span
                        >
                    </p>
                </div>
                <div
                    class="text-center text-sm my-5 shadow-sm"
                    v-if="this.ticketStatus === 0"
                >
                    <p
                        class="bg-yellow-100 mx-auto text-yellow-700 px-4 py-2 rounded-md flex items-center gap-2 justify-center"
                    >
                        <FlFilledWarning />Your request is being verified.
                        Please wait
                    </p>
                </div>
                <div
                    class="text-center text-sm my-5 shadow-sm"
                    v-if="this.ticketStatus === 2"
                >
                    <p
                        class="bg-red-100 mx-auto text-red-700 px-4 py-2 rounded-md flex items-center gap-2 justify-center"
                    >
                        <AkCircleCheck />Your request was rejected. Please make
                        another request to the PDC or contact them directly.
                    </p>
                </div>
            </div>
            <h1>Overview</h1>
            <div
                class="bg-white w-full overflow-x-clip min-h-[975px] py-10 flex flex-col justify-between shadow-sm sm:rounded-lg border border-gray-200"
                :class="{ 'min-h-[100px]': this.appointments?.length === 0 }"
            >
                <div class="w-full">
                    <div
                        class="px-16 w-full flex items-center justify-center gap-10"
                    >
                        <!-- <DatePicker
                            expanded
                            borderless
                            :attributes="attributes"
                        /> -->

                        <Calendar
                            v-model="date"
                            inline
                            showWeek
                            :numberOfMonths="1"
                            :minDate="minDate"
                        />
                        <div class="">
                            <h1 class="pb-5">User Statistics</h1>
                            <div
                                class="grid lg:grid-cols-2 gap-5 w-full h-full grid-cols-1"
                            >
                                <div
                                    class="border border-gray-200 rounded-md p-5 h-full"
                                >
                                    <h1>Total Appointments</h1>
                                    <p>{{ this.TotalAppointments }}</p>
                                </div>
                                <div
                                    class="border border-gray-200 rounded-md p-5 h-full"
                                >
                                    <h1>Rating</h1>
                                    <p>{{ this.TotalAppointments }}</p>
                                </div>
                                <div
                                    class="border border-gray-200 rounded-md p-5 h-full"
                                >
                                    <h1>Ongoing Appointments</h1>
                                    <p>{{ this.TotalAppointments }}</p>
                                </div>
                                <div
                                    class="border border-gray-200 rounded-md p-5 h-full"
                                >
                                    <h1>View Feedbacks</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table
                        class="bg-white w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <caption
                            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                        >
                            Your Appointments
                        </caption>

                        <thead
                            v-if="this.appointments?.length > 0"
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Request Title
                                </th>
                                <th scope="col" class="px-6 py-3">Field</th>
                                <th scope="col" class="px-6 py-3">
                                    Start Date
                                </th>
                                <th scope="col" class="px-6 py-3">Mentor</th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Others
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="appointment in appointments"
                                class="bg-white dark:bg-gray-800 dark:border-gray-700"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ appointment.title }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ appointment.field }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ appointment.startSchedule }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ appointment.name }}
                                </td>
                                <td class="">
                                    <h1
                                        v-if="appointment.Status === 0"
                                        class="text-white font-bold bg-yellow-400 py-2 px-4 rounded-md text-center"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 1"
                                        class="text-white font-bold bg-green-400 py-2 px-4 rounded-md text-center"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 2"
                                        class="text-white font-bold bg-red-400 py-2 px-4 rounded-md text-center"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 3"
                                        class="text-white font-bold bg-green-600 py-2 px-4 rounded-md text-center"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                </td>
                                <td
                                    class="px-6 py-4 flex items-center justify-center gap-2"
                                >
                                    <button
                                        :disabled="appointment.Status !== 3"
                                        :class="{
                                            'cursor-not-allowed':
                                                appointment.Status !== 3,
                                        }"
                                    >
                                        <FeedbackForm
                                            :appointmentId="
                                                appointment.appointmentId
                                            "
                                            :mentorId="appointment.mentorId"
                                            :disable="appointment.Status !== 3"
                                        />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="my-5" v-if="this.appointments?.length > 0">
                    <Pagination
                        @next="goToNextPage"
                        @back="goToPrevPage"
                        :total="this.pagination?.total"
                        :current_page="this.pagination?.current_page"
                        :last_page="this.pagination?.last_page"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Calendar from "primevue/calendar";
import { mapState, mapActions } from "vuex";
import PieChart from "../Charts/PieChart.vue";
import BarChart from "../Charts/BarChart.vue";
import Pagination from "../utils/Pagination.vue";
import Dropdown from "primevue/dropdown";
import Menubar from "primevue/menubar";
import Message from "primevue/message";

import Modal from "./Modal.vue";
import Chat from "./Chat.vue";
import FeedbackForm from "./StudentComponents/FeedbackForm.vue";
import { FlFilledWarning } from "@kalimahapps/vue-icons";
import { AkCircleCheck } from "@kalimahapps/vue-icons";
import { AnOutlinedCloseCircle } from "@kalimahapps/vue-icons";

export default {
    components: {
        Calendar,
        Menubar,
        Modal,
        FlFilledWarning,
        AkCircleCheck,
        AnOutlinedCloseCircle,
        PieChart,
        BarChart,
        Chat,
        FeedbackForm,
        Pagination,
        Dropdown,
        Message,
    },
    data() {
        return {
            refetchData: 0,
            appointments: [],
            loading: false,
            selectedField: null,
            attributes: [
                {
                    key: 1,

                    content: "green",

                    dot: true,

                    order: 0,
                },
            ],
            userName: "",
            pagination: null,
            ticketIsLoading: true,
            courses: [
                { id: 1, name: "Business Management" },
                { id: 2, name: "Creative Arts" },
                { id: 3, name: "Engineering and Mathematics" },
                { id: 4, name: "Humanities Arts and Social Sciences" },
                { id: 5, name: "IT and Computer Science" },
                { id: 6, name: " Medical and Health Science" },
                { id: 7, name: "Teaching and Education" },
                { id: 8, name: "Leadership and Team Building" },
            ],
            minDate: null,
            TotalAppointments: 0,
            items: [
                {
                    label: "Home",
                    icon: "pi pi-home",
                },
                {
                    label: "Features",
                    icon: "pi pi-star",
                },
            ],
        };
    },
    computed: {
        ...mapState([
            "userId",
            "ticketStatus",
            "fieldToTake",
            "allowToAppoint",
        ]),
    },
    methods: {
        ...mapActions(["setUserTicketStatusAction"]),
        getAppointments() {
            this.loading = true;
            axios.get("/getOngoingAppointments").then(({ data }) => {
                this.appointments = data.data;
                this.pagination = data;
                console.log(data);
                this.attributes[0].dates = data.data.map(
                    (appointment) => new Date(appointment.startSchedule)
                );
                this.loading = false;
            });
        },
        getCountTotalAppointments() {
            axios.get("/getCountTotalAppointments").then(({ data }) => {
                console.log(data);
                this.TotalAppointments = data;
                this.loading = false;
            });
        },

        sendTicket() {
            const fieldId = parseInt(this.selectedField.id);
            axios.post("/requestticket", { fieldId }).then(({ data }) => {
                this.setUserTicketStatusAction();
                // this.forceRerender();
            });
        },

        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                const prevPage = this.pagination.current_page - 1;
                this.fetchRequests(prevPage);
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                const nextPage = this.pagination.current_page + 1;
                this.fetchRequests(nextPage);
            }
        },
        fetchRequests(page) {
            this.isLoading = true;

            axios
                .get(`/getOngoingAppointments?page=${page}`)
                .then(({ data }) => {
                    console.log(data);

                    this.appointments = data.data;
                    this.pagination = data;
                })
                .catch((error) => {
                    console.error("Error fetching mentors:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        getToday() {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set hours to 00:00:00 for accurate comparison
            return today;
        },
    },

    created() {
        this.getAppointments();
    },
    mounted() {
        // this.refecthAppointments();
        this.setUserTicketStatusAction();
        console.log(this.userId);
        this.minDate = this.getToday();
        this.getCountTotalAppointments();
        // console.log(this.$store.getters.userDetails);
    },
    watch: {
        authenticated(newValue) {
            if (!newValue) {
                this.$router.push("/login");
            }
        },
    },
};
</script>
<style>
.p-message-text {
    font-size: 14px;
}
</style>
