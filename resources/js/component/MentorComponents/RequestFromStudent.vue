<template lang="">
    <Modal
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
    >
        <div class="" v-if="!this.requestDetails">Loading...</div>
        <div class="flex items-start w-full" v-else>
            <div class="flex flex-col mr-5 justify-between h-full">
                <div class="text-start text-lg">
                    <h1 class="font-medium">Request header</h1>
                    <p>{{ this.requestDetails.title }}</p>
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
                            {{ this.date }}
                            <span
                                class="text-green-500 font-medium"
                                :class="{
                                    'text-red-400':
                                        startSchedule?.isBefore(now),
                                }"
                            >
                                <span v-if="startSchedule?.isBefore(now)"
                                    >Started {{ reminderdate }}
                                </span>
                                <span v-else
                                    >To start in {{ reminderdate }}
                                </span>
                            </span>
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
                        class="transition-all border border-red-400 rounded-md w-full py-2 font-semibold text-red-500 hover:bg-red-400 hover:text-white"
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
                        class="transition-all border border-green-400 rounded-md w-full py-2 font-semibold text-green-500 hover:bg-green-400 hover:text-white"
                    >
                        Accept
                    </div>
                </div>
                <div class="" v-else>
                    <div class="" v-if="this.requestDetails.statusId === 1">
                        <div
                            class="border rounded-md border-green-400 py-2 mt-5 font-semibold text-green-500"
                        >
                            Appointment Accepted
                        </div>
                        <div class="">
                            <button
                                @click="
                                    verify(
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
                        class="border rounded-md border-red-400 py-2 mt-5 font-semibold text-red-500"
                        v-if="this.requestDetails.statusId === 2"
                    >
                        Appointment Rejected
                    </div>
                    <div
                        class="border rounded-md border-red-400 py-2 mt-5 font-semibold text-red-500"
                        v-if="this.requestDetails.statusId === 3"
                    >
                        View Feedback
                    </div>
                </div>
            </div>

            <Calendar />
        </div>
    </Modal>
</template>
<script>
import Modal from "../Modal.vue";
import moment from "moment";
import { Calendar, DatePicker } from "v-calendar";

export default {
    props: ["requestId"],
    components: {
        Modal,
        Calendar,
        DatePicker,
    },
    data() {
        return {
            now: moment(),
            date: moment(this.requestDetails?.startSchedule).format(
                "YYYY-MM-DD"
            ),
            requestDetails: null,
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
        getAppointmentDetails() {
            axios
                .post("/getAppointment", { appointmentId: this.requestId })
                .then(({ data }) => {
                    this.requestDetails = data;
                    console.log(data);
                });
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
    },
    mounted() {},
};
</script>
<style lang=""></style>
