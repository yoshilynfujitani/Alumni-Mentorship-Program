<template>
    <div class="self-start my-10 overflow-x-auto w-full min-h-full">
        <h1 class="pb-2.5 text-2xl font-bold">Mentor Requests</h1>
        <div class="space-x-2.5">
            <input
                v-model="ticketQuery"
                type="text"
                class="border-gray-300 rounded-md"
                placeholder="Search name..."
                @keyup="searchticket"
            />
        </div>
        <Toast />
        <ConfirmPopup></ConfirmPopup>
        <div
            class="h-96 flex items-center justify-center font-bold"
            v-if="mentors?.length === 0"
        >
            No Pending Requests
        </div>
        <div
            v-else
            class="self-start overflow-x-auto w-full shadow-md sm:rounded-lg"
        >
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Instructor's Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">College</th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Others
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="Mentor in mentors"
                        :key="Mentor.id"
                        class="border-gray-200 dark:border-gray-700 border-b"
                    >
                        <th
                            scope="row"
                            class="flex items-center gap-2 px-6 py-7 h-full font-medium text-gray-900"
                        >
                            <img
                                class="w-7 h-7 rounded-full"
                                src="../../../../public/DefaultAvatar.webp"
                                alt="Avatar"
                            />{{ Mentor.name }}
                        </th>
                        <td class="px-6 py-4">{{ Mentor.email }}</td>
                        <td class="px-6 py-4">
                            {{ Mentor.course }}
                        </td>
                        <td class="flex gap-2 justify-center">
                            <div class="" v-if="Mentor.verified">
                                <i class="pi pi-check"></i>
                            </div>
                            <div class="" v-else>
                                <div class="flex gap-2 justify-content-center">
                                    <button
                                        @click="
                                            AcceptTicket($event, 1, Mentor.id)
                                        "
                                        class="px-2 py-1 bg-green-400 text-white rounded font-medium"
                                    >
                                        Approve
                                    </button>
                                    <button
                                        @click="
                                            RejectTicket($event, 2, Mentor.id)
                                        "
                                        class="px-2 py-1 bg-red-400 text-white rounded font-medium"
                                    >
                                        Reject
                                    </button>
                                </div>
                            </div>
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
    </div>
</template>
<script>
import ConfirmPopup from "primevue/confirmpopup";
import Toast from "primevue/toast";
import Pagination from "../../utils/Pagination.vue";

export default {
    data() {
        return {
            mentors: null,
            pagination: null,
            ticketQuery: "",
        };
    },
    components: {
        ConfirmPopup,
        Toast,
        Pagination,
    },
    methods: {
        getApplications() {
            axios
                .get("/getmentorapplications")
                .then(({ data }) => {
                    this.mentors = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        total: data.total,
                    };
                })
                .catch((error) => {
                    console.log(error);
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
            axios
                .get(`/getmentorapplications?page=${page}`)
                .then(({ data }) => {
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        total: data.total,
                    };
                    this.mentors = data.data;
                });
        },
        searchticket() {
            const { ticketQuery } = this;
            this.pagination = "";

            axios
                .post("/searchrequest", { ticketQuery: ticketQuery })
                .then(({ data }) => {
                    this.mentors = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        total: data.total,
                    };
                });
        },
        verify(statusId, mentorId) {
            axios
                .post("/editmentorstatus", { statusId, mentorId })
                .then(({ data }) => {})
                .catch((error) => {
                    console.error("Error verifying mentor status:", error);
                });
        },
        AcceptTicket(event, requestStatus, mentorId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to proceed?",
                icon: "pi pi-exclamation-triangle text-red-400",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-sm text-white bg-green-400 px-2 py-1 ml-2",
                rejectLabel: "Cancel",
                acceptLabel: "Approve",
                accept: function () {
                    this.verify(requestStatus, mentorId);

                    this.$toast.add({
                        severity: "success",
                        summary: "Confirmed",
                        detail: "Ticket approved successfully",
                        position: "bottom-right",
                        life: 10000,
                    });
                    this.getApplications(); // Ensure `this` refers to the Vue instance
                }.bind(this), // Explicitly bind `this` to the function
                reject: function () {}.bind(this), // Explicitly bind `this` to the function
            });
        },
        RejectTicket(event, requestStatus, mentorId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to proceed?",
                icon: "pi pi-exclamation-triangle text-red-400",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-danger p-button-sm bg-red-400 px-2 py-1 ml-2 text-white",
                rejectLabel: "Cancel",
                acceptLabel: "Reject",
                accept: function () {
                    this.verify(requestStatus, mentorId);

                    this.$toast.add({
                        severity: "success",
                        summary: "Rejected",
                        detail: "Ticket Rejected",
                        position: "bottom-right",
                        life: 10000,
                    });
                    this.getApplications(); // Ensure `this` refers to the Vue instance
                }.bind(this), // Explicitly bind `this` to the function
                reject: function () {}.bind(this), // Explicitly bind `this` to the function
            });
        },
    },

    mounted() {
        this.getApplications();
    },
};
</script>
