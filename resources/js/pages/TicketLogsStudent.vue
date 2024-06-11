<template lang="">
    <Layout>
        <!-- <div class="grid grid-cols-4 gap-5 mx-auto my-10">
            <div class="mx-auto" v-for="Mentor in mentors">
                <MentorCard :MentorDetails="Mentor" />
            </div>

        </div> -->
        <div v-if="isLoading">Loading..</div>

        <div
            class="self-start overflow-x-auto w-full shadow-sm rounded-md my-10 border border-gray-200"
            v-else
        >
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <caption
                    class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                >
                    Your Ticket Logs
                </caption>
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="pl-6 py-2">Student's Name</th>
                        <th scope="col" class="text-center">Request Date</th>
                        <th scope="col" class="pl-6">Field</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="Ticket in tickets"
                        :key="Ticket.id"
                        class="border-b border-gray-200 dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap"
                        >
                            {{ Ticket.name }}
                        </th>
                        <td class="px-6 py-4 flex items-center justify-center">
                            {{
                                moment(
                                    Ticket.created_at,
                                    "YYYY-MM-DD HH:mm:ss"
                                ).format("MMMM Do YYYY")
                            }}
                        </td>
                        <td class="px-6 py-4">
                            {{ Ticket.fieldName }}
                        </td>
                        <td class="px-6 py-4 justify-center">
                            <h1
                                class="font-bold text-center"
                                :class="{
                                    'text-yellow-400':
                                        Ticket.ticketStatus === 0,
                                    'text-green-400 ':
                                        Ticket.ticketStatus === 1,
                                    'text-red-400': Ticket.ticketStatus === 2,
                                    'text-green-700': Ticket.ticketStatus === 3,
                                }"
                            >
                                {{ Ticket.statusName }}
                            </h1>
                        </td>
                        <td class="px-6 py-4 items-center flex justify-center">
                            <Modal
                                :modalContent="{
                                    title: 'Ticket Remarks',
                                    disablebtn: disable,
                                    // content: 'Please fill out the form below:',
                                }"
                                type="rate"
                                iconLabel="Review"
                                cancelLabel="Back"
                                @modalopen="viewTicket(Ticket)"
                            >
                                <div class="min-w-[500px] max-w-[500px]">
                                    <h1 class="text-sm font-medium">
                                        {{
                                            moment(
                                                selectedTicket.created_at,
                                                "YYYY-MM-DD HH:mm:ss"
                                            ).format("MMMM Do YYYY")
                                        }}
                                    </h1>
                                    <div
                                        class="my-2.5 min-h-[200px] rounded-md border border-gray-200 p-4"
                                    >
                                        {{ selectedTicket.ticketRemarks }}
                                    </div>
                                </div>
                            </Modal>
                        </td>
                    </tr>
                </tbody>
            </table>
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
import moment from "moment";
import Pagination from "../utils/Pagination.vue";

import ConfirmPopup from "primevue/confirmpopup";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import Modal from "../component/Modal.vue";

export default {
    components: {
        ConfirmPopup,
        Toast,
        Button,
        Dialog,
        Pagination,
        Modal,
    },
    data() {
        return {
            tickets: [],
            pagination: null,
            isLoading: false,
            visible: false,
            moment: moment,
        };
    },
    methods: {
        viewTicket(selectedTicket) {
            this.selectedTicket = selectedTicket;
            this.visible = true;
        },
        getTickets() {
            this.isLoading = true;

            axios.get("/getticketsofstudent").then(({ data }) => {
                console.log(data);

                this.tickets = data.data;
                this.pagination = data;
                this.isLoading = false;
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
                .get(`/getticketsofstudent?page=${page}`)
                .then(({ data }) => {
                    console.log(data);

                    this.tickets = data.data;
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
        this.getTickets();
    },
};
</script>
<style lang="css">
.p-confirm-popup {
    font-size: 14px;
}
.p-confirm-popup-footer {
    width: 100%;
    display: flex;
    justify-self: end;

    align-items: center;
}
</style>
