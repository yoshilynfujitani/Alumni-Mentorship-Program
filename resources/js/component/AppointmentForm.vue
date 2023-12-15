<template lang="">
    <Layout>
        <div class="">
            <h1>{{ this.name }}</h1>
            <form @submit.prevent="submitAppointment" class="">
                <div class="">
                    <div class="">
                        <div class="mb-5">
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

                        <label
                            for="field"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Select Subject</label
                        >
                        <select
                            v-model="field"
                            id="field"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option>English</option>
                            <option>Science</option>
                            <option>Math</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-5 my-5 w-full">
                        <label for="">Appointment Date</label>
                        <DatePicker
                            v-model="date"
                            :color="color"
                            mode="dateTime"
                            hide-time-header
                            expanded
                        />
                    </div>
                </div>
                <input type="text" v-model="mentorId" hidden />
                <button
                    type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                >
                    Make Appointment
                </button>
            </form>
        </div>
    </Layout>
</template>
<script>
import Layout1 from "../Layout/Layout1.vue";
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";

export default {
    components: {
        Layout1,
        Calendar,
        DatePicker,
    },
    data() {
        return {
            name: this.$route.query.mentor,
            mentorId: this.$route.params.id,
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

            axios
                .post("/addAppointment", { title, field, date, mentorId })
                .then(this.$router.push("/home"));
        },
    },
    watch: {
        selectedDate(newDate) {
            console.log(this.date);
        },
    },
};
</script>
