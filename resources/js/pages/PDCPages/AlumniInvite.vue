<template>
    <LayoutPDC>
        <Toast />
        <div class="w-full py-20">
            <h1 class="self-start text-2xl font-bold py-2.5">MMSU Alumni</h1>
            <div class="space-x-2.5 pb-2.5">
                <input
                    v-model="alumniQuery"
                    type="text"
                    class="border-gray-300 rounded-md"
                    placeholder="Search alumni..."
                />
                <button
                    class="bg-green-600 px-4 py-2 rounded-md text-white"
                    @click="searchAlumni"
                >
                    Search
                </button>
            </div>
            <div
                class="grid grid-cols-5 w-full gap-5 border p-5 rounded-md border-gray-300"
            >
                <div class="" v-for="Alum in Alumni">
                    <AlumniCard :Alum="Alum" />
                </div>
            </div>
        </div>
    </LayoutPDC>
</template>

<script>
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";
import AlumniCard from "../../component/PDCComponents/AlumniCard.vue";

import Toast from "primevue/toast";

export default {
    components: {
        Calendar,
        DatePicker,
        Toast,
        AlumniCard,
    },
    data() {
        return {
            Alumni: [],
            alumniQuery: "",
        };
    },
    methods: {
        getAlumni() {
            axios.get("/getalumni").then(({ data }) => {
                this.Alumni = data;
            });
        },
        searchAlumni() {
            const { alumniQuery } = this;
            axios
                .post("/searchAlumni", { alumniQuery: alumniQuery })
                .then(({ data }) => {
                    this.Alumni = data;
                });
        },
    },

    mounted() {
        this.getAlumni();
    },
};
</script>
