<template>
    <Layout
        @appointment-access-data="handleAppointmentAccessData"
        :key="refetchData"
    >
        <!-- <h1>{{ console.log(props.fieldToTake) }}</h1> -->
        <div class="min-w-[400px] max-w-[800px]">
            <div class="" v-if="loading"><h1>Loading...</h1></div>

            <div class="w-full">
                <!-- <div
                    class="flex flex-col items-center gap-5"
                    v-if="appointments == 0"
                >
                    You dont have any appointments
                    <router-link to="/mentors">
                        <button
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white w-fit rounded-md"
                        >
                            Find a mentor
                        </button></router-link
                    >
                </div> -->
                <div class="w-full overflow-x-auto shadow-md sm:rounded-lg">
                    <DatePicker expanded borderless :attributes="attributes" />
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <caption
                            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                        >
                            Your Appointments

                            <p
                                class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400"
                            >
                                To be able to request appointments from a mentor
                                you must first request a ticket to PDC. Once
                                approve you will be recommended to mentors with
                                your requested field and make appointments
                            </p>

                            <div class="" v-if="this.ticketStatus === null">
                                Loading...
                            </div>
                            <div class="" v-else>
                                <div
                                    class="text-center text-sm my-5 shadow-sm"
                                    v-if="this.ticketStatus === 1"
                                >
                                    <p
                                        class="bg-green-100 mx-auto text-green-700 px-4 py-2 rounded-md flex items-center gap-2 justify-center"
                                    >
                                        <AkCircleCheck />Your request was
                                        approved.
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
                                        <FlFilledWarning />Your request is being
                                        verified. Please wait
                                    </p>
                                </div>
                                <div
                                    class="text-center text-sm my-5 shadow-sm"
                                    v-if="this.ticketStatus === 2"
                                >
                                    <p
                                        class="bg-red-100 mx-auto text-red-700 px-4 py-2 rounded-md flex items-center gap-2 justify-center"
                                    >
                                        <AkCircleCheck />Your request was
                                        rejected. Please make another request to
                                        the PDC or contact them directly.
                                    </p>
                                </div>
                                <Modal
                                    v-if="
                                        this.ticketStatus === 2 ||
                                        this.ticketStatus === null
                                    "
                                    :modalContent="{
                                        title: 'Request Ticket',
                                        content:
                                            'Please fill out the form below:',
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
                                            <option selected>
                                                Choose a Field
                                            </option>
                                            <option value="1">
                                                Business Management
                                            </option>
                                            <option value="2">
                                                Creative Arts
                                            </option>
                                            <option value="3">
                                                Engineering and Mathematics
                                            </option>
                                            <option value="4">
                                                Humanities Arts and Social
                                                Sciences
                                            </option>
                                            <option value="5">
                                                IT and Computer Science
                                            </option>
                                            <option value="6">
                                                Medical and Health Science
                                            </option>
                                            <option value="7">
                                                Teaching and Education
                                            </option>
                                            <option value="8">
                                                Leadership and Team Building
                                            </option>
                                        </select>
                                    </div>
                                </Modal>
                            </div>
                        </caption>
                        <thead
                            v-if="appointments > 0"
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
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="appointment in appointments"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
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
                                <td class="\ text-right">
                                    <h1
                                        v-if="appointment.Status === 0"
                                        class="text-white font-bold bg-yellow-400 py-2 px-4 rounded-md"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 1"
                                        class="text-white font-bold bg-green-400 py-2 px-4 rounded-md"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 2"
                                        class="text-white font-bold bg-red-400 py-2 px-4 rounded-md"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="#"
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline"
                                        >Chat</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";
import Modal from "./Modal.vue";
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
            ticketStatus: null,
        };
    },
    methods: {
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
                this.forceRerender();
            });
        },
        handleAppointmentAccessData(data) {
            this.ticketStatus = data.ticketStatus;
        },
        forceRerender() {
            this.refetchData += 1;
        },
    },

    created() {
        this.getAppointments();
    },
    mounted() {
        this.refecthAppointments();
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
