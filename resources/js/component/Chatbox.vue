<template>
    <div
        class="bg-gray-50 pb-32 rounded-md w-full flex-grow border border-gray-200 shadow-sm"
    >
        <div
            class="w-full h-full flex items-center justify-center"
            v-if="this.chat === null"
        >
            <h1>No conversation selected</h1>
        </div>
        <div class="w-full h-full">
            <div
                class="py-2.5 px-5 w-full bg-white shadow-sm"
                v-if="this.convoId"
            >
                <div class="flex items-center gap-1.5">
                    <img
                        class="w-10 h-10 rounded-full shadow-lg"
                        src="../../../public/DefaultAvatar.webp"
                        alt=""
                    />{{ this.userName }}
                </div>
                <div class="flex items-center gap-1" v-if="userIsOnline">
                    <div class="w-3 h-3 rounded-full bg-green-600"></div>
                    <h1 class="text-sm">Online</h1>
                </div>
                <div class="flex items-center gap-1" v-else>
                    <div class="w-3 h-3 rounded-full bg-red-600"></div>
                    <h1 class="text-sm">Offline</h1>
                </div>
            </div>
            <div class="flex items-center justify-center h-full" v-else>
                Please Select chat to get started
            </div>
            <div class="min-h-full" v-if="this.chatLoading">Loading...</div>

            <div
                class="overflow-y-scroll px-5 min-h-full h-full w-full scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-200 scrollbar-track-gray-100"
            >
                <div
                    class="flex flex-col min-h-full max-h-full"
                    id="chats"
                    ref="chats"
                >
                    <div
                        v-for="chats in chat"
                        :key="chats.id"
                        class="w-auto text-gray-900 my-1 max-w-xs"
                        :ref="'chatIndex' + chats.id"
                        :class="{
                            'self-start text-left':
                                chats.userId !== this.userId,
                            'self-end text-right': chats.userId === this.userId,
                            'bg-gray-200 w-fit px-4 py-2 rounded-full':
                                chats.userId !== this.userId,
                            'bg-green-200 w-fit px-4 py-2 rounded-full':
                                chats.userId === this.userId,
                        }"
                    >
                        <p>{{ chats.chats }}</p>
                    </div>
                </div>
            </div>

            <form class="my-2" @submit.prevent="sendChat" v-if="this.convoId">
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
                    <div class="flex items-center gap-5">
                        <input
                            v-model="message"
                            type="search"
                            id="search"
                            class="block w-full px-4 py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                            placeholder="Send message..."
                            required
                        />
                        <button
                            type="submit"
                            class="bg-green-500 px-4 py-2 rounded-md text-gray-50"
                        >
                            Send
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import _debounce from "lodash/debounce";
import moment from "moment";
import { mapState } from "vuex";

export default {
    props: ["convoId", "userIsOnline", "userName"],
    data() {
        return {
            chat: [],
            message: "",
            moment,
            chatLoading: false,
            listenerStatus: {},
            subscription: null,
        };
    },
    computed: {
        ...mapState(["userId"]),
    },
    methods: {
        sendChat: _debounce(function () {
            const { message, convoId } = this;
            if (!message.trim()) return; // Prevent sending empty messages

            const created_at = new Date()
                .toISOString()
                .slice(0, 19)
                .replace("T", " ");

            axios
                .post("/sendconvo", {
                    appointmentId: convoId,
                    message,
                    created_at,
                })
                .then(({ data }) => {
                    console.log("Message sent successfully:", data);
                    this.message = "";
                })
                .catch((error) => {
                    console.error("Error sending message:", error);
                    // Notify user about message send failure
                });
        }, 200),

        getChat(id) {
            this.chatLoading = true;

            axios
                .post("/getconvo", { appointmentId: parseInt(id) })
                .then(({ data }) => {
                    console.log(data);
                    this.chat = data;
                    this.scrollToEnd();
                    console.log(this.listenerStatus);
                    if (!this.listenerStatus[id]) {
                        this.listen(id);
                        this.listenerStatus[id] = true; // Set to true when subscribing
                    }
                    console.log(this.listenerStatus);
                    this.chatLoading = false;
                })
                .catch((error) => {
                    console.error("Error fetching chat:", error);
                    // Notify user about chat fetch failure
                    this.chatLoading = false;
                });
        },
        scrollToEnd() {
            this.$nextTick(() => {
                const chatContainer = this.$refs.chats;
                if (chatContainer && this.chat.length > 0) {
                    const lastMessageId = this.chat[this.chat.length - 1].id;
                    const lastMessage = this.$refs[`chatIndex${lastMessageId}`];
                    if (lastMessage && lastMessage.length > 0) {
                        lastMessage[0].scrollIntoView({
                            behavior: "smooth",
                            block: "end",
                            inline: "nearest",
                        });
                    }
                }
            });
        },

        listen(appointmentId) {
            if (
                !this.subscription ||
                this.subscription.channel !== `chat${appointmentId}`
            ) {
                // Unsubscribe from the previous channel if it exists
                if (this.subscription) {
                    window.Echo.leave(this.subscription.channel);
                }

                const data = (e) => {
                    console.log(e);

                    this.chat.push({
                        id: e.id, // Assuming e.id is the unique identifier for each chat
                        chats: e.message,
                        userId: e.userId,
                        appointmentId: e.appointmentId,
                        created_at: e.created_at,
                    });
                    this.scrollToEnd(); // Scroll to the end when a new message is received
                };

                this.subscription = {
                    channel: `chat${appointmentId}`,
                    subscription: window.Echo.private(
                        `chat${appointmentId}`
                    ).listen(".newchat", data),
                };
            }
        },

        unsubscribe(appointmentId) {
            if (this.subscription) {
                window.Echo.leave(this.subscription.channel);
                delete this.listenerStatus[appointmentId];
                console.log(`Unsubscribed from chat${appointmentId}`);
                this.subscription = null;
            }
        },
    },
    watch: {
        convoId(newVal, oldVal) {
            if (oldVal) {
                this.unsubscribe(oldVal);
            }
            if (newVal) {
                this.getChat(newVal);
            }
        },
    },
    mounted() {
        // Do any initial setup here
    },
    destroyed() {},
};
</script>

<style></style>
