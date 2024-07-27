<template lang="">
    <div
        class="w-full my-10 overflow-x-scroll md:overflow-x-clip flex flex-col justify-between shadow-sm sm:rounded-lg border border-gray-200"
    >
        <Toast />
        <div class="">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <caption
                    class="p-5 text-2xl font-bold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                >
                    Your Appointments
                </caption>
                <!-- <div
                        class="py-20 flex items-center justify-center"
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
                    </div> -->
                <thead
                    v-if="this.appointments?.length > 0"
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
                            class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ appointment.title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ appointment.fieldName }}
                        </td>
                        <td class="px-6 py-4">
                            {{
                                moment(
                                    appointment.startSchedule,
                                    "YYYY-MM-DD HH:mm:ss"
                                ).format("MMMM Do YYYY")
                            }}
                        </td>
                        <td class="px-6 py-4">
                            {{ appointment.name }}
                        </td>
                        <td class="px-6 py-4">
                            <h1
                                class="text-center font-bold"
                                :class="{
                                    'text-yellow-400': appointment.Status === 0,
                                    'text-green-400 ': appointment.Status === 1,
                                    'text-red-400': appointment.Status === 2,
                                    'text-green-700': appointment.Status === 3,
                                    'text-gray-500': appointment.Status === 4,
                                }"
                            >
                                {{ appointment.statusName }}
                            </h1>
                        </td>
                        <td
                            class="px-6 py-4 flex items-center justify-center gap-2"
                        >
                            <div
                                class="flex items-center justify-center"
                                v-if="appointment.Status === 2"
                            >
                                <button
                                    label="View"
                                    @click="visible = true"
                                    class="transition-all bg-red-500 text-white flex items-center gap-1 px-4 py-2 rounded-md hover:bg-red-700 ml-2"
                                >
                                    <i class="pi pi-eye"></i> View
                                </button>
                                <Dialog
                                    v-model:visible="visible"
                                    modal
                                    header="Appointment Remarks"
                                    :style="{ width: '35rem' }"
                                >
                                    <button
                                        v-if="!willResched"
                                        @click="willResched = true"
                                        class="bg-yellow-400 text-white px-4 py-2 rounded-md my-2 font-medium"
                                    >
                                        Request a Reschedule
                                    </button>
                                    <div
                                        v-if="willResched"
                                        class="my-2 space-x-5"
                                    >
                                        <button @click="willResched = false">
                                            Back
                                        </button>
                                        <Calendar
                                            v-model="newDate"
                                            showIcon
                                            iconDisplay="input"
                                        />
                                    </div>
                                    <button
                                        v-if="willResched"
                                        @click="
                                            resched(appointment.appointmentId)
                                        "
                                        class="bg-green-400 text-white px-4 py-2 rounded-md my-2 font-medium"
                                    >
                                        Confirm Reschedule
                                    </button>

                                    <div
                                        class="card border border-gray-300 rounded-md"
                                    >
                                        <Accordion :activeIndex="0">
                                            <AccordionTab header="Your Request">
                                                <p class="text-sm">
                                                    Appointment Title:
                                                    <span
                                                        class="font-medium text-base"
                                                    >
                                                        {{
                                                            appointment.title
                                                        }}</span
                                                    >
                                                </p>
                                                <p class="text-sm">
                                                    Field:
                                                    <span
                                                        class="font-medium text-base"
                                                    >
                                                        {{
                                                            appointment.fieldName
                                                        }}</span
                                                    >
                                                </p>
                                                <p class="text-sm">
                                                    Start Date:
                                                    <span
                                                        class="font-medium text-base"
                                                    >
                                                        {{
                                                            moment(
                                                                appointment.startSchedule,
                                                                "YYYY-MM-DD HH:mm:ss"
                                                            ).format(
                                                                "MMMM Do YYYY"
                                                            )
                                                        }}</span
                                                    >
                                                </p>
                                            </AccordionTab>
                                            <AccordionTab
                                                header="Reason for Rejection"
                                                class="rejection-header"
                                            >
                                                <p>
                                                    {{ appointment.remarks }}
                                                </p>
                                            </AccordionTab>
                                        </Accordion>
                                    </div>

                                    <div
                                        class="flex justify-content-end gap-2 my-2.5"
                                    >
                                        <Button
                                            type="button"
                                            label="Cancel"
                                            severity="secondary"
                                            @click="visible = false"
                                        ></Button>
                                    </div>
                                </Dialog>
                            </div>
                            <div
                                class="px-4 py-2 border-dashed border rounded border-gray-300 text-gray-300 font-thin"
                                v-if="
                                    appointment.Status === 1 ||
                                    appointment.Status === 0
                                "
                            >
                                Unavailable
                            </div>

                            <div class="" v-else>
                                <button
                                    :disabled="appointment.Status !== 3"
                                    :class="{
                                        hidden: appointment.Status !== 3,
                                    }"
                                >
                                    <FeedbackForm
                                        :appointmentId="
                                            appointment.appointmentId
                                        "
                                        userRole="Student"
                                        :userToRateId="appointment.mentorId"
                                        :disable="appointment.Status !== 3"
                                    />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="my-5">
            <Pagination
                @next="goToNextPage"
                @back="goToPrevPage"
                :total="this.pagination?.total"
                :current_page="this.pagination?.current_page"
                :last_page="this.pagination?.last_page"
            />
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

import Calendar from "primevue/calendar";

import Chat from "../component/Chat.vue";
import FeedbackForm from "../component/StudentComponents/FeedbackForm.vue";
import Pagination from "../utils/Pagination.vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import moment from "moment";
import Toast from "primevue/toast";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";

export default {
    computed: {
        ...mapState(["userId"]),
    },
    components: {
        FeedbackForm,
        Chat,
        Pagination,
        Dialog,
        Button,
        Toast,
        Accordion,
        AccordionTab,
        Calendar,
    },

    data() {
        return {
            willResched: false,
            loading: false,
            appointments: null,
            pagination: null,
            visible: false,
            moment: moment,
            newDate: null,
        };
    },

    methods: {
        getAppointments() {
            this.loading = true;
            axios.get("/getAppointments").then(({ data }) => {
                this.appointments = data.data;
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total,
                };

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
                .get(`/getAppointments?page=${page}`)
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
        resched(id) {
            this.isLoading = true;

            axios
                .post("/requestReschedule", { id, date: this.newDate })
                .then(({ data }) => {
                    this.willResched = false;
                    this.newDate = null;
                    this.visible = false;
                    this.getAppointments();
                })
                .catch((error) => {
                    console.error("Error fetching mentors:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
    },
    mounted() {
        this.getAppointments();
    },
};
</script>
<style lang=""></style>
