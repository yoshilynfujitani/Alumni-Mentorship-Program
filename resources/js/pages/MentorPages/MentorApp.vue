<template>
    <LayoutMentor>
        <h1>Hello Mentor</h1>
    </LayoutMentor>
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
