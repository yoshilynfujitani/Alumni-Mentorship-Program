<template lang="">
    <div class="self-start pt-10">
        <h1 class="text-2xl font-bold pb-2.5">Student Tickets</h1>
        <div class="space-x-2.5 pb-5">
            <input
                v-model="ticketQuery"
                type="text"
                class="border-gray-300 rounded-md"
                placeholder="Search name..."
                @keyup="searchticket"
            />
        </div>
    </div>
    <Toast />

    <div v-if="isLoading">Loading...</div>

    <div
        class="self-start overflow-x-auto w-full shadow-sm sm:rounded-lg z-40"
        v-else
    >
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white"
        >
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="pl-6 py-2">Student's Name</th>
                    <th scope="col" class="text-center">Student's Detail</th>
                    <th scope="col" class="pl-6">Field</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Remarks</th>
                    <th scope="col" class="text-center">Verify</th>
                </tr>
            </thead>
            <ConfirmPopup></ConfirmPopup>
            <tbody>
                <tr
                    v-for="Ticket in tickets"
                    :key="Ticket.id"
                    class="border-b border-gray-200"
                >
                    <th
                        scope="row"
                        class="px-6 py-6 font-medium text-gray-900 w-fit"
                    >
                        <div class="flex items-center gap-5">
                            <img
                                class="w-12 h-12 rounded-full"
                                src="../../../../public/DefaultAvatar.webp"
                                alt="Avatar"
                            />
                            {{ Ticket.name }}
                        </div>
                    </th>
                    <td class="px-6 py-4" align="center">
                        <i class="pi pi-eye"></i>
                    </td>
                    <td class="px-6 py-4">
                        {{ Ticket.fieldName }}
                    </td>
                    <td class="px-6 py-4">
                        <h1
                            class="font-bold text-center"
                            :class="{
                                'text-yellow-400': Ticket.ticketStatus === 0,
                                'text-green-400 ': Ticket.ticketStatus === 1,
                                'text-red-400': Ticket.ticketStatus === 2,
                                'text-green-700': Ticket.ticketStatus === 3,
                            }"
                        >
                            {{ Ticket.statusName }}
                        </h1>
                    </td>
                    <td class="px-6 py-4" align="center">
                        <StudentTicketRemarks
                            :name="Ticket.name"
                            :remarks="Ticket.ticketRemarks"
                            :date="Ticket.created_at"
                        />
                    </td>
                    <td
                        class="px-6 py-4 items-center justify-center"
                        align="center"
                    >
                        <div class="" v-if="Ticket.ticketStatus !== 0">
                            <i class="pi pi-check font-bold"></i>
                        </div>
                        <div class="flex items-center justify-center" v-else>
                            <div class="flex gap-2 justify-content-center">
                                <button
                                    @click="
                                        AcceptTicket(
                                            $event,
                                            1,
                                            Ticket.studentId,
                                            Ticket.field,
                                            Ticket.id
                                        )
                                    "
                                    class="px-2 py-1 bg-green-400 text-white rounded font-medium"
                                >
                                    Approve
                                </button>
                                <button
                                    @click="this.visible = true"
                                    class="px-2 py-1 bg-red-400 text-white rounded font-medium"
                                >
                                    Reject
                                </button>
                                <Dialog
                                    v-model:visible="visible"
                                    modal
                                    header="Reject Ticket"
                                    :style="{ width: '40rem' }"
                                >
                                    <div class="flex justify-between">
                                        <div class="flex items-center gap-5">
                                            <img
                                                class="w-12 h-12 rounded-full"
                                                src="../../../../public/DefaultAvatar.webp"
                                                alt="Avatar"
                                            />
                                            {{ Ticket.name }}
                                        </div>
                                        <div class="flex flex-col">
                                            <p
                                                class="text-sm font-medium text-green-600"
                                            >
                                                Ticket Requested
                                            </p>
                                            <h1 class="">
                                                {{
                                                    moment(
                                                        Ticket.created_at,
                                                        "YYYY-MM-DD HH:mm:ss"
                                                    ).format("MMMM Do YYYY")
                                                }}
                                            </h1>
                                        </div>
                                    </div>

                                    <Textarea
                                        v-model="rejectionRemarks"
                                        autoResize
                                        rows="5"
                                        cols="30"
                                        class="w-full max-h-[500px] my-2.5 overflow-y-scroll border-gray-300 active:border-gray-400"
                                    />

                                    <div class="w-full flex items-start">
                                        <button
                                            class="bg-red-400 text-white rounded-md px-4 py-2 font-semibold"
                                            @click="
                                                RejectTicket(
                                                    $event,
                                                    2,
                                                    Ticket.studentId,
                                                    Ticket.field,
                                                    Ticket.id
                                                )
                                            "
                                        >
                                            Confirm Rejection
                                        </button>
                                    </div>
                                </Dialog>
                            </div>
                        </div>
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
</template>
<script>
import moment from "moment";
import MentorCard from "../../component/MentorComponents/MentorCard.vue";

import Textarea from "primevue/textarea";

import ConfirmPopup from "primevue/confirmpopup";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import StudentTicketRemarks from "../../component/PDCComponents/StudentTicketRemarks.vue";
import Pagination from "../../utils/Pagination.vue";
export default {
    components: {
        MentorCard,

        ConfirmPopup,
        Toast,
        Button,
        Dialog,
        StudentTicketRemarks,
        Pagination,
        Textarea,
    },
    data() {
        return {
            tickets: [],
            ticketQuery: "",
            isLoading: false,
            pagination: null,
            moment: moment,
            visible: false,
            rejectionRemarks: "",
        };
    },
    methods: {
        getTickets() {
            this.isLoading = true;

            axios.get("/gettickets").then(({ data }) => {
                console.log(data);

                this.tickets = data.data;
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total,
                };
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
            axios.get(`/gettickets?page=${page}`).then(({ data }) => {
                console.log(data);
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total,
                };
                this.tickets = data.data;
            });
        },
        searchticket() {
            const { ticketQuery } = this;
            this.pagination = "";
            this.isLoading = true;
            axios
                .post("/searchticket", { ticketQuery: ticketQuery })
                .then(({ data }) => {
                    this.tickets = data;
                    this.isLoading = false;
                });
        },
        verify(requestStatus, studentId, field, ticketId) {
            axios
                .post("/verifyticket", {
                    requestStatus,
                    studentId,
                    field,
                    ticketId,
                    remarks: this.rejectionRemarks,
                })
                .then(({ data }) => {
                    this.getTickets();
                });
        },

        AcceptTicket(event, requestStatus, studentId, field, ticketId) {
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
                    this.verify(requestStatus, studentId, field, ticketId);
                    this.$toast.add({
                        severity: "success",
                        summary: "Confirmed",
                        detail: "Ticket approved successfully",
                        position: "bottom-right",
                        life: 10000,
                    });
                },
                reject: () => {},
            });
        },
        RejectTicket(event, requestStatus, studentId, field, ticketId) {
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
                    this.verify(requestStatus, studentId, field, ticketId);
                    this.visible = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Rejected",
                        detail: "Ticket Rejected",
                        position: "bottom-right",
                        life: 10000,
                    });
                },
                reject: () => {},
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
