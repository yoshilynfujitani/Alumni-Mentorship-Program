<template lang="">
    <LayoutMentor>
        <div class="self-start">
            <h1>Pending Appointments</h1>
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
            class="self-start overflow-x-auto w-full shadow-md sm:rounded-lg"
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
                            Student's Name
                        </th>
                        <th scope="col" class="px-6 py-3">Course</th>

                        <th scope="col" class="px-6 py-3 text-center">
                            Status
                        </th>

                        <th scope="col" class="px-16 py-3 text-center">
                            Requested By
                        </th>
                        <th scope="col" class="px-8 py-3 text-center">Edit</th>
                        <th scope="col" class="px-8 py-3 text-center">Chat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="Request in requests"
                        :key="Request.appointmentId"
                        class="border-b border-gray-200 dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                        >
                            {{ Request.name }}
                        </th>
                        <td class="px-6 py-4">{{ Request.course }}</td>

                        <td
                            class="flex flex-col items-center justify-center h-24"
                        >
                            <h1
                                v-if="Request.Status === 0"
                                class="text-white font-bold bg-yellow-400 py-2 px-4 rounded-md w-fit"
                            >
                                {{ Request.statusName }}
                            </h1>
                            <h1
                                v-if="Request.Status === 1"
                                class="text-white font-bold bg-green-400 py-2 px-4 rounded-md w-fit"
                            >
                                {{ Request.statusName }}
                            </h1>
                            <h1
                                v-if="Request.Status === 2"
                                class="text-white font-bold bg-red-400 py-2 px-4 rounded-md w-fit text-center"
                            >
                                {{ Request.statusName }}
                            </h1>
                            <h1
                                v-if="Request.Status === 3"
                                class="text-white font-bold bg-green-600 py-2 px-4 rounded-md w-fit text-center"
                            >
                                {{ Request.statusName }}
                            </h1>
                        </td>
                        <td class="py-4 text-center">
                            {{ Request.requestor }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="updateStatus(Request)">
                                <RequestFromStudent
                                    :requestId="Request.appointmentId"
                                />
                            </button>
                        </td>
                        <td>
                            <!-- <Chat :appointmentId="Request.appointmentId" /> -->
                            <FeedbackForm
                                :appointmentId="Request.appointmentId"
                                :userToRateId="Request.studentId"
                                userRole="Mentor"
                                :disable="Request.Status !== 3"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination
                @next="goToNextPage"
                @back="goToPrevPage"
                :total="this.pagination?.total"
                :current_page="this.pagination?.current_page"
                :last_page="this.pagination?.last_page"
            />
        </div>
    </LayoutMentor>
</template>
<script>
import MentorCard from "../../component/MentorComponents/MentorCard.vue";
import RequestFromStudent from "../../component/MentorComponents/RequestFromStudent.vue";
import Pagination from "../../utils/Pagination.vue";
import Chat from "../../component/Chat.vue";
import { UnSpinnerAlt } from "@kalimahapps/vue-icons";
import FeedbackForm from "../../component/StudentComponents/FeedbackForm.vue";

export default {
    components: {
        MentorCard,
        UnSpinnerAlt,
        Chat,
        RequestFromStudent,
        Pagination,
        FeedbackForm,
    },
    data() {
        return {
            requests: [],
            pagination: {},
            isLoading: false,
            isEdit: false,
        };
    },
    methods: {
        getRequests() {
            this.isLoading = true;

            axios.get("/getstudentrequests").then(({ data }) => {
                console.log(data);
                this.requests = data.data;
                this.pagination = data;
                this.isLoading = false;
            });
        },
        updateStatus(Request) {
            Request.isEdit = !Request.isEdit;
        },
        verify(requestStatus, studentId, appointmentId) {
            axios
                .post("/verifyrequest", {
                    requestStatus,
                    studentId,
                    appointmentId,
                })
                .then(({ data }) => {
                    this.getRequests();
                });
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
                .get(`/getstudentrequests?page=${page}`)
                .then(({ data }) => {
                    console.log(data);

                    this.requests = data.data;
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
        this.getRequests();
    },
};
</script>
<style lang=""></style>
