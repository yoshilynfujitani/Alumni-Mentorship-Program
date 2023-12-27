<template lang="">
    <LayoutPDC>
        <div class="self-start">
            <h1>Tickets</h1>
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
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            Field
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Status
                        </th>
                        <th scope="col" class="px-16 py-3 text-center">Edit</th>
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
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                        >
                            {{ Ticket.name }}
                        </th>
                        <td class="px-6 py-4">{{ Ticket.course }}</td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                            {{ Ticket.fieldName }}
                        </td>
                        <td class="px-6 py-4 flex justify-center">
                            <h1
                                v-if="Ticket.ticketStatus === 0"
                                class="text-white font-bold bg-yellow-400 py-2 px-4 rounded-md w-fit"
                            >
                                {{ Ticket.statusName }}
                            </h1>
                            <h1
                                v-if="Ticket.ticketStatus === 1"
                                class="text-white font-bold bg-green-400 py-2 px-4 rounded-md w-fit"
                            >
                                {{ Ticket.statusName }}
                            </h1>
                            <h1
                                v-if="Ticket.ticketStatus === 2"
                                class="text-white font-bold bg-red-400 py-2 px-4 rounded-md w-fit text-center"
                            >
                                {{ Ticket.statusName }}
                            </h1>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                @click="updateStatus(Ticket)"
                                v-if="!Ticket.isEdit"
                            >
                                <svg
                                    class="w-3 h-3 text-gray-800 dark:text-white"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 16 3"
                                >
                                    <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
                                    />
                                </svg>
                            </button>
                            <div class="space-x-5" v-if="Ticket.isEdit">
                                <button @click="updateStatus(Ticket)">
                                    <svg
                                        class="w-3 h-3 text-gray-800 dark:text-white hover:text-gray-400"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 8 14"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"
                                        />
                                    </svg>
                                </button>
                                <button
                                    @click="
                                        verify(
                                            2,
                                            Ticket.studentId,

                                            Ticket.field,
                                            Ticket.id
                                        )
                                    "
                                >
                                    <svg
                                        class="w-3 h-3 text-gray-800 dark:text-white hover:text-red-500"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 14 14"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                        />
                                    </svg>
                                </button>
                                <button
                                    @click="
                                        verify(
                                            1,
                                            Ticket.studentId,
                                            Ticket.field,

                                            Ticket.id
                                        )
                                    "
                                >
                                    <svg
                                        class="w-3 h-3 text-gray-800 dark:text-white hover:text-green-600"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 16 12"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5.917 5.724 10.5 15 1.5"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </LayoutPDC>
</template>
<script>
import MentorCard from "../../component/MentorComponents/MentorCard.vue";
import { UnSpinnerAlt } from "@kalimahapps/vue-icons";
export default {
    components: {
        MentorCard,
        UnSpinnerAlt,
    },
    data() {
        return {
            tickets: [],

            isLoading: false,
            isEdit: false,
        };
    },
    methods: {
        getTickets() {
            this.isLoading = true;

            axios.get("/gettickets").then(({ data }) => {
                console.log(data);

                this.tickets = data;
                this.isLoading = false;
            });
        },
        updateStatus(Ticket) {
            Ticket.isEdit = !Ticket.isEdit;
        },
        verify(requestStatus, studentId, field, ticketId) {
            axios
                .post("/verifyticket", {
                    requestStatus,
                    studentId,
                    field,
                    ticketId,
                })
                .then(({ data }) => {
                    console.log(data);
                    this.getTickets();
                });
        },
    },
    mounted() {
        this.getTickets();
    },
};
</script>
<style lang=""></style>
