<template lang="">
    <LayoutMentor>
        <div
            class="w-full overflow-x-clip flex flex-col justify-between shadow-sm sm:rounded-lg border border-gray-200"
        >
            <div class="">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <caption
                        class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                    >
                        Your Appointments
                    </caption>
                    <thead
                        v-if="this.requests?.length > 0"
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Student</th>
                            <th scope="col" class="px-6 py-3">Field</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Requested By
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Verify
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Others
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="Request in requests"
                            :key="Request.appointmentId"
                            class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            <th
                                scope="row"
                                class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                            >
                                {{ Request.name }}
                            </th>
                            <td class="px-6 py-4">{{ Request.course }}</td>

                            <td
                                class="px-6 py-4 flex flex-col items-center justify-center text-center"
                            >
                                <h1
                                    class="text-center font-bold"
                                    :class="{
                                        'text-yellow-400': Request.Status === 0,
                                        'text-green-400 ': Request.Status === 1,
                                        'text-red-400': Request.Status === 2,
                                        'text-green-700': Request.Status === 3,
                                    }"
                                >
                                    {{ Request.statusName }}
                                </h1>
                            </td>
                            <td class="text-center px-6 py-2">
                                {{ Request.requestor }}
                            </td>
                            <td class="text-center px-6 py-2">
                                <button @click="updateStatus(Request)">
                                    <RequestFromStudent
                                        :requestId="Request.appointmentId"
                                        @Updated="getRequests"
                                    />
                                </button>
                            </td>
                            <td
                                class="px-6 py-2 flex items-center justify-center gap-2"
                            >
                                <div
                                    class="px-4 py-2 border-dashed border rounded border-gray-300 text-gray-300 font-thin flex items-center justify-center"
                                    v-if="Request.Status !== 3"
                                >
                                    Unavailable
                                </div>
                                <!-- <Chat :appointmentId="Request.appointmentId" /> -->
                                <div
                                    :class="{ ' hidden': Request.Status !== 3 }"
                                >
                                    <FeedbackForm
                                        :appointmentId="Request.appointmentId"
                                        :userToRateId="Request.studentId"
                                        userRole="Mentor"
                                        :disable="Request.Status !== 3"
                                    />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
