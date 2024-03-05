<template>
    <LayoutMentor>
        <div class="" v-if="loading"><h1>Loading...</h1></div>

        <div class="w-full">
            <div class="flex items-center w-full justify-between mb-2">
                <div class="">
                    <h1
                        class="gap-1 flex items-center text-2xl font-medium text-green-700 pb-2.5"
                    >
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
            <div class="pb-5 flex flex-col">
                Your Available Day for Appointments
                <div class="flex" v-if="!isEdit">
                    <div
                        class="mx-2.5 border px-2 py-1 rounded-md border-gray-200"
                        v-for="day in daysOfTheWeek"
                        :class="{
                            'border-green-600 border-2 text-green-500':
                                isActiveDay(day.id),
                        }"
                    >
                        {{ day.name }}
                    </div>
                    <button @click="isEdit = !isEdit">Edit Schedule</button>
                </div>
                <div class="flex" v-else>
                    <div
                        class="mx-2.5 border px-2 py-1 rounded-md border-gray-200 cursor-pointer"
                        v-for="day in daysOfTheWeek"
                        :key="day.id"
                        :class="{
                            'border-green-600 border-2 text-green-500':
                                isActiveDay(day.id),
                        }"
                        @click="toggleDay(day.id)"
                    >
                        {{ day.name }}
                    </div>
                    <button @click="saveSchedule">Save Schedule</button>
                </div>
            </div>

            <div
                class="bg-white w-full overflow-x-clip py-10 flex flex-col rounded-md justify-between shadow-sm border border-gray-200"
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
                    <div class="w-full flex items-center justify-center mr-20">
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
                                            <th
                                                scope="col"
                                                class="py-4 w-header"
                                            >
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
            <div class="flex gap-10 my-10 w-full">
                <div class="w-1/3"><PieChart /></div>
                <div class="w-2/3"><BarChart /></div>
            </div>
        </div>
    </LayoutMentor>
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

import Modal from "../../component/Modal.vue";

import Textarea from "primevue/textarea";

import FloatLabel from "primevue/floatlabel";
import LayoutMentor from "../../Layout/LayoutMentor.vue";

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
        LayoutMentor,
        LayoutMentor,
    },
    data() {
        return {
            appointments: [],
            loading: false,
            selectedField: null,
            ticketRemarks: "",
            pagination: null,
            ticketIsLoading: true,
            minDate: null,
            TotalAppointments: 0,
            isEdit: false,
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
            daysOfTheWeek: [
                {
                    id: 1,
                    name: "Sun",
                },
                {
                    id: 2,
                    name: "Mon",
                },
                {
                    id: 3,
                    name: "Tue",
                },
                {
                    id: 4,
                    name: "Wed",
                },
                {
                    id: 5,
                    name: "Thu",
                },
                {
                    id: 6,
                    name: "Fri",
                },
                {
                    id: 7,
                    name: "Sat",
                },
            ],
            activeAvailableDays: [1, 3, 5],
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
            axios.get("/getOngoingAppointments").then(({ data }) => {
                this.appointments = data.data;
                this.pagination = data;

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
            const { ticketRemarks } = this;
            axios
                .post("/requestticket", { fieldId, ticketRemarks })
                .then(({ data }) => {
                    this.setUserTicketStatusAction();
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
        isActiveDay(dayId) {
            return this.activeAvailableDays.includes(dayId);
        },
        toggleDay(dayId) {
            if (this.isEdit) {
                if (this.activeAvailableDays.includes(dayId)) {
                    this.activeAvailableDays = this.activeAvailableDays.filter(
                        (id) => id !== dayId
                    );
                } else {
                    this.activeAvailableDays.push(dayId);
                }
            }
        },

        saveSchedule() {
            console.log(this.activeAvailableDays);
            const { activeAvailableDays } = this;
            axios
                .post("/setSchedule", { activeAvailableDays })
                .then(({ data }) => {
                    this.getLatestSchedule();
                    this.isEdit = !this.isEdit;
                });
        },
        getLatestSchedule() {
            axios.get("/getLatestSchedule").then(({ data }) => {
                this.activeAvailableDays = data.map((day) => parseInt(day, 10));
            });
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
        this.getLatestSchedule();
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
