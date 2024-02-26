<template>
    <LayoutPDC>
        <Toast />
        <div class="">
            <div class="bg-green-500" v-for="Alum in Alumni">
                {{ Alum.name }}

                <button @click="sendEmail(Alum.email)">Send Invite</button>
            </div>
        </div>
    </LayoutPDC>
</template>

<script>
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";

import Toast from "primevue/toast";

export default {
    components: {
        Calendar,
        DatePicker,
        Toast,
    },
    data() {
        return {
            Alumni: [],
        };
    },
    methods: {
        getAlumni() {
            axios.get("/getalumni").then(({ data }) => {
                this.Alumni = data;
            });
        },

        sendEmail(email) {
            axios.post("/sendEmail", { email: email }).then(({ data }) => {
                this.$toast.add({
                    severity: "success",
                    summary: "Success Message",
                    detail: data,
                    life: 3000,
                });
            });
        },
    },

    mounted() {
        this.getAlumni();
    },
};
</script>
