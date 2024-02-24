<template lang="">
    <Layout>
        <!-- <div class="" v-if="!apptAccessData">Loading...</div> -->
        <div class="my-10 flex justify-center flex-col items-center w-full">
            <div class="self-start">
                <h1 class="flex items-center text-2xl gap-1 font-medium">
                    <i class="pi pi-users text-2xl text-yellow-400"></i>
                    <span class="text-green-700">Mentors</span>
                </h1>
            </div>
            <div class="w-fit" v-if="this.allowToAppoint === 2">
                <Message severity="warn">
                    You have already sent an appointment request to a mentor.
                    Please wait before sending another one.</Message
                >
            </div>
            <div
                class="bg-white border border-gray-200 rounded-md p-5 my-5 w-full"
            >
                <div class="px-1">
                    <div class="w-80 my-2.5">
                        <span class="text-sm font-medium text-green-600"
                            >Sort By</span
                        >
                        <Dropdown
                            v-model="selectedCourse"
                            :options="this.courses"
                            optionLabel="name"
                            placeholder="Select a Field"
                            class="w-full md:w-14rem border-gray-200 border focus:border-2 focus:border-green-500"
                            @change="handleCourseChange"
                        />
                    </div>
                </div>
                <div
                    class="grid grid-cols-1 tablet:grid-cols-3 laptop:grid-cols-4 desktop:grid-cols-5 gap-5 mx-auto h-full w-full auto-rows-fr"
                >
                    <div class="mx-auto" v-for="Mentor in mentors">
                        <MentorCard
                            :MentorDetails="Mentor"
                            :displaybtn="
                                this.allowToAppoint === 1 &&
                                !Mentor.hasAppointment
                            "
                        />
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
        </div>
    </Layout>
</template>
<script>
import MentorCard from "../component/MentorComponents/MentorCard.vue";
import Pagination from "../utils/Pagination.vue";
import Message from "primevue/message";
import Dropdown from "primevue/dropdown";
import { mapState, mapActions } from "vuex";
export default {
    components: {
        MentorCard,
        Message,
        Dropdown,
        Pagination,
    },
    data() {
        return {
            mentors: [],
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
            selectedCourse: null,
            pagination: null,
        };
    },
    computed: {
        ...mapState([
            "userId",
            "ticketStatus",
            "fieldToTake",
            "allowToAppoint",
        ]),
    },
    methods: {
        ...mapActions(["setUserDetailsAction"]),
        getMentors() {
            const { fieldToTake, allowToAppoint, selectedCourse } = this;
            axios
                .post(`/getmentorstudent`, {
                    fieldToTake,
                    allowToAppoint,
                    selectedCourseId: selectedCourse ? selectedCourse.id : null,
                })
                .then(({ data }) => {
                    console.log(this.fieldToTake);
                    this.mentors = data.data;
                    this.pagination = data;
                });
        },
        handleCourseChange() {
            // Call getMentors when the selected course changes
            this.getMentors();
        },

        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                const prevPage = this.pagination.current_page - 1;
                this.fetchRequests(prevPage);
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                const nextPage = this.pagination.current_page + 1;
                this.fetchRequests(nextPage);
            }
        },
        fetchRequests(page) {
            this.isLoading = true;

            axios
                .get(
                    `/getmentorstudent?page=${page}&field=${
                        this.selectedCourse.id ? this.selectedCourse.id : null
                    }`
                )
                .then(({ data }) => {
                    console.log(data);

                    this.mentors = data.data;
                    this.pagination = data;
                })
                .catch((error) => {
                    console.error("Error fetching mentors:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
    },

    mounted() {
        this.getMentors();
        this.setUserDetailsAction();
    },
};
</script>
<style lang=""></style>
