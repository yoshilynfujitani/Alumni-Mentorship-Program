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
    <Dialog v-model:visible="visible" modal header="Appointment Details">
        <div class="" v-if="!this.requestDetails">Loading...</div>
        <div class="flex items-start w-[700px] justify-between" v-else>
            <div
                class="flex flex-col mr-5 justify-between h-full"
                v-if="!this.showFeedback"
            >
                <div
                    class="text-start text-lg border p-2.5 border-gray-200 rounded-md"
                >
                    <h1 class="font-medium">Request header</h1>
                    <p class="text-sm">{{ this.requestDetails.title }}</p>
                </div>
                <div
                    class="grid grid-cols-2 gap-x-2 content-between text-start w-full my-5"
                >
                    <div class="">
                        <h1 class="font-medium">Student's Name</h1>
                        <p>{{ this.requestDetails.name }}</p>
                    </div>
                    <div class="">
                        <h1 class="font-medium">Student's Course</h1>
                        <p>{{ this.requestDetails.course }}</p>
                    </div>

                    <div class="">
                        <h1 class="font-medium">Start Date</h1>
                        <p>
                            {{
                                moment(
                                    requestDetails.startSchedule,
                                    "YYYY-MM-DD HH:mm:ss"
                                ).format("MMMM Do YYYY")
                            }}
                        </p>
                    </div>
                    <div class="">
                        <h1 class="font-medium">Status</h1>
                        <p>{{ this.requestDetails.statusName }}</p>
                    </div>
                </div>
                <div
                    v-if="this.requestDetails.statusId === 0"
                    class="flex items-center w-full justify-around gap-2 self-end mt-5"
                >
                    <div
                        @click="
                            verify(
                                2,
                                this.requestDetails.studentId,
                                this.requestDetails.appointmentId
                            )
                        "
                        class="transition-all border border-red-400 rounded-md w-full py-2 font-semibold text-red-500 hover:bg-red-400 hover:text-white hover:cursor-pointer"
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
                        class="transition-all border border-green-400 rounded-md w-full py-2 font-semibold text-green-500 hover:bg-green-400 hover:text-white hover:cursor-pointer"
                    >
                        Accept
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
            <div
                class="flex flex-col mr-5 justify-between h-full w-full"
                v-else
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
                                    {{ this.requestDetails.name }}
                                </h1>
                                <h1 class="text-sm text-gray-400">
                                    {{ this.requestDetails.course }}
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
                                    v-if="!this.feedbackDetails.rating"
                                >
                                    No rating.
                                </h1>
                                <h1 class="text-sm text-gray-400" v-else>
                                    {{ this.feedbackDetails.rating }}/5
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border border-gray-200 rounded-md p-5 w-full h-full"
                    >
                        <h1 class="font-medium">Comments</h1>
                        <h1 v-if="!this.feedbackDetails.comments">
                            Student have not yet submitted any feedback.
                        </h1>
                        <h1 class="overflow-y-scroll" v-else>
                            {{ this.feedbackDetails.comments }}
                        </h1>
                    </div>
                </div>
            </div>

            <Calendar
                v-model="date"
                inline
                showWeek
                :numberOfMonths="1"
                :minDate="minDate"
            />
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
            moment: moment,
            requestDetails: null,
            showFeedback: false,
            minDate: null,
            feedbackDetails: null,
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

        getAppointmentDetails() {
            axios
                .post("/getAppointment", { appointmentId: this.requestId })
                .then(({ data }) => {
                    this.requestDetails = data;
                    console.log(data);
                });
        },
        setShowFeedback(appointmentId) {
            console.log(appointmentId);
            this.showFeedback = !this.showFeedback;
            this.getFeedback(appointmentId);
            if (this.showFeedback) {
            }
        },
        verify(requestStatus, studentId, appointmentId) {
            console.log(studentId);
            axios
                .post("/verifyrequest", {
                    requestStatus,
                    studentId,
                    appointmentId,
                })
                .then(({ data }) => {
                    this.getAppointmentDetails();
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
