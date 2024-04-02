<template lang="">
    <!-- <Modal
        :modalContent="{
            title: 'Appointment',
            // content: 'Please fill out the form below:',
        }"
        buttonLabel="Request Appointment"
        cancelLabel="Back"
        saveLabel="Submit Appointment"
        @save="submitAppointment"
    > -->
    <!-- <label for="" class="self-start my-5 text-green-600 text-2xl font-bold"
            >Appointment Date</label
        > -->
    <button
        label="Show"
        @click="visible = true"
        class="bg-green-700 w-full px-2 py-1 rounded-md text-white text-sm"
    >
        Request Appointment
    </button>

    <Dialog v-model:visible="visible" modal header="Schedule an Appointment">
        <div
            class="w-[1000px] flex border border-gray-200 p-10 rounded-md my-10 gap-5"
        >
            <form @submit.prevent="submitAppointment" class="">
                <div class="w-[550px]">
                    <div class="flex flex-col">
                        <Calendar
                            v-model="date"
                            inline
                            showWeek
                            :numberOfMonths="1"
                            :minDate="minDate"
                        />
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
                <div class="my-2">
                    <div class="card flex justify-content-center">
                        <Dropdown
                            v-model="selectedField"
                            :options="this.courses"
                            :highlightOnSelect="false"
                            optionLabel="name"
                            placeholder="Select a field"
                            class="w-full text-xs"
                        />
                    </div>
                    <label
                        for="text"
                        class="block mb-2 text-sm font-medium text-start text-gray-900 dark:text-white"
                        >Tentative Date</label
                    >
                    <h1
                        class="text-green-500 text-sm border border-gray-200 px-4 py-2 rounded-md shadow-sm"
                    >
                        {{
                            moment(
                                this.date,
                                "ddd MMM DD YYYY HH:mm:ss [GMT]ZZ (Philippine Standard Time)"
                            ).format("MMMM Do YYYY")
                        }}
                    </h1>
                </div>

                <Message severity="warn">
                    Confirm all details are correct before submitting
                    appointment.</Message
                >
            </div>
        </div>
        <div class="flex justify-content-end gap-2">
            <button
                type="button"
                label="Cancel"
                severity="secondary"
                @click="visible = false"
            >
                Cancel
            </button>
            <button type="button" label="Save" @click="submitAppointment">
                Submit
            </button>
        </div>
    </Dialog>
    <!-- </Modal> -->
</template>
<script>
import { mapState } from "vuex";
import Modal from "../Modal.vue";
import StudentSearch from "../PDCComponents/StudentSearch.vue";
import Calendar from "primevue/calendar";
import moment from "moment";
import Toast from "primevue/toast";
import Dropdown from "primevue/dropdown";
import Dialog from "primevue/dialog";

import Message from "primevue/message";

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
        Message,
        Modal,
        StudentSearch,
        Dialog,
        Toast,
    },
    computed: {
        ...mapState(["fieldToTake"]),
    },
    data() {
        return {
            moment: moment,
            name: this.MentorDetails.name,
            mentorId: this.MentorDetails.id,
            email: this.MentorDetails.email,
            color: "green",
            date: new Date(),
            visible: false,
            rules: [
                {
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    milliseconds: 0,
                },
            ],

            title: "",
            selectedStudent: "",
            minDate: null,
            courses: [
                { id: 1, name: "Business Management" },
                { id: 2, name: "Creative Arts" },
                { id: 3, name: "Engineering and Mathematics" },
                { id: 4, name: "Humanities Arts and Social Sciences" },
                { id: 5, name: "IT and Computer Science" },
                { id: 6, name: " Medical and Health Science" },
                { id: 7, name: "Teaching and Education" },
                { id: 8, name: "Leadership and Team Building" },
            ],
        };
    },
    methods: {
        submitAppointment() {
            const { title, date, mentorId, email } = this;
            const { id } = this.selectedStudent;

            if (this.type === "pdc") {
                axios
                    .post("/assignappointment", {
                        title,
                        field: this.fieldToTake,
                        date,
                        mentorId,
                        studentId: id,
                    })
                    .then(() => {
                        this.$router.push("/pdcmentors");
                        axios
                            .post("/sendEmailAppointment", { email: email })
                            .then(console.log("Success"));
                    });

                this.$toast.add({
                    severity: "info",
                    summary: "Info",
                    detail: "Message Content",
                    life: 3000,
                });
            } else if (this.type === "student") {
                axios
                    .post("/addAppointment", {
                        title,
                        field: this.fieldToTake,
                        date,
                        mentorId,
                    })
                    .then(() => {
                        this.$router.push("/appointments");
                        axios
                            .post("/sendEmailAppointment", { email: email })
                            .then(console.log("Success"));
                    });

                this.$toast.add({
                    severity: "info",
                    summary: "Info",
                    detail: "Message Content",
                    life: 3000,
                });
            }
        },

        handleQueryData(data) {
            this.selectedStudent = data;
        },
        getToday() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return today;
        },
    },

    mounted() {
        this.minDate = this.getToday();
    },
};
</script>
<style>
.p-message-text {
    font-size: 12px;
}
</style>
