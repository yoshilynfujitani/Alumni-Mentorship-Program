<template lang="">
    <Layout>
        <div
            class="w-full my-10 overflow-x-clip flex flex-col justify-between shadow-sm sm:rounded-lg border border-gray-200"
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
                        v-if="this.appointments?.length > 0"
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Request Title</th>
                            <th scope="col" class="px-6 py-3">Field</th>
                            <th scope="col" class="px-6 py-3">Start Date</th>
                            <th scope="col" class="px-6 py-3">Mentor</th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Others
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="appointment in appointments"
                            class="bg-white dark:bg-gray-800 dark:border-gray-700"
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
                                {{
                                    moment(
                                        appointment.startSchedule,
                                        "YYYY-MM-DD HH:mm:ss"
                                    ).format("MMMM Do YYYY")
                                }}
                            </td>
                            <td class="px-6 py-4">
                                {{ appointment.name }}
                            </td>
                            <td class="px-6 py-4">
                                <h1
                                    class="text-center font-bold"
                                    :class="{
                                        'text-yellow-400':
                                            appointment.Status === 0,
                                        'text-green-400 ':
                                            appointment.Status === 1,
                                        'text-red-400':
                                            appointment.Status === 2,
                                        'text-green-700':
                                            appointment.Status === 3,
                                    }"
                                >
                                    {{ appointment.statusName }}
                                </h1>
                            </td>
                            <td
                                class="px-6 py-2 flex items-center justify-center gap-2"
                            >
                                <div
                                    class="px-4 py-2 border-dashed border rounded border-gray-300 text-gray-300 font-thin"
                                    v-if="appointment.Status !== 3"
                                >
                                    Unavailable
                                </div>
                                <div class="" v-else>
                                    <button
                                        :disabled="appointment.Status !== 3"
                                        :class="{
                                            hidden: appointment.Status !== 3,
                                        }"
                                    >
                                        <FeedbackForm
                                            :appointmentId="
                                                appointment.appointmentId
                                            "
                                            userRole="Student"
                                            :userToRateId="appointment.mentorId"
                                            :disable="appointment.Status !== 3"
                                        />
                                    </button>
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
    </Layout>
</template>

<script>
import { mapState, mapActions } from "vuex";
import Chat from "../component/Chat.vue";
import FeedbackForm from "../component/StudentComponents/FeedbackForm.vue";
import Pagination from "../utils/Pagination.vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import moment from "moment";

export default {
    computed: {
        ...mapState(["userId"]),
    },
    components: {
        FeedbackForm,
        Chat,
        Pagination,
        Dialog,
        Button,
    },

    data() {
        return {
            loading: false,
            appointments: null,
            pagination: null,
            visible: false,
            moment: moment,
        };
    },

    methods: {
        getAppointments() {
            this.loading = true;
            axios.get("/getAppointments").then(({ data }) => {
                this.appointments = data.data;
                this.pagination = data;
                console.log(data);

                this.loading = false;
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
                .get(`/getAppointments?page=${page}`)
                .then(({ data }) => {
                    console.log(data);

                    this.appointments = data.data;
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
        this.getAppointments();
    },
};
</script>
<style lang=""></style>
