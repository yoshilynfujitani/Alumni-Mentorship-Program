<template>
    <ConfirmPopup></ConfirmPopup>
    <i
        class="pi pi-wrench self-end bg-yellow-400 text-white p-2 rounded-md hover:cursor-pointer"
        @click="EditField($event, this.fieldName, this.fieldId)"
    ></i>
    <ConfirmPopup></ConfirmPopup>
    <i
        class="pi pi-trash self-end bg-red-400 text-white p-2 rounded-md hover:cursor-pointer"
        @click="DeleteField($event, this.fieldId)"
    ></i>
</template>
<script>
import ConfirmPopup from "primevue/confirmpopup";

export default {
    props: ["fieldName", "fieldId"],
    data() {
        return {};
    },
    components: {
        ConfirmPopup,
    },
    methods: {
        EditField(event, fieldName, fieldId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to edit field?",
                icon: "pi pi-exclamation-triangle",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-warning p-button-sm bg-yellow-400 px-2 py-1 ml-2 text-white",
                rejectLabel: "Cancel",
                acceptLabel: "Edit",
                accept: () => {
                    this.fieldName = fieldName;
                    this.fieldIdToEdit = fieldId;
                    this.isEdit = true;
                },
            });
        },
        DeleteField(event, fieldId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Do you want to delete this record?",
                icon: "pi pi-info-circle",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-danger p-button-sm bg-red-400 px-2 py-1 ml-2 text-white",
                rejectLabel: "Cancel",
                acceptLabel: "Delete",
                accept: () => {
                    axios
                        .post("/deletefield", { fieldId: fieldId })
                        .then(({ data }) => {
                            this.$toast.add({
                                severity: "success",
                                summary: "Confirmed",
                                detail: "Record deleted",
                                life: 3000,
                            });
                            this.getFields();
                        });
                },
            });
        },
    },
};
</script>
