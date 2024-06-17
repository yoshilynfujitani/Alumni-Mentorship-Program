<template>
    <div
        class="border border-gray-300 pb-5 rounded-md min-h-screen max-h-screen overflow-y-scroll"
    >
        <Toast />
        <ConfirmPopup></ConfirmPopup>
        <Dialog
            v-model:visible="isCreate"
            modal
            header="Create New Field"
            :style="{ width: '25rem' }"
        >
            <div class="space-y-2.5">
                <input
                    v-model="fieldName"
                    type="text"
                    class="rounded-md border-gray-300"
                    placeholder="Field Name"
                />
                <button
                    @click="createField"
                    class="bg-blue-500 px-4 py-2 text-white font-medium rounded-md"
                >
                    Create Field
                </button>
            </div>
        </Dialog>
        <Dialog
            v-model:visible="isEdit"
            modal
            header="Edit Field"
            :style="{ width: '25rem' }"
            @hide="fieldName = ''"
        >
            <div class="space-y-2.5 flex flex-col">
                <input
                    v-model="fieldName"
                    type="text"
                    class="rounded-md border-gray-300 w-fit"
                    placeholder="Field Name"
                />
                <button
                    @click="saveEditField"
                    class="bg-blue-500 px-4 py-2 text-white font-medum rounded-md w-fit"
                >
                    Edit Field
                </button>
            </div>
        </Dialog>

        <div class="p-2.5 pt-0">
            <div class="sticky top-0 shadow-sm mb-5">
                <h1 class="text-xl font-semibold bg-white p-2.5">
                    List of fields
                </h1>
            </div>
            <button
                class="text-blue-500 font-semibold px-2 py-1 border-2 border-blue-400 rounded-md"
                @click="this.isCreate = true"
            >
                Create Field
            </button>
            <div class="grid grid-cols-2 gap-x-2">
                <div
                    class="border border-gray-200 p-2.5 rounded-md flex justify-between gap-5 my-2.5"
                    v-for="field in fields"
                >
                    <h1
                        :key="field.id"
                        class="text-sm font-semibold py-2.5 w-full"
                    >
                        {{ field.name }}
                    </h1>
                    <span class="space-x-2.5 flex">
                        <i
                            class="pi pi-wrench self-end bg-yellow-400 text-white p-2 rounded-md hover:cursor-pointer"
                            @click="EditField($event, field.name, field.id)"
                        ></i>

                        <i
                            class="pi pi-trash self-end bg-red-400 text-white p-2 rounded-md hover:cursor-pointer"
                            @click="DeleteField($event, field.id)"
                        ></i
                    ></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ConfirmPopup from "primevue/confirmpopup";
import Toast from "primevue/toast";

import Dialog from "primevue/dialog";

export default {
    components: { ConfirmPopup, Toast, Dialog },
    data() {
        return {
            isCreate: false,
            isEdit: false,
            fieldName: "",
            fields: null,
            fieldIdToEdit: null,
        };
    },
    methods: {
        createField() {
            const { fieldName } = this;
            if (!this.fieldName) {
                return;
            }
            axios
                .post("/createfield", { fieldName: fieldName })
                .then(({ data }) => {
                    this.fieldName = "";
                    this.getFields();
                    this.isCreate = false;
                });
        },
        getFields() {
            axios.post("/getfields").then(({ data }) => {
                this.fields = data;
            });
        },
        saveEditField() {
            const { fieldName, fieldIdToEdit } = this;
            axios
                .post("/editfield", {
                    fieldName: fieldName,
                    fieldId: fieldIdToEdit,
                })
                .then(({ data }) => {
                    this.fieldName = "";
                    this.fieldIdToEdit = null;
                    this.getFields();
                    this.isEdit = false;
                });
        },
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

    mounted() {
        this.getFields();
    },
};
</script>
