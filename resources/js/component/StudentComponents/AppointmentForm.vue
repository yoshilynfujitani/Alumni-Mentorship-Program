<template lang="">
    <Modal
        :modalContent="{
            title: 'Appointment',
            // content: 'Please fill out the form below:',
        }"
        buttonLabel="Appoint Student"
        cancelLabel="Back"
        saveLabel="Submit Appointment"
        @save="submitAppointment"
    >
        <!-- <label for="" class="self-start my-5 text-green-600 text-2xl font-bold"
            >Appointment Date</label
        > -->
        <div class="flex border border-gray-200 p-10 rounded-md my-10 gap-5">
            <form @submit.prevent="submitAppointment" class="">
                <div class="">
                    <div class="flex flex-col">
                        <DatePicker
                            v-model="date"
                            :color="color"
                            hide-time-header
                            expanded
                            borderless
                        />
                    </div>
                    <div class="">
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
            <div class=""><StudentSearch @query="handleQueryData" /></div>
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
            }
            if (this.type === "student") {
                axios
                    .post("/addAppointment", { title, field, date, mentorId })
                    .then(this.$router.push("/home"));
            }
        },
        handleQueryData(data) {
            this.selectedStudent = data;
            console.log(this.selectedStudent);
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
