<template>
    <!-- <h1>{{ console.log(props.fieldToTake) }}</h1> -->

    <div class="" v-if="loading"><h1>Loading...</h1></div>

    <div class="md:w-full my-10 overflow-clip px-2.5 md:px-10" v-else>
        <!-- <div class="w-full mb-2.5 bg-gray-50">
                <Menubar :model="items" />
            </div> -->

        <div
            class="flex items-center justify-between mb-2 border border-gray-200 bg-white p-2.5 rounded-md"
        >
            <div class="">
                <h1
                    class="text-lg gap-1 flex items-center md:text-2xl font-bold"
                >
                    <span
                        ><i
                            class="text-lg pi pi-chart-pie md:text-2xl text-yellow-400"
                            style="font-size: 1rem"
                        ></i></span
                    >Dashboard
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <img
                    src="../../../public/DefaultAvatar.webp"
                    class="w-10 h-10 rounded-full"
                    alt=""
                />
                <h1>{{ this.username }}</h1>
            </div>
        </div>

        <Toast />

        <div
            class="bg-white mb-5 md:p-2.5 rounded-md md:flex justify-center items-center md:gap-5"
        >
            <Message
                severity="info"
                :closable="false"
                v-if="this.ticketStatus === null"
                >To be able to request appointments from a mentor you must first
                request a ticket to PDC. Once approve you will be recommended to
                mentors with your requested field and make appointments
            </Message>
            <Message
                severity="warn"
                :closable="false"
                v-if="this.ticketStatus === 0"
                >Your ticket is sent for approval. Please wait for the PDC or
                Admin Officer to verify your request
            </Message>
            <Message
                severity="success"
                :closable="false"
                v-if="this.ticketStatus === 1"
                >Your ticket was approved. Please send your mentor appointments
                in the Mentor tab.
            </Message>
            <Message
                severity="error"
                :closable="false"
                v-if="this.ticketStatus === 2"
                >Your ticket was rejected. Please send another ticket for the
                PDC or Admin Officer to verify your request
            </Message>
            <button
                v-if="this.ticketStatus === 2 || this.ticketStatus === null"
                @click="visible = true"
                class="w-52 text-white font-semibold bg-green-600 rounded-md px-4 py-2"
            >
                Request Ticket
            </button>

            <Dialog v-model:visible="visible" modal header="Request Ticket">
                <div class="flex flex-col justify-between p-5 gap-5 w-[500px]">
                    <div class="w-full flex justify-center">
                        <img
                            src="../../../public/mmsu_logo.png"
                            alt=""
                            class="w-16 h-16"
                        />
                    </div>
                    <div
                        class="w-full flex items-center justify-center"
                        v-if="TicketError"
                    >
                        <Message
                            severity="error"
                            class="w-fit"
                            :closable="false"
                            >Please fill out all entries on the ticket
                            form</Message
                        >
                    </div>
                    <div class="w-full">
                        <label
                            for="field"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Select a field to request</label
                        >
                        <div class="">
                            <Dropdown
                                v-model="selectedField"
                                :options="this.courses"
                                :highlightOnSelect="true"
                                optionLabel="name"
                                placeholder="Select a field"
                                class="w-full text-xs border-gray-400"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-40 text-sm">Remarks</label>
                        <Textarea
                            v-model="ticketRemarks"
                            autoResize
                            rows="5"
                            cols="30"
                            class="rounded-md border text-sm w-full border-gray-300"
                        />
                    </div>
                </div>

                <div class="flex justify-content-end gap-2">
                    <button
                        @click="
                            visible = false;
                            TicketError = false;
                        "
                    >
                        Cancel
                    </button>

                    <button
                        @click="sendTicket"
                        class="text-white font-medium bg-green-600 px-4 py-2 rounded-md"
                    >
                        Submit Ticket
                    </button>
                </div>
            </Dialog>
        </div>
        <div
            class="bg-white md:w-full overflow-x-clip py-10 flex flex-col rounded-md justify-between shadow-sm border border-gray-200"
            :class="{ 'min-h-[100px]': this.appointments?.length === 0 }"
        >
            <div class="md:w-full">
                <div
                    class="md:px-16 w-full md:flex items-center justify-center gap-10"
                >
                    <!-- <DatePicker
                            expanded
                            borderless
                            :attributes="attributes"
                        /> -->

                    <div class="flex items-center justify-center pb-5">
                        <Calendar
                            inline
                            showWeek
                            :numberOfMonths="1"
                            :minDate="minDate"
                        />
                    </div>
                    <div class="md:border p-5 rounded border-gray-200">
                        <h1 class="pb-5 font-medium text-green-700 text-xl">
                            <span
                                ><i
                                    class="pi pi-chart-bar text-xl rounded-full text-yellow-400"
                                    style="font-size: 1rem"
                                ></i
                            ></span>
                            User Statistics
                            <span
                                class="text-xs text-gray-400 font-normal italic"
                                >as of
                                {{
                                    this.minDate?.toLocaleDateString("en-US")
                                }}</span
                            >
                        </h1>
                        <div
                            class="grid grid-cols-1 laptop:grid-cols-2 gap-5 md:w-full h-full"
                        >
                            <div
                                class="border border-gray-200 rounded-md p-5 h-full flex items-center gap-5"
                            >
                                <div class="">
                                    <i
                                        class="pi pi-briefcase text-2xl bg-green-100 rounded-full px-2 py-1 text-green-400"
                                        style="font-size: 1rem"
                                    ></i>
                                </div>
                                <div class="">
                                    <h1 class="text-gray-800 font-medium">
                                        Total Appointments
                                    </h1>
                                    <p class="text-gray-500">
                                        {{ this.TotalAppointments }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 rounded-md p-5 h-full flex items-center gap-5"
                            >
                                <div class="">
                                    <i
                                        class="pi pi-star text-2xl bg-yellow-100 rounded-full px-2 py-1 text-yellow-400"
                                        style="font-size: 1rem"
                                    ></i>
                                </div>
                                <div class="">
                                    <h1 class="text-gray-800 font-medium">
                                        Rating
                                    </h1>
                                    <p
                                        :class="{
                                            'text-red-400': this.rating < 3,
                                            'text-yellow-400': this.rating == 3,
                                            'text-green-400': this.rating > 3,
                                        }"
                                    >
                                        <!-- {{ this.rating }}.0 --><p
                                        class="text-white text-sm bg-red-400 px-2 py-1 w-fit rounded-md flex items-center gap-1 hover:cursor-pointer"
                                    >
                                        Hidden
                                    </p>
                                    </p>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 rounded-md p-5 h-full flex items-center gap-5"
                            >
                                <div class="">
                                    <i
                                        class="pi pi-bell text-2xl bg-blue-100 rounded-full px-2 py-1 text-blue-400"
                                        style="font-size: 1rem"
                                    ></i>
                                </div>
                                <div class="">
                                    <h1 class="text-gray-800 font-medium">
                                        Ongoing Appointments
                                    </h1>
                                    <p class="text-gray-500">
                                        {{ this.appointments.length }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 rounded-md p-5 h-full flex items-center gap-5"
                            >
                                <div class="">
                                    <i
                                        class="pi pi-flag text-2xl bg-gray-100 rounded-full px-2 py-1 text-gray-400"
                                        style="font-size: 1rem"
                                    ></i>
                                </div>
                                <div class="">
                                    <h1 class="text-gray-800 font-medium">
                                        Feedbacks
                                    </h1>
                                    <p
                                        class="text-white text-sm bg-gray-800 px-2 py-1 w-fit rounded-md flex items-center gap-1 hover:cursor-pointer"
                                    >
                                        Hidden
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full md:w-full flex items-center justify-center mr-20 overflow-x-scroll"
                >
                    <table
                        class="w-full text-sm text-gray-500 dark:text-gray-400"
                    >
                        <caption
                            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                        >
                            Your Appointments
                        </caption>
                        <div
                            class="mx-5 flex items-center justify-center"
                            v-if="this.appointments?.length == 0"
                        >
                            <h1 class="flex flex-col items-center gap-5">
                                <i
                                    class="pi pi-calendar-times text-6xl text-gray-300"
                                ></i>
                                <span class="text-gray-500"
                                    >You have no ongoing appointments.</span
                                >
                            </h1>
                        </div>
                        <div class="flex flex-col" v-else>
                            <table>
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="py-4 w-header">
                                            Request Title
                                        </th>
                                        <th scope="col" class="w-header">
                                            Field
                                        </th>
                                        <th scope="col" class="w-header">
                                            Start Date
                                        </th>
                                        <th scope="col" class="w-header">
                                            Mentor
                                        </th>
                                        <th scope="col" class="w-header">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr
                                        v-for="appointment in appointments"
                                        class="bg-white dark:bg-gray-800 dark:border-gray-700"
                                    >
                                        <th
                                            scope="row"
                                            class="font-medium py-4 text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            {{ appointment.title }}
                                        </th>
                                        <td>{{ appointment.field }}</td>
                                        <td>
                                            {{
                                                moment(
                                                    appointment.startSchedule,
                                                    "YYYY-MM-DD HH:mm:ss"
                                                ).format("MMMM Do YYYY")
                                            }}
                                        </td>
                                        <td>{{ appointment.name }}</td>
                                        <td>
                                            <h1
                                                class="font-bold"
                                                :class="{
                                                    'text-yellow-400':
                                                        appointment.Status ===
                                                        0,
                                                    'text-green-400':
                                                        appointment.Status ===
                                                        1,
                                                    'text-red-400':
                                                        appointment.Status ===
                                                        2,
                                                    'text-green-700':
                                                        appointment.Status ===
                                                        3,
                                                }"
                                            >
                                                {{ appointment.statusName }}
                                            </h1>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </table>
                </div>
                <!-- <div class="my-5" v-if="this.appointments?.length > 0">
                        <Pagination
                            @next="goToNextPage"
                            @back="goToPrevPage"
                            :total="this.pagination?.total"
                            :current_page="this.pagination?.current_page"
                            :last_page="this.pagination?.last_page"
                        />
                    </div> -->
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-10 my-10 w-full">
            <div class="md:w-1/3"><PieChart :role="1" /></div>
            <div class="md;w-2/3"><BarChart :role="1" /></div>
        </div>
    </div>
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
import moment from "moment";
import Modal from "./Modal.vue";
import Chat from "./Chat.vue";
import FeedbackForm from "./StudentComponents/FeedbackForm.vue";

import Textarea from "primevue/textarea";

import Toast from "primevue/toast";

import FloatLabel from "primevue/floatlabel";
import Dialog from "primevue/dialog";

export default {
    components: {
        Calendar,
        Menubar,
        Modal,

        PieChart,
        BarChart,
        Chat,
        FeedbackForm,
        Pagination,
        Dropdown,
        Message,
        Textarea,
        FloatLabel,
        Dialog,
        Toast,
    },
    data() {
        return {
            appointments: [],
            loading: false,
            selectedField: null,
            ticketRemarks: "",
            pagination: null,
            ticketIsLoading: true,
            courses: null,
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
            moment: moment,
            visible: false,
            TicketError: false,
        };
    },
    computed: {
        ...mapState([
            "userId",
            "ticketStatus",
            "fieldToTake",
            "allowToAppoint",
            "rating",
            "username",
        ]),
    },
    methods: {
        ...mapActions(["setUserTicketStatusAction"]),
        getAppointments() {
            this.loading = true;
            axios
                .post("/getOngoingAppointments", { userType: 1 })
                .then(({ data }) => {
                    this.appointments = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        total: data.total,
                    };
                    this.loading = false;
                });
        },
        getFields() {
            axios.post("/getfields").then(({ data }) => {
                console.log(data);
                this.courses = data;
            });
        },
        getCountTotalAppointments() {
            axios.get("/getCountTotalAppointments").then(({ data }) => {
                this.TotalAppointments = data;
                this.loading = false;
            });
        },

        sendTicket() {
            const { ticketRemarks } = this;
            if (!this.selectedField || !ticketRemarks) {
                return (this.TicketError = true);
            }
            const fieldId = parseInt(this.selectedField.id);

            axios
                .post("/requestticket", { fieldId, ticketRemarks })
                .then(({ data }) => {
                    this.setUserTicketStatusAction();
                    this.visible = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Ticket Sent!",
                        detail: "Your ticket was sent succesfully and will be reviewed soon",
                        life: 3000,
                    });
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
                    this.appointments = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        total: data.total,
                    };
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
        this.minDate = this.getToday();
        this.getCountTotalAppointments();
        this.getFields();
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
