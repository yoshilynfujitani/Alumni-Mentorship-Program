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
                class="flex flex-col mr-5 justify-between h-full"
                v-if="!this.showFeedback && !this.verifying"
            >
                <div class="border border-gray-200 rounded-md">
                    <div class="rounded-t-md h-36 overflow-hidden">
                        <img
                            class="object-fill w-96 h-56 object-center"
                            src="../../../../public/mmsu_bg.webp"
                            alt="Mountain"
                        />
                    </div>
                    <div
                        class="mx-auto w-28 h-28 relative -mt-16 border-4 border-white rounded-full overflow-hidden"
                    >
                        <img
                            class="object-cover object-center h-28"
                            src="../../../../public/DefaultAvatar.webp"
                            alt="Woman looking front"
                        />
                    </div>
                    <div class="text-center mt-2">
                        <h2 class="font-semibold">
                            {{ this.requestDetails.name }}
                        </h2>
                        <p class="text-gray-500">
                            {{ this.requestDetails.course }}
                        </p>
                    </div>
                    <ul
                        class="py-4 mt-2 text-gray-700 flex items-center justify-around"
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
                            <svg
                                class="w-4 fill-current text-blue-900"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z"
                                />
                            </svg>
                            <div>10k</div>
                        </li>
                        <li class="flex flex-col items-center justify-around">
                            <svg
                                class="w-4 fill-current text-blue-900"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z"
                                />
                            </svg>
                            <div>15</div>
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
                    console.log(data);
                });
        },
        getRecentTickets(studentId) {
            axios
                .post("/getrecenttickets", { studentId: studentId })
                .then(({ data }) => {
                    this.recentTickets = data;
                    console.log(data);
                });
        },
        setShowFeedback(appointmentId) {
            console.log("clicked");
            this.showFeedback = !this.showFeedback;
            console.log(this.showFeedback);
            this.getFeedback(appointmentId);
        },
        verify(requestStatus, studentId, appointmentId) {
            console.log(requestStatus);
            console.log(studentId);
            console.log(appointmentId);
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
                    console.log(data);
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
