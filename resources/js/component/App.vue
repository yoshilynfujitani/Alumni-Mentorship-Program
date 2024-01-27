<template>
    <Layout :key="refetchData">
        <!-- <h1>{{ console.log(props.fieldToTake) }}</h1> -->

        <div class="" v-if="loading"><h1>Loading...</h1></div>

        <div class="w-full">
            <div class="h-20 bg-green-700 rounded-md mb-5 shadow-md">
                Welcome Back! {{ this.userId }}
            </div>
            <div class="flex gap-10 mb-10 w-full">
                <div class="w-1/3"><PieChart /></div>
                <div class="w-2/3"><BarChart /></div>
            </div>
            <p
                class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400"
            >
                To be able to request appointments from a mentor you must first
                request a ticket to PDC. Once approve you will be recommended to
                mentors with your requested field and make appointments
            </p>
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
                <Modal
                    v-if="this.ticketStatus === 2 || this.ticketStatus === null"
                    :modalContent="{
                        title: 'Request Ticket',
                        content: 'Please fill out the form below:',
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
                        <select
                            v-model="selectedField"
                            id="field"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                        >
                            <option value="0" disabled selected>
                                Choose a field
                            </option>
                            <option value="1">Business Management</option>
                            <option value="2">Creative Arts</option>
                            <option value="3">
                                Engineering and Mathematics
                            </option>
                            <option value="4">
                                Humanities Arts and Social Sciences
                            </option>
                            <option value="5">IT and Computer Science</option>
                            <option value="6">
                                Medical and Health Science
                            </option>
                            <option value="7">Teaching and Education</option>
                            <option value="8">
                                Leadership and Team Building
                            </option>
                        </select>
                    </div>
                </Modal>
            </div>
            <div class="w-full overflow-x-clip shadow-md sm:rounded-lg">
                <div class="mx-52">
                    <DatePicker expanded borderless :attributes="attributes" />
                </div>
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <caption
                        class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                    >
                        Your Appointments
                    </caption>
                    <thead
                        v-if="this.appointments.length > 0"
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Request Title</th>
                            <th scope="col" class="px-6 py-3">Field</th>
                            <th scope="col" class="px-6 py-3">Start Date</th>
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
                                    class="bg-gradient-to-r from-green-500 via-yellow-300 to-yellow-500 bg-clip-text text-transparent font-bold border-2 border-green-200 py-2 px-4 rounded-md text-center"
                                >
                                    {{ appointment.statusName }}
                                </h1>
                            </td>
                            <td
                                class="px-6 py-4 flex items-center justify-center gap-2"
                            >
                                <Chat
                                    :appointmentId="appointment.appointmentId"
                                    :userId="this.userId"
                                />
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
                                        :disable="appointment.Status !== 3"
                                    />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script>
import { Calendar, DatePicker } from "v-calendar";
import { mapState, mapActions } from "vuex";
import PieChart from "../Charts/PieChart.vue";
import BarChart from "../Charts/BarChart.vue";
import "v-calendar/style.css";
import Modal from "./Modal.vue";
import Chat from "./Chat.vue";
import FeedbackForm from "./StudentComponents/FeedbackForm.vue";
import { FlFilledWarning } from "@kalimahapps/vue-icons";
import { AkCircleCheck } from "@kalimahapps/vue-icons";
import { AnOutlinedCloseCircle } from "@kalimahapps/vue-icons";
export default {
    components: {
        Calendar,
        DatePicker,
        Modal,
        FlFilledWarning,
        AkCircleCheck,
        AnOutlinedCloseCircle,
        PieChart,
        BarChart,
        Chat,
        FeedbackForm,
    },
    data() {
        return {
            refetchData: 0,
            appointments: [],
            loading: false,
            selectedField: "0",
            attributes: [
                {
                    key: 1,

                    content: "green",

                    dot: true,

                    order: 0,
                },
            ],
            userName: "",
            // ticketStatus: null,
            ticketIsLoading: true,
            // userId: null,
            // fieldToTake: null,
            // allowToAppoint: null,
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
            axios.get("/getAppointments").then(({ data }) => {
                this.appointments = data;
                this.attributes[0].dates = data.map(
                    (appointment) => new Date(appointment.startSchedule)
                );
                this.loading = false;
            });
        },

        refecthAppointments() {
            this.getAppointments();
        },
        sendTicket() {
            const fieldId = parseInt(this.selectedField);
            axios.post("/requestticket", { fieldId }).then(({ data }) => {
                this.setUserTicketStatusAction();
                this.forceRerender();
            });
        },
        // handleAppointmentAccessData(data) {
        //     this.ticketStatus = data.ticketStatus;
        //     this.userId = data.userId;
        //     this.ticketIsLoading = false;
        // },
        forceRerender() {
            this.refetchData += 1;
        },
    },

    created() {
        this.getAppointments();
    },
    mounted() {
        this.refecthAppointments();
        this.setUserTicketStatusAction();
        console.log(this.userId);
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
