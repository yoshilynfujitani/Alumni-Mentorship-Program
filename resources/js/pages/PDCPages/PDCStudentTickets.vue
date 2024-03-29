<template lang="">
    <LayoutPDC>
        <div class="self-start">
            <h1>Tickets</h1>
        </div>
        <Toast />

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
                            class="pl-6 py-2 bg-gray-50 dark:bg-gray-800"
                        >
                            Student's Name
                        </th>
                        <th scope="col" class="text-center">
                            Student's Detail
                        </th>
                        <th
                            scope="col"
                            class="pl-6 bg-gray-50 dark:bg-gray-800"
                        >
                            Field
                        </th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Remarks</th>
                        <th scope="col" class="text-center">Verify</th>
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
                        <td class="px-6 py-4 flex items-center justify-center">
                            <Button
                                @click="
                                    RejectTicket(
                                        $event,
                                        2,
                                        Ticket.studentId,
                                        Ticket.field,
                                        Ticket.id
                                    )
                                "
                                label="Delete"
                                severity="danger"
                                outlined
                            ></Button>
                        </td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
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
                            <button
                                label="View"
                                @click="viewTicket(Ticket)"
                                class="text-sm"
                            >
                                <i class="pi pi-envelope"></i>
                            </button>
                            <Dialog
                                v-model:visible="visible"
                                modal
                                header="Ticket Remarks"
                                :style="{ width: '25rem' }"
                            >
                                <div class="">
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
                                <div class="flex justify-content-end gap-2">
                                    <Button
                                        type="button"
                                        label="Cancel"
                                        severity="secondary"
                                        @click="visible = false"
                                    ></Button>
                                </div>
                            </Dialog>
                        </td>
                        <td class="px-6 py-4 items-center justify-center">
                            <div class="" v-if="Ticket.ticketStatus !== 0">
                                <h1
                                    class="font-bold text-center"
                                    :class="{
                                        'text-yellow-400':
                                            Ticket.ticketStatus === 0,
                                        'text-green-400 ':
                                            Ticket.ticketStatus === 1,
                                        'text-red-400':
                                            Ticket.ticketStatus === 2,
                                        'text-green-700':
                                            Ticket.ticketStatus === 3,
                                    }"
                                >
                                    {{ Ticket.statusName }}
                                </h1>
                            </div>
                            <div
                                class="flex items-center justify-center"
                                v-else
                            >
                                <ConfirmPopup></ConfirmPopup>
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
                                        @click="
                                            RejectTicket(
                                                $event,
                                                2,
                                                Ticket.studentId,
                                                Ticket.field,
                                                Ticket.id
                                            )
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
        </div>
    </LayoutPDC>
</template>
<script>
import moment from "moment";
import MentorCard from "../../component/MentorComponents/MentorCard.vue";
import { UnSpinnerAlt } from "@kalimahapps/vue-icons";
import ConfirmPopup from "primevue/confirmpopup";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";

export default {
    components: {
        MentorCard,
        UnSpinnerAlt,
        ConfirmPopup,
        Toast,
        Button,
        Dialog,
    },
    data() {
        return {
            tickets: [],

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

            axios.get("/gettickets").then(({ data }) => {
                console.log(data);

                this.tickets = data.data;
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
                })
                .then(({ data }) => {
                    console.log(data);
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
