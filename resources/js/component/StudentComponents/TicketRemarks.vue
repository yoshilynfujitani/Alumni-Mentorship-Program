<template>
    <Button
        type="button"
        label="Remarks"
        class="bg-blue-500 text-white px-4 py-2"
        :class="{ 'bg-red-500': Ticket.rejectionRemarks }"
        @click="visible = true"
    ></Button>
    <Dialog
        v-model:visible="visible"
        modal
        header="Ticket Remarks"
        :style="{ width: '40rem' }"
    >
        <div class="">
            <div class="flex justify-between">
                <div class="flex items-center gap-2.5">
                    <img
                        class="w-12 h-12 rounded-full"
                        src="../../../../public/DefaultAvatar.webp"
                        alt="Avatar"
                    />
                    {{ Ticket.name }}
                </div>
                <div class="flex flex-col">
                    <p class="text-sm font-medium text-green-600">
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
            <div class="my-2.5 min-h-[500px] p-4">
                <div class="card border border-gray-300 rounded-md">
                    <Accordion :activeIndex="0">
                        <AccordionTab header="Your Request">
                            <p>{{ Ticket.ticketRemarks }}</p>
                        </AccordionTab>
                        <AccordionTab
                            v-if="Ticket.rejectionRemarks"
                            header="Reason for Rejection"
                            class="rejection-header"
                        >
                            <p>{{ Ticket.rejectionRemarks }}</p>
                        </AccordionTab>
                    </Accordion>
                </div>
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
</template>

<script>
import moment from "moment";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
export default {
    props: ["Ticket"],
    components: {
        Dialog,
        Button,
        Accordion,
        AccordionTab,
    },

    data() {
        return {
            visible: false,
            moment,
        };
    },
    methods: {},
};
</script>

<style>
.rejection-header .p-accordion-header {
    color: red;
}
</style>
