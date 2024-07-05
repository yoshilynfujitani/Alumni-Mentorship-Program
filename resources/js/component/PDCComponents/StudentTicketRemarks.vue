<template>
    <button label="View" @click="visible = true" class="text-md">
        <i class="pi pi-envelope text-xl"></i>
    </button>
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
                    {{ this.name }}
                </div>
                <div class="flex flex-col">
                    <p class="text-sm font-medium text-green-600">
                        Ticket Requested
                    </p>
                    <h1 class="">
                        {{
                            moment(this.date, "YYYY-MM-DD HH:mm:ss").format(
                                "MMMM Do YYYY"
                            )
                        }}
                    </h1>
                </div>
            </div>
            <div
                class="my-2.5 min-h-[500px] rounded-md border border-gray-200 p-4"
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
    props: ["remarks", "date", "name"],
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
