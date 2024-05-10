<template>
    <button label="View" @click="visible = true" class="text-md">
        <i class="pi pi-envelope text-xl"></i>
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
                    moment(this.date, "YYYY-MM-DD HH:mm:ss").format(
                        "MMMM Do YYYY"
                    )
                }}
            </h1>
            <div
                class="my-2.5 min-h-[200px] rounded-md border border-gray-200 p-4"
            >
                {{ this.remarks }}
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

export default {
    props: ["remarks", "date"],
    components: {
        Dialog,
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

<style></style>
