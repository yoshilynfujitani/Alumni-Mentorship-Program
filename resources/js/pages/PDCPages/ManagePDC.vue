<template>
    <div class="self-start pt-10">
        <h1 class="text-2xl font-bold pb-2.5">Manage PDC Accounts</h1>
        <div class="pb-5 flex gap-2.5">
            <input
                v-model="search"
                placeholder="Search PDC"
                class="border-gray-200 rounded-md"
            />
            <button
                @click="getAccounts"
                class="bg-green-600 rounded-md text-white font-semibold px-4 py-2 space-x-5"
            >
                Get Accounts <span class="pi pi-search"></span>
            </button>
            <div class="flex justify-content-center">
                <button
                    @click="visible = true"
                    class="bg-blue-600 rounded-md text-white font-semibold px-4 py-2 space-x-5"
                >
                    Create Account <span class="pi pi-plus"></span>
                </button>
                <Dialog v-model:visible="visible" modal header="Create Account">
                    <AccountForm
                        @cancel="visible = false"
                        @success="successAccount"
                    />
                </Dialog>
            </div>
        </div>
    </div>
    <Toast />
    <div v-if="isLoading">
        <UnSpinnerAlt class="animate-spin text-green-500" />
    </div>
    <div
        v-else
        class="self-start overflow-x-auto w-full shadow-sm sm:rounded-lg z-40"
    >
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="pl-6 py-2">Account Name</th>
                    <th scope="col" class="pl-6">Email</th>
                    <th scope="col" class="pl-6">College</th>
                    <th scope="col" class="">Account Status</th>
                </tr>
            </thead>
            <ConfirmPopup />
            <tbody>
                <tr
                    v-for="pdc in pdcaccounts"
                    :key="pdc.id"
                    class="border-b border-gray-200"
                >
                    <th
                        scope="row"
                        class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap"
                    >
                        {{ pdc.name }}
                    </th>
                    <td class="px-6 py-4">{{ pdc.email }}</td>
                    <td class="px-6 py-4">{{ pdc.CollegeName }}</td>
                    <td class="" align="center">
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-5 h-5 rounded-full"
                                :class="
                                    pdc.isOnline ? 'bg-green-400' : 'bg-red-400'
                                "
                            ></div>
                            <h1>{{ pdc.isOnline ? "Online" : "Offline" }}</h1>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="my-5">
            <Pagination
                @next="goToNextPage"
                @back="goToPrevPage"
                :total="pagination.total"
                :current_page="pagination.current_page"
                :last_page="pagination.last_page"
            />
        </div>
    </div>
</template>

<script>
import { UnSpinnerAlt } from "@kalimahapps/vue-icons";
import ConfirmPopup from "primevue/confirmpopup";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import Pagination from "../../utils/Pagination.vue";
import AccountForm from "./AccountForm.vue";

export default {
    components: {
        UnSpinnerAlt,
        ConfirmPopup,
        Toast,
        Dialog,
        Pagination,
        AccountForm,
    },
    data() {
        return {
            search: "",
            pdcaccounts: [],
            isLoading: false,
            visible: false,
            pagination: {},
        };
    },
    methods: {
        getAccounts() {
            this.isLoading = true;
            axios
                .post("/getpdc", { search: this.search })
                .then(({ data }) => {
                    this.pdcaccounts = data.data;
                    this.pagination = data;
                    this.isLoading = false;
                })
                .catch(() => {
                    this.isLoading = false;
                });
        },
        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                this.fetchRequests(this.pagination.current_page - 1);
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.fetchRequests(this.pagination.current_page + 1);
            }
        },
        fetchRequests(page) {
            axios.get(`/gettickets?page=${page}`).then(({ data }) => {
                this.pagination = data;
                this.pdcaccounts = data.data;
            });
        },
        successAccount() {
            this.visible = false;
            this.$toast.add({
                severity: "success",
                summary: "New Account Created!",
                detail: "PDC account creation was successful!",
                life: 3000,
            });
            this.getAccounts();
        },
    },
    mounted() {
        this.getAccounts();
    },
};
</script>

<style scoped>
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
