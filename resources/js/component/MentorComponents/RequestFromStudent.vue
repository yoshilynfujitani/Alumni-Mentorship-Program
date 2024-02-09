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
        <div class="flex items-start w-[700px] justify-between" v-else>
            <div
                class="flex flex-col mr-5 justify-between h-full"
                v-if="!this.showFeedback"
            >
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
                        <button @click="setShowFeedback">View Feedback</button>
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
                                    v-if="!this.requestDetails.rating"
                                >
                                    No rating.
                                </h1>
                                <h1 class="text-sm text-gray-400" v-else>
                                    {{ this.requestDetails.rating }}/5
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border border-gray-200 rounded-md p-5 w-full h-full"
                    >
                        <h1 class="font-medium">Comments</h1>
                        <h1 v-if="!this.requestDetails.comments">
                            Student have not yet submitted any feedback.
                        </h1>
                        <h1 class="overflow-y-scroll" v-else>
                            {{ this.requestDetails.comments }}
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
    </Modal>
</template>
<script>
import Modal from "../Modal.vue";
import moment from "moment";
import Calendar from "primevue/calendar";

export default {
    props: ["requestId"],
    components: {
        Modal,
        Calendar,
    },
    data() {
        return {
            now: moment(),
            date: moment(this.requestDetails?.startSchedule).format(
                "YYYY-MM-DD"
            ),
            requestDetails: null,
            showFeedback: false,
            minDate: null,
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
        setShowFeedback() {
            console.log("click");
            this.showFeedback = !this.showFeedback;
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

        getToday() {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set hours to 00:00:00 for accurate comparison
            return today;
        },
    },
    mounted() {
        this.minDate = this.getToday();
    },
};
</script>
<style lang=""></style>
