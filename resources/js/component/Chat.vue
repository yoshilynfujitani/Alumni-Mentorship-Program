<template lang="">
    <Modal
        :modalContent="{
            title: 'Chat',
            // content: 'Please fill out the form below:',
        }"
        cancelLabel="Back"
        buttonIcon="AkChatDots"
        iconLabel="Chat"
        saveLabel="Send"
        :saveOption="false"
        @save="sendChat"
        ><div class="w-auto flex flex-col">
            <div class="min-h-[200px] max-h-[300px]" v-if="this.chatLoading">
                Loading...
            </div>

            <div
                class="min-h-[200px] max-h-[300px] px-2 overflow-y-scroll scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-200 scrollbar-track-gray-100"
                v-else
            >
                <div class="h-full flex flex-col" v-for="chats in chat">
                    <h1
                        class="w-auto text-gray-900 my-1 max-w-xs"
                        :class="{
                            'self-start text-left':
                                chats.userId !== this.userId,
                            'self-end text-right': chats.userId === this.userId,
                            'bg-gray-200 w-fit px-4 py-2 rounded-full ':
                                chats.userId !== this.userId,
                            'bg-green-200 w-fit px-4 py-2 rounded-full ':
                                chats.userId === this.userId,
                        }"
                    >
                        {{ chats.chats }}
                    </h1>
                </div>
            </div>

            <form class="my-2">
                <label
                    for="search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                    >Search</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                    >
                        <svg
                            class="w-4 h-4 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>
                    <input
                        v-model="message"
                        type="search"
                        id="search"
                        class="block w-full px-4 py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                        placeholder="Send message..."
                        required
                    />
                </div>
            </form></div
    ></Modal>
</template>
<script>
import Modal from "./Modal.vue";

import { mapState, mapActions } from "vuex";
export default {
    computed: {
        ...mapState(["userId"]),
    },
    props: ["appointmentId"],
    components: { Modal },
    data() {
        return {
            chatLoading: false,
            chat: [],
            message: "",
        };
    },
    methods: {
        getChat() {
            this.chatLoading = true;

            axios
                .post("/getconvo", { appointmentId: this.appointmentId })
                .then(({ data }) => {
                    this.chat = data;
                    this.chatLoading = false;
                });
        },
        sendChat() {
            const { message } = this;
            axios
                .post("/sendconvo", {
                    appointmentId: this.appointmentId,
                    message,
                })
                .then(({ data }) => {
                    this.getChat();
                });
        },
    },

    mounted() {
        this.getChat();
    },
};
</script>
<style lang=""></style>
