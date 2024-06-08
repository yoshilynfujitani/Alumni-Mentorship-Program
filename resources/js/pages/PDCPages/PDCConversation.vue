<template>
    <div class="py-10 flex w-full gap-5 h-screen pb-20">
        <!-- Message Headers -->
        <div
            class="p-5 bg-white rounded-md min-w-[400px] max-w-[400px] min-h-full max-h-full border border-gray-200 shadow-sm overflow-y-scroll scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-50 scrollbar-track-gray-50"
        >
            <div>
                <h1 class="font-bold text-2xl py-2">Messages</h1>
                <div class="w-full flex justify-between">
                    <div class="relative">
                        <input
                            v-model="titleQuery"
                            class="border border-gray-200 rounded-md active:border-green-200 focus:border-green-200"
                            placeholder="Appointment title..."
                        />
                        <button
                            @click="clearQuery"
                            v-if="titleQuery"
                            class="rounded-full px-1.5 text-xs flex items-center justify-center text-gray-300 absolute right-1 top-3"
                        >
                            <i class="pi pi-times-circle"></i>
                        </button>
                    </div>
                    <button
                        @click="searchConvo"
                        class="transition-all bg-green-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-green-500"
                    >
                        Search
                    </button>
                </div>
            </div>
            <div>
                <h1 class="font-semibold py-2 text-green-700">
                    Recent Conversation
                </h1>
                <div
                    class="rounded-md bg-gray-50 px-4 py-2 my-1 cursor-pointer"
                    :class="{
                        'border-2 border-green-500':
                            ConvoId === Inbox.appointmentId,
                    }"
                    v-for="Inbox in inbox"
                    :key="Inbox.appointmentId"
                    @click="
                        openChat(Inbox.appointmentId, Inbox.name, Inbox.userId)
                    "
                >
                    <h1 class="text-xs text-green-400">
                        #0000<span> {{ Inbox.appointmentId }}</span>
                    </h1>
                    <h2
                        class="font-medium text-lg flex items-center justify-between my-2"
                    >
                        {{ Inbox.name }}
                        <span
                            class="text-sm rounded-full font-medium px-2 py-1"
                            :class="statusClass(Inbox.statusId)"
                        >
                            {{ Inbox.statusName }}
                        </span>
                    </h2>
                    <p class="text-gray-500 text-md">
                        <span class="font-thin text-sm"
                            >Appointment Title:</span
                        >
                        {{ Inbox.title }}
                    </p>
                </div>
            </div>
        </div>
        <!-- Messages -->
        <Chatbox
            :convoId="ConvoId"
            :userIsOnline="userIsOnline"
            :userName="ConvoWithName"
        />
    </div>
</template>

<script>
import axios from "axios";
import { mapState } from "vuex";
import LayoutEmployee from "../../Layout/LayoutEmployee.vue";
import Chatbox from "../../component/Chatbox.vue";

export default {
    components: {
        LayoutEmployee,
        Chatbox,
    },
    data() {
        return {
            ConvoId: null,
            ConvoWithName: null,
            inbox: [],
            titleQuery: "",
            userIsOnline: false,
        };
    },

    methods: {
        getConvoId() {
            axios.post("/getConvoId").then(({ data }) => {
                this.inbox = data;
            });
        },
        searchConvo() {
            axios
                .post("/searchConvo", { titleQuery: this.titleQuery })
                .then(({ data }) => {
                    this.inbox = data;
                });
        },
        clearQuery() {
            this.titleQuery = "";
            this.getConvoId();
        },
        openChat(appointmentId, name, userId) {
            this.ConvoId = appointmentId;
            this.ConvoWithName = name;
            this.checkIfUserIsOnline(userId);
        },
        checkIfUserIsOnline(userId) {
            axios
                .get(`/user/${userId}/online`)
                .then(({ data }) => {
                    console.log(data);
                    this.userIsOnline = data.online;
                })
                .catch((error) => {
                    console.error("Error checking user online status:", error);
                });
        },
        statusClass(statusId) {
            return {
                "bg-yellow-200 text-yellow-600": statusId === 0,
                "bg-green-200 text-green-600": statusId === 1,
                "bg-red-200 text-red-600": statusId === 2,
                "bg-green-400 text-white": statusId === 3,
            };
        },
    },
    created() {
        this.getConvoId();
    },
};
</script>

<style lang=""></style>
