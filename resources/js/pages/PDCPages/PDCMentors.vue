<template lang="">
    <LayoutPDC>
        <div class="self-start space-x-2">
            <div class="self-start">
                <h1 class="flex items-center text-2xl gap-1 font-medium">
                    <i class="pi pi-users text-2xl text-yellow-400"></i>
                    <span class="text-green-700">Mentors</span>
                </h1>
            </div>
            <div class="w-80 my-2.5">
                <span class="text-sm font-medium text-green-600">Sort By</span>
                <Dropdown
                    v-model="fetchMentorBy"
                    :options="this.mentorStatus"
                    optionLabel="name"
                    placeholder="Sort by Status"
                    class="w-full md:w-14rem border-gray-200 border focus:border-2 focus:border-green-500"
                    @change="handleFilterChange"
                />
            </div>
        </div>

        <!-- <div class="grid grid-cols-4 gap-5 mx-auto my-10">
            <div class="mx-auto" v-for="Mentor in mentors">
                <MentorCard :MentorDetails="Mentor" />
            </div>

        </div> -->
        <div v-if="isLoading">
            <UnSpinnerAlt class="animate-spin text-green-500" />
        </div>

        <div
            class="self-start overflow-x-auto w-full min-h-full shadow-md sm:rounded-lg"
            v-else
        >
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase dark:text-gray-400"
                >
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            Instructor's Name
                        </th>
                        <th scope="col" class="px-6 py-3">College</th>
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            Field
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            Field
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="Mentor in mentors"
                        :key="Mentor.id"
                        class="border-b border-gray-200 dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="flex items-center gap-2 px-6 py-7 h-full font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800"
                        >
                            <img
                                class="w-7 h-7 rounded-full"
                                src="../../../../public/DefaultAvatar.webp"
                                alt="Avatar"
                            />{{ Mentor.name }}
                        </th>
                        <td class="px-6 py-4">{{ Mentor.statusName }}</td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                            {{ Mentor.fieldName }}
                        </td>
                        <td
                            class="px-6 py-4 flex justify-center"
                            v-if="fetchMentorBy == null"
                        >
                            <h1
                                class="font-bold"
                                :class="{
                                    'text-yellow-400': Mentor.verified === 0,
                                    'text-green-400': Mentor.verified === 1,
                                    'text-red-400': Mentor.verified === 2,
                                    'text-green-700': Mentor.verified === 3,
                                }"
                            >
                                {{ Mentor.statusName }}
                            </h1>
                        </td>
                        <td
                            class="px-6 py-4 text-center"
                            v-if="fetchMentorBy.id === 1"
                        >
                            <ConfirmPopup></ConfirmPopup>
                            <div class="flex gap-2 justify-content-center">
                                <button
                                    @click="AcceptRequest($event, 1)"
                                    class="px-2 py-1 bg-green-400 text-white rounded font-medium"
                                >
                                    Approve
                                </button>
                                <button
                                    @click="RejectRequest($event, 2)"
                                    class="px-2 py-1 bg-red-400 text-white rounded font-medium"
                                >
                                    Reject
                                </button>
                            </div>
                        </td>
                        <td
                            class="text-center"
                            v-if="fetchMentorBy === 'active'"
                        >
                            <AppointmentForm
                                :MentorDetails="Mentor"
                                type="pdc"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination
                @next="goToNextPage"
                @back="goToPrevPage"
                :total="this.pagination.total"
                :current_page="this.pagination.current_page"
                :last_page="this.pagination.last_page"
            />
        </div>
    </LayoutPDC>
</template>
<script>
import MentorCard from "../../component/MentorComponents/MentorCard.vue";
import { UnSpinnerAlt } from "@kalimahapps/vue-icons";
import AppointmentForm from "../../component/StudentComponents/AppointmentForm.vue";
import Pagination from "../../utils/Pagination.vue";
import Dropdown from "primevue/dropdown";
import ConfirmPopup from "primevue/confirmpopup";
import Button from "primevue/button";
import Dialog from "primevue/dialog";

export default {
    components: {
        MentorCard,
        UnSpinnerAlt,
        AppointmentForm,
        Pagination,
        Dropdown,
        ConfirmPopup,
        Button,
        Dialog,
    },
    data() {
        return {
            mentors: [],
            pagination: {},
            fetchMentorBy: null,
            mentorStatus: [
                { id: 0, name: "Active" },
                { id: 1, name: "Pending" },
                { id: 2, name: "All" },
            ],
            isLoading: false,
            isEdit: false,
            visible: false,
        };
    },
    methods: {
        handleFilterChange() {
            // Call getMentors when the selected course changes
            this.getMentors();
        },
        getMentors() {
            this.isLoading = true;
            const { fetchMentorBy } = this;

            axios
                .post(`/getmentorAPI`, {
                    searchBy: this.fetchMentorBy ? this.fetchMentorBy.id : null,
                })
                .then(({ data }) => {
                    console.log(data);

                    this.mentors = data.data;
                    this.pagination = data;
                    this.isLoading = false;
                });
        },
        updateStatus(mentor) {
            mentor.isEdit = !mentor.isEdit;
        },
        verify(statusId, mentorId) {
            axios
                .post("/editmentorstatus", { statusId, mentorId })
                .then(({ data }) => {
                    console.log(data);
                    this.getMentors();
                });
        },
        AcceptRequest(event, statusId, mentorId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to proceed?",
                icon: "pi pi-exclamation-triangle text-red-400",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-sm text-white bg-green-400 px-2 py-1 ml-2",
                rejectLabel: "Cancel",
                acceptLabel: "Approve",
                accept: () => {
                    this.verify(statusId, mentorId);
                },
                reject: () => {},
            });
        },
        RejectRequest(event, statusId, mentorId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to proceed?",
                icon: "pi pi-exclamation-triangle text-red-400",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-danger p-button-sm bg-red-400 px-2 py-1 ml-2 text-white",
                rejectLabel: "Cancel",
                acceptLabel: "Reject",
                accept: () => {
                    this.verify(statusId, mentorId);
                },
                reject: () => {},
            });
        },
        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                const prevPage = this.pagination.current_page - 1;
                this.fetchMentors(prevPage);
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                const nextPage = this.pagination.current_page + 1;
                this.fetchMentors(nextPage);
            }
        },
        fetchMentors(page) {
            this.isLoading = true;
            const { fetchMentorBy } = this;
            axios
                .post(`/getmentorAPI?page=${page}`, {
                    searchBy: fetchMentorBy ? fetchMentorBy.id : null,
                })
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
    },
};
</script>
<style lang=""></style>
