<template>
    <div class="h-full w-full" v-if="loading"><h1>Loading...</h1></div>

    <div class="w-full my-10 px-20" v-else>
        <Toast />
        <div class="w-full">
            <div
                class="flex items-center w-full justify-between border bg-white px-2.5 py-1.5 mb-2.5 rounded-md border-gray-200"
            >
                <div class="">
                    <h1 class="gap-1 flex items-center text-2xl font-bold">
                        <span
                            ><i
                                class="pi pi-chart-pie text-2xl text-yellow-400"
                                style="font-size: 1rem"
                            ></i></span
                        >Dashboard
                    </h1>
                </div>
                <div class="flex items-center gap-2">
                    <img
                        src="../../../../public/DefaultAvatar.webp"
                        class="w-10 h-10 rounded-full"
                        alt=""
                    />
                    <h1>{{ this.username }}</h1>
                </div>
            </div>

            <!-- <div class="" v-if="this.ticketStatus === null">Loading...</div> -->
            <ScheduleManager />
            <FieldManager />

            <div
                class="bg-white w-full overflow-x-clip py-10 flex flex-col rounded-md justify-between shadow-sm border border-gray-200"
                :class="{
                    'min-h-[100px]': this.appointments?.length === 0,
                }"
            >
                <div class="">
                    <div class="flex items-center justify-center gap-10">
                        <Calendar
                            v-model="date"
                            inline
                            :numberOfMonths="1"
                            :minDate="minDate"
                            class=""
                        />
                        <div class="border p-5 rounded border-gray-200">
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
                                        this.minDate?.toLocaleDateString(
                                            "en-US"
                                        )
                                    }}</span
                                >
                            </h1>
                            <div
                                class="grid grid-cols-1 laptop:grid-cols-2 gap-5 w-full h-full"
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
                                                'text-yellow-400':
                                                    this.rating == 3,
                                                'text-green-400':
                                                    this.rating > 3,
                                            }"
                                        >
                                            {{ this.rating }}.0
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
                                            View
                                            <span
                                                class="pi pi-arrow-right text-xs"
                                            ></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <h1
                            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                        >
                            Your Appointments
                        </h1>

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
                            <table class="text-sm">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 py-10"
                                >
                                    <tr class="">
                                        <th scope="col" class="py-2.5">
                                            Request Title
                                        </th>
                                        <th scope="col" class="">Field</th>
                                        <th scope="col" class="">Start Date</th>
                                        <th scope="col" class="">Student</th>
                                        <th scope="" class="pr-2.5">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr
                                        v-for="appointment in appointments"
                                        :key="appointment.appointmentId"
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
                                        <td class="pr-2.5">
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
                    </div>
                    <div class="mt-5" v-if="this.appointments?.length > 0">
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
            <div class="flex gap-10 my-10 w-full">
                <div class="w-1/3"><PieChart :role="2" /></div>
                <div class="w-2/3"><BarChart :role="2" /></div>
            </div>
        </div>
    </div>
</template>

<script>
import Calendar from "primevue/calendar";
import { mapState, mapActions } from "vuex";
import PieChart from "../../Charts/PieChart.vue";
import BarChart from "../../Charts/BarChart.vue";
import Pagination from "../../utils/Pagination.vue";
import Dropdown from "primevue/dropdown";
import Menubar from "primevue/menubar";
import Message from "primevue/message";
import moment from "moment";
import FloatLabel from "primevue/floatlabel";
import Modal from "../../component/Modal.vue";

import Textarea from "primevue/textarea";

import Toast from "primevue/toast";
import ScheduleManager from "../../component/MentorComponents/ScheduleManager.vue";
import FieldManager from "../../component/MentorComponents/FieldManager.vue";

export default {
    components: {
        Calendar,
        Menubar,
        Modal,
        PieChart,
        BarChart,
        Pagination,
        Dropdown,
        Message,
        Textarea,
        FloatLabel,
        Toast,
        ScheduleManager,
        FieldManager,
    },
    data() {
        return {
            date: null,
            appointments: [],
            loading: false,
            selectedField: null,
            ticketRemarks: "",
            pagination: null,
            ticketIsLoading: true,
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
                .post("/getOngoingAppointments", { userType: 2 })
                .then(({ data }) => {
                    this.appointments = data.data;
                    this.pagination = data;

                    this.loading = false;
                });
        },
        getCountTotalAppointments() {
            axios.get("/getCountTotalAppointments").then(({ data }) => {
                this.TotalAppointments = data;
                this.loading = false;
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
        this.setUserTicketStatusAction();
        this.minDate = this.getToday();
        this.getCountTotalAppointments();

        var titleElement = document.querySelector(
            ".p-calendar .p-datepicker-title"
        );

        if (titleElement) {
            var titleText = titleElement.textContent.trim();
            var month = titleText.substring(0, titleText.length - 4);
            var year = titleText.substring(titleText.length - 4);
            var newTextContent = month + " " + year;
            titleElement.textContent = newTextContent;
        }
    },
};
</script>

<style>
.p-calendar .p-datepicker-title {
    font-weight: 600;
    color: green;
    word-spacing: 5px;
}
.p-calendar .p-datepicker-title::after {
    content: " ";
}

.p-calendar .p-datepicker-title::after {
    content: attr(data-month) " " attr(data-year);
}

.p-inputtext {
    border: 0px;
    border: 1px solid #4caf50;
    border-radius: 5px;
    width: fit-content;
}
</style>
