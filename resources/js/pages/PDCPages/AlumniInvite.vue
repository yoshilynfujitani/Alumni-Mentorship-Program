<template>
    <Toast />
    <div class="w-full py-10">
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
            class="grid lg:grid-cols-5 xl:grid-cols-6 gap-2.5 border p-5 rounded-md border-gray-300"
        >
            <div class="" v-for="Alum in Alumni" :key="Alum.id">
                <AlumniCard :Alum="Alum" />
            </div>
        </div>
        <div class="my-5">
            <Pagination
                @next="goToNextPage"
                @back="goToPrevPage"
                :total="this.pagination?.total"
                :current_page="this.pagination?.current_page"
                :last_page="this.pagination?.last_page"
            />
        </div>
    </div>
</template>

<script>
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";
import AlumniCard from "../../component/PDCComponents/AlumniCard.vue";

import Toast from "primevue/toast";
import Pagination from "../../utils/Pagination.vue";

export default {
    components: {
        Calendar,
        DatePicker,
        Toast,
        AlumniCard,
        Pagination,
    },
    data() {
        return {
            Alumni: [],
            alumniQuery: "",
            pagination: null,
        };
    },
    methods: {
        getAlumni() {
            axios.get("/getalumni").then(({ data }) => {
                this.Alumni = data.data;
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total,
                };
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
        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                const prevPage = this.pagination.current_page - 1;
                this.fetchRequests(prevPage);
                this.scrollToTop();
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                const nextPage = this.pagination.current_page + 1;
                this.fetchRequests(nextPage);
                this.scrollToTop();
            }
        },
        fetchRequests(page) {
            axios.get(`/getalumni?page=${page}`).then(({ data }) => {
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total,
                };
                this.Alumni = data.data;
            });
        },
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },
    },

    mounted() {
        this.getAlumni();
    },
};
</script>
