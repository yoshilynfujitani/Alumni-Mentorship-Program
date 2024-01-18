<template lang="">
    <Modal
        :modalContent="{
            title: 'Appointment',
            // content: 'Please fill out the form below:',
        }"
        buttonLabel="Make Appointment"
        cancelLabel="Back"
        saveLabel="Submit Appointment"
        @save="submitAppointment"
    >
        <label for="" class="self-start my-5 text-green-600 text-2xl font-bold"
            >Appointment Date</label
        >
        <div class="w-full flex bg-green-50/40 p-5 rounded-md">
            <form @submit.prevent="submitAppointment" class="">
                <div class="flex gap-5">
                    <div class="flex flex-col w-1/2">
                        <DatePicker
                            v-model="date"
                            :color="color"
                            hide-time-header
                            expanded
                            borderless
                        />
                    </div>
                    <div class="mx-5">
                        <div class="">
                            <label
                                for="text"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
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

                        <!-- <div class="my-4">
                            <label
                                for="field"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Select a field to request</label
                            >
                            <select
                                v-model="field"
                                id="field"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                            >
                                <option selected>Choose a Field</option>
                                <option value="1">Business Management</option>
                                <option value="2">Creative Arts</option>
                                <option value="3">
                                    Engineering and Mathematics
                                </option>
                                <option value="4">
                                    Humanities Arts and Social Sciences
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
                        </div> -->
                    </div>
                </div>

                <input type="text" v-model="mentorId" hidden />
            </form>
            <div class=""><StudentSearch /></div>
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
            field: "",
            title: "",
        };
    },
    methods: {
        submitAppointment() {
            const { field, title, date, mentorId } = this;

            if (this.type === "pdc") {
                axios
                    .post("/addAppointment", { title, field, date, mentorId })
                    .then(this.$router.push("/home"));
            }
            if (this.type === "student") {
                axios
                    .post("/addAppointment", { title, field, date, mentorId })
                    .then(this.$router.push("/home"));
            }
        },
    },
    watch: {
        selectedDate(newDate) {
            console.log(this.date);
        },
    },
    mounted() {
        console.log(this.type);
    },
};
</script>
