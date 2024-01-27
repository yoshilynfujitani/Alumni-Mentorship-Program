<template lang="">
    <Modal
        :modalContent="{
            title: 'Appointment',
            // content: 'Please fill out the form below:',
        }"
        buttonLabel="Request Appointment"
        cancelLabel="Back"
        saveLabel="Submit Appointment"
        @save="submitAppointment"
    >
        <!-- <label for="" class="self-start my-5 text-green-600 text-2xl font-bold"
            >Appointment Date</label
        > -->
        <div
            class="w-[1000px] flex border border-gray-200 p-10 rounded-md my-10 gap-5"
        >
            <form @submit.prevent="submitAppointment" class="">
                <div class="w-[550px]">
                    <div class="flex flex-col">
                        <DatePicker
                            v-model="date"
                            :color="color"
                            hide-time-header
                            expanded
                            borderless
                        />
                        <div class="">
                            <label
                                for="text"
                                class="block mb-2 text-sm font-medium text-start text-gray-900 dark:text-white"
                                >Tentative Date</label
                            >
                            <h1
                                class="text-green-500 font-medium border border-gray-200 px-4 py-2 rounded-md shadow-sm"
                            >
                                {{ this.date }}
                            </h1>
                        </div>
                    </div>

                    <div class="" v-if="this.type === 'pdc'">
                        <div class="">
                            <label
                                for="text"
                                class="block mb-2 text-sm font-medium text-start text-gray-900 dark:text-white"
                                >Request Header</label
                            >
                            <input
                                v-model="title"
                                type="text"
                                id="text"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                placeholder="Text goes here..."
                                required
                            />
                        </div>
                        <div class="">
                            <h1 class="text-start text-black font-medium">
                                Student To Assign To Mentor
                            </h1>
                            <h1 class="text-start">
                                {{ this.selectedStudent.name }}
                            </h1>
                        </div>
                    </div>
                </div>

                <input type="text" v-model="mentorId" hidden />
            </form>
            <div class="" v-if="this.type === 'pdc'">
                <StudentSearch @query="handleQueryData" />
            </div>
            <div class="w-full" v-if="this.type === 'student'">
                <h1 class="text-md text-gray-400 font-medium">
                    You are requesting an appointment with
                </h1>
                <div
                    class="border flex items-center gap-2 my-2 border-gray-100 rounded-md px-4 py-2"
                >
                    <img
                        class="w-12 h-12 rounded-full shadow-lg"
                        src="../../../../public/DefaultAvatar.webp"
                        alt="Avatar"
                    />
                    <div class="">
                        <h1 class="">
                            {{ this.MentorDetails.name }}
                        </h1>
                        <h1 class="text-sm text-gray-400">
                            {{ this.MentorDetails.fieldName }}
                            <span>{{ this.MentorDetails.rating }}</span>
                        </h1>
                    </div>
                </div>
                <div class="">
                    <label
                        for="text"
                        class="block mb-2 text-sm font-medium text-start text-gray-900 dark:text-white"
                        >Request Header</label
                    >
                    <input
                        v-model="title"
                        type="text"
                        id="text"
                        class="w-full shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="Text goes here..."
                        required
                    />
                </div>
                <h1>
                    Confirm all details are correct before submitting
                    appointment.
                </h1>
            </div>
        </div>
    </Modal>
</template>
<script>
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";
import Modal from "../Modal.vue";
import StudentSearch from "../PDCComponents/StudentSearch.vue";

export default {
    props: {
        type: {
            type: String,
        },
        MentorDetails: {
            type: Object,
        },
    },
    components: {
        Calendar,
        DatePicker,
        Modal,
        StudentSearch,
    },
    data() {
        return {
            name: this.MentorDetails.name,
            mentorId: this.MentorDetails.id,
            color: "green",
            date: new Date(),

            rules: [
                {
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    milliseconds: 0,
                },
            ],
            field: 7,
            title: "",
            selectedStudent: "",
        };
    },
    methods: {
        submitAppointment() {
            const { field, title, date, mentorId } = this;
            const { id } = this.selectedStudent;

            if (this.type === "pdc") {
                axios
                    .post("/assignappointment", {
                        title,
                        field,
                        date,
                        mentorId,
                        studentId: id,
                    })
                    .then(this.$router.push("/pdcmentors"));
            } else {
                axios
                    .post("/addAppointment", { title, field, date, mentorId })
                    .then(this.$router.push("/home"));
            }
        },
        handleQueryData(data) {
            this.selectedStudent = data;
        },
    },

    mounted() {},
};
</script>
