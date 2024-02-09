<template>
    <LayoutPDC>
        <h1>Hello</h1>
        <button @click="sendEmail">Send Email</button>
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
        return {};
    },
    methods: {
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                console.log(data);
                if (!data) {
                    this.$router.push("/");
                }
            });
        },

        sendEmail() {
            axios.get("/sendEmail").then(({ data }) => {
                console.log(data);
            });
        },
    },

    mounted() {},
    watch: {
        authenticated(newValue) {
            if (!newValue) {
                this.$router.push("/login");
            }
        },
    },
};
</script>
