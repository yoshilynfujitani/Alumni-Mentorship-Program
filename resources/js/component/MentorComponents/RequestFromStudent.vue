<template lang="">
    <!-- <Modal
        :modalContent="{
            title: 'Appointment Details',

            // content: 'Please fill out the form below:',
        }"
        type="edit"
        buttonIcon="FlPeopleSettings"
        cancelLabel="Back"
        :saveOption="false"
        iconLabel="Details"
        @modalopen="getAppointmentDetails"
    > -->
    <button
        @click="onClickModal"
        class="flex items-center gap-1 bg-yellow-400 text-white px-2 py-1 rounded-md"
    >
        <i class="pi pi-eye"></i>View Details
    </button>
    <Dialog
        v-model:visible="visible"
        modal
        header="Appointment Details"
        @hide="onDialogHide"
    >
        <div class="h-full" v-if="!this.requestDetails">Loading...</div>
        <div class="flex items-start justify-around h-full" v-else>
            <div
                class="flex flex-col mr-5 justify-between h-full w-96"
                v-if="!this.showFeedback && !this.verifying"
            >
                <div class="border border-gray-200 rounded-md w-full">
                    <div class="flex justify-center py-5 rounded-full">
                        <img
                            class="h-28 rounded-full w-28"
                            src="../../../../public/DefaultAvatar.webp"
                            alt="Woman looking front"
                        />
                    </div>
                    <div class="text-center">
                        <h2 class="font-semibold">
                            {{ this.requestDetails.name }}
                        </h2>
                    </div>
                    <ul
                        class="py-4 text-gray-700 flex items-center justify-around"
                    >
                        <li class="flex flex-col items-center justify-around">
                            <i
                                class="pi pi-star-fill text-yellow-400"
                                style="font-size: 1rem"
                            ></i>
                            <p class="font-medium">Rating</p>
                            <div>{{ this.requestDetails?.rating }}.0</div>
                        </li>
                        <li class="flex flex-col items-center justify-between">
                            <i
                                class="pi pi-building text-yellow-400"
                                style="font-size: 1rem"
                            ></i>
                            <div>
                                {{ this.requestDetails.CollegeName }}
                            </div>
                        </li>
                    </ul>
                </div>
                <div
                    v-if="this.requestDetails.statusId === 0"
                    class="flex flex-col items-center w-full justify-around gap-2 self-end mt-5"
                >
                    <h1
                        class="self-start text-sm bg-green-600 text-white py-1 px-2 rounded-full flex items-center justify-center gap-1"
                    >
                        <span
                            ><i
                                class="pi pi-check-circle text-white text-sm"
                            ></i
                        ></span>
                        Verify Appointment
                    </h1>
                    <div class="flex w-full gap-2.5">
                        <div
                            @click="this.verifying = true"
                            class="transition-all border text-center border-red-400 rounded-md w-full py-2 font-semibold text-red-500 hover:bg-red-400 hover:text-white hover:cursor-pointer"
                        >
                            Reject
                        </div>
                        <div
                            @click="
                                verify(
                                    1,
                                    this.requestDetails.studentId,
                                    this.requestDetails.appointmentId
                                )
                            "
                            class="transition-all border text-center border-green-400 rounded-md w-full py-2 font-semibold text-green-500 hover:bg-green-400 hover:text-white hover:cursor-pointer"
                        >
                            Accept
                        </div>
                    </div>
                </div>
                <div class="" v-else>
                    <div
                        class="flex flex-col gap-2"
                        v-if="this.requestDetails.statusId === 1"
                    >
                        <div
                            class="border rounded-md border-green-400 py-2 mt-5 font-semibold text-green-500 text-center"
                        >
                            Appointment Accepted
                        </div>
                        <div
                            class="text-center text-sm py-4 bg-green-700 rounded-md text-white font-medium"
                        >
                            <ConfirmDialog></ConfirmDialog>
                            <button
                                @click="
                                    confirm1(
                                        $event,
                                        3,
                                        this.requestDetails.studentId,
                                        this.requestDetails.appointmentId
                                    )
                                "
                            >
                                Mark Session as Finished
                            </button>
                        </div>
                    </div>
                    <div
                        class="border rounded-md border-red-400 py-2 mt-5 font-semibold text-red-500 text-center"
                        v-if="this.requestDetails.statusId === 2"
                    >
                        Appointment Rejected
                    </div>
                    <div
                        class="border rounded-md border-gray-400 py-2 mt-5 font-semibold text-gray-500 text-center"
                        v-if="this.requestDetails.statusId === 3"
                    >
                        <button
                            @click="
                                setShowFeedback(
                                    this.requestDetails.appointmentId
                                )
                            "
                        >
                            View Feedback
                        </button>
                    </div>
                </div>
            </div>
            <div class="mr-5" v-if="this.verifying">
                <button @click="this.verifying = false">Back</button>
                <div
                    class="max-w-xl mx-auto flex w-full flex-col border border-gray-200 rounded-lg bg-white p-8"
                >
                    <h2
                        class="title-font mb-1 text-lg font-medium text-gray-900"
                    >
                        Reason for Rejection
                    </h2>
                    <p class="mb-5 leading-relaxed text-gray-600">
                        If you had any issues or you liked our product, please
                        share with us!
                    </p>

                    <div class="mb-4">
                        <label
                            for="message"
                            class="text-sm leading-7 text-gray-600"
                            >Message</label
                        >
                        <textarea
                            v-model="remarks"
                            id="message"
                            name="message"
                            class="h-32 w-full resize-none rounded border border-gray-300 bg-white py-1 px-3 text-base leading-6 text-gray-700 outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                        ></textarea>
                    </div>
                    <button
                        @click="
                            verify(
                                2,
                                this.requestDetails.studentId,
                                this.requestDetails.appointmentId
                            )
                        "
                        class="rounded border-0 bg-red-500 py-2 px-6 text-md text-white hover:bg-red-600 focus:outline-none"
                    >
                        Send Remarks
                    </button>
                </div>
            </div>

            <div
                class="flex flex-col mr-5 justify-between h-full w-full"
                v-if="this.showFeedback"
            >
                <button
                    @click="setShowFeedback"
                    class="self-start px-4 py-2 rounded-md border border-gray-500"
                >
                    View Details
                </button>

                <div class="text-start">
                    <div class="flex gap-5">
                        <div
                            class="border flex items-center gap-2 my-2 border-gray-100 rounded-md px-4 py-2 w-full"
                        >
                            <img
                                class="w-12 h-12 rounded-full shadow-lg"
                                src="../../../../public/DefaultAvatar.webp"
                                alt="Avatar"
                            />
                            <div class="">
                                <h1 class="">
                                    {{ this.requestDetails?.name }}
                                </h1>
                                <h1 class="text-sm text-gray-400">
                                    {{ this.requestDetails?.course }}
                                </h1>
                            </div>
                        </div>
                        <div
                            class="border flex items-center gap-2 my-2 border-gray-100 rounded-md px-4 py-2 w-full"
                        >
                            <div class="w-full">
                                <h1 class="font-medium">Rating</h1>
                                <h1
                                    class="text-sm text-gray-400"
                                    v-if="!this.feedbackDetails?.rating"
                                >
                                    No rating.
                                </h1>
                                <h1 class="text-sm text-gray-400" v-else>
                                    {{ this.feedbackDetails?.rating }}/5
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border border-gray-200 rounded-md p-5 w-full h-full"
                    >
                        <h1 class="font-medium text-green-600">Comments</h1>
                        <h1 v-if="!this.feedbackDetails?.comments">
                            Student have not yet submitted any feedback.
                        </h1>
                        <h1 class="overflow-y-scroll min-h-[100px]" v-else>
                            {{ this.feedbackDetails?.comments }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="h-full">
                <h1 class="font-medium">Student's Log</h1>
                <div class="">
                    <div class="" v-if="!this.recentTickets">
                        User has no tickets
                    </div>
                    <div
                        v-else
                        v-for="ticket in recentTickets"
                        class="rounded-md px-2 py-1 border-2 w-48 flex items-center gap-2 my-2.5"
                        :class="{
                            'border-yellow-300 text-yellow-500':
                                ticket.ticketStatus === 0,
                            'border-green-300 text-green-500':
                                ticket.ticketStatus === 1,
                            'border-red-300 text-red-500':
                                ticket.ticketStatus === 2,
                        }"
                    >
                        <i
                            class="pi"
                            :class="{
                                'pi-question-circle text-yellow-500':
                                    ticket.ticketStatus === 0,
                                'pi-check-circle text-green-500':
                                    ticket.ticketStatus === 1,
                                'pi-times-circle text-red-500':
                                    ticket.ticketStatus === 2,
                            }"
                            style="font-size: 1rem"
                        ></i>
                        <div class="">
                            <h1 class="font-medium text-sm">
                                {{ ticket.statusName }}
                            </h1>
                            <p class="text-sm text-gray-700">
                                {{
                                    moment(
                                        ticket.created_at,
                                        "YYYY-MM-DD HH:mm:ss"
                                    ).format("MMMM Do YYYY")
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Dialog>
</template>
<script>
import Modal from "../Modal.vue";
import moment from "moment";
import Calendar from "primevue/calendar";

import ConfirmPopup from "primevue/confirmpopup";

import ConfirmDialog from "primevue/confirmdialog";

import Dialog from "primevue/dialog";

export default {
    props: ["requestId"],
    components: {
        Modal,
        Calendar,
        Dialog,
        ConfirmPopup,
        ConfirmDialog,
    },
    data() {
        return {
            visible: false,
            verifying: false,
            viewFeedback: false,
            moment: moment,
            requestDetails: null,
            showFeedback: false,
            minDate: null,
            feedbackDetails: null,
            recentTickets: null,
            remarks: "",
        };
    },
    computed: {
        startSchedule() {
            return moment(this.requestDetails?.startSchedule);
        },
        now() {
            return moment();
        },
        reminderdate() {
            return this.startSchedule?.isBefore(this.now)
                ? this.startSchedule?.fromNow()
                : this.startSchedule?.toNow(true);
        },
    },
    methods: {
        onClickModal() {
            this.visible = true;
            this.getAppointmentDetails();
        },
        onDialogHide() {
            this.$emit("Updated");
        },

        getAppointmentDetails() {
            axios
                .post("/getAppointment", { appointmentId: this.requestId })
                .then(({ data }) => {
                    this.requestDetails = data;
                    this.getRecentTickets(parseInt(data.studentId));
                });
        },
        getRecentTickets(studentId) {
            axios
                .post("/getrecenttickets", { studentId: studentId })
                .then(({ data }) => {
                    this.recentTickets = data;
                });
        },
        setShowFeedback(appointmentId) {
            this.showFeedback = !this.showFeedback;

            this.getFeedback(appointmentId);
        },
        verify(requestStatus, studentId, appointmentId) {
            const { remarks } = this;
            axios
                .post("/verifyrequest", {
                    requestStatus,
                    studentId,
                    appointmentId,
                    remarks,
                })
                .then(({ data }) => {
                    this.getAppointmentDetails();
                    this.remarks = "";
                    this.verifying = false;
                });
        },

        confirm1(event, requestStatus, studentId, appointmentId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to proceed?",
                icon: "pi pi-exclamation-triangle text-red-500",
                rejectClass:
                    "p-button-secondary p-button-outlined p-button-sm text-red-500 text-sm",
                acceptClass:
                    "p-button-sm text-white bg-green-500 px-2 py-1 rounded-md text-sm",
                rejectLabel: "Cancel",
                acceptLabel: "Mark as Finished",
                accept: () => {
                    this.verify(requestStatus, studentId, appointmentId);
                    this.$emit("Updated");
                },
            });
        },

        getToday() {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set hours to 00:00:00 for accurate comparison
            return today;
        },
        getFeedback(appointmentId) {
            axios
                .post("/getFeedback", {
                    appointmentId,
                })
                .then(({ data }) => {
                    this.feedbackDetails = data[0];
                });
        },
    },
    mounted() {
        this.minDate = this.getToday();
    },
};
</script>
<style lang=""></style>
