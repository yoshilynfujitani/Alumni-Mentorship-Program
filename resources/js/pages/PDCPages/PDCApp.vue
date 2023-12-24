<template>
    <LayoutPDC>
        <div class="max-w-[800px]">
            <div class="" v-if="loading"><h1>Loading...</h1></div>
            <div class="" v-else>
                <div
                    class="flex flex-col items-center gap-5"
                    v-if="appointments == 0"
                >
                    You dont have any appointments
                    <router-link to="/mentors">
                        <button
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white w-fit rounded-md"
                        >
                            Find a mentor
                        </button></router-link
                    >
                </div>
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    v-else
                >
                    <DatePicker
                        v-model="date"
                        :color="color"
                        expanded
                        borderless
                        :attributes="attributes"
                    />
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <caption
                            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                        >
                            Your Appointmentssssss
                            <p
                                class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400"
                            >
                                Browse a list of Flowbite products designed to
                                help you work and play, stay organized, get
                                answers, keep in touch, grow your business, and
                                more.
                            </p>
                        </caption>
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Request Title
                                </th>
                                <th scope="col" class="px-6 py-3">Field</th>
                                <th scope="col" class="px-6 py-3">
                                    Start Date
                                </th>
                                <th scope="col" class="px-6 py-3">Mentor</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="appointment in appointments"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ appointment.title }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ appointment.field }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ appointment.startSchedule }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ appointment.name }}
                                </td>
                                <td class="\ text-right">
                                    <h1
                                        v-if="appointment.Status === 0"
                                        class="text-white font-bold bg-yellow-400 py-2 px-4 rounded-md"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 1"
                                        class="text-white font-bold bg-green-400 py-2 px-4 rounded-md"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                    <h1
                                        v-if="appointment.Status === 2"
                                        class="text-white font-bold bg-red-400 py-2 px-4 rounded-md"
                                    >
                                        {{ appointment.statusName }}
                                    </h1>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="#"
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline"
                                        >Chat</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </LayoutPDC>
</template>

<script>
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";
export default {
    components: {
        Calendar,
        DatePicker,
    },
    data() {
        return {
            appointments: [],
            loading: false,

            attributes: [
                {
                    // An optional key can be used for retrieving this attribute later,
                    // and will most likely be derived from your data object
                    key: 1,
                    // Attribute type definitions
                    content: "green", // Boolean, String, Object

                    dot: true, // Boolean, String, Object

                    // We also need some dates to know where to display the attribute
                    // We use a single date here, but it could also be an array of dates,
                    //  a date range or a complex date pattern.
                    dates: [],

                    order: 0,
                },
            ],
        };
    },
    methods: {
        getAppointments() {
            this.loading = true;
            axios.get("/getAppointments").then(({ data }) => {
                console.log(data);
                this.appointments = data;
                this.attributes[0].dates = data.map(
                    (appointment) => new Date(appointment.startSchedule)
                );
                this.loading = false;
            });
        },

        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                console.log(data);
                if (!data) {
                    this.$router.push("/");
                }
            });
        },
        refecthAppointments() {
            this.getAppointments();
        },
    },

    created() {
        this.getAppointments();
        this.checkAuth();
    },
    mounted() {
        this.refecthAppointments();
        this.checkAuth();
    },
    watch: {
        authenticated(newValue) {
            if (!newValue) {
                this.$router.push("/login");
            }
        },
    },
};
</script>
