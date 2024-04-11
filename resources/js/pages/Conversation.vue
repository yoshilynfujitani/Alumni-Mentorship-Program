<template lang="">
    <Layout>
        <div class="my-10 flex w-full md:gap-5 h-screen pb-20">
            <!-- Message Headers -->
            <div
                class="p-5 bg-white rounded-md md:min-w-[400px] max-w-[400px] min-h-full max-h-full border border-gray-200 shadow-sm overflow-y-scroll scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-50 scrollbar-track-gray-50"
            >
                <div class="">
                    <h1 class="font-bold text-2xl py-2">
                        <i
                            class="pi pi-envelope text-2xl text-yellow-400 pr-1"
                        ></i
                        >Messages
                    </h1>
                    <div class="w-full flex justify-between">
                        <div class="relative">
                            <input
                                v-model="titleQuery"
                                class="border border-gray-200 rounded-md active:border-green-200 focus:border-green-200"
                                placeholder="Appointment title..."
                            />
                            <button
                                @click="clearQuery"
                                v-if="this.titleQuery"
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
                <div class="">
                    <h1 class="font-semibold py-2 text-green-700">
                        Recent Conversation
                    </h1>
                    <div
                        class="rounded-md bg-gray-50 px-4 py-2 my-1 cursor-pointer"
                        :class="{
                            'border-2 border-green-500':
                                this.ConvoId === Inbox.appointmentId,
                        }"
                        v-for="Inbox in inbox"
                        @click="openChat(Inbox.appointmentId, Inbox.name)"
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
                                :class="{
                                    'bg-yellow-200 text-yellow-600 ':
                                        Inbox.statusId === 0,
                                    'bg-green-200 text-green-600 ':
                                        Inbox.statusId === 1,
                                    'bg-red-200 text-red-600 ':
                                        Inbox.statusId === 2,
                                    'bg-green-400 text-white ':
                                        Inbox.statusId === 3,
                                }"
                                >{{ Inbox.statusName }}</span
                            >
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
            <div
                class="hidden md:block bg-white pb-32 px-5 rounded-md w-full flex-grow border border-gray-200 shadow-sm"
            >
                <div
                    class="w-full h-full flex flex-col items-center justify-center"
                    v-if="!this.chat"
                >
                    <i
                        class="pi pi-question text-gray-500 font-bold text-2xl"
                    ></i>
                    <h1 class="text-gray-400">No conversation selected</h1>
                </div>
                <div class="w-full h-full" v-else>
                    <div class="py-5">{{ this.ConvoWithName }}</div>
                    <div class="min-h-full" v-if="this.chatLoading">
                        Loading...
                    </div>

                    <div
                        class="overflow-y-scroll min-h-full h-full scrollbar-thin scrollbar-thumb-rounded-full px-2 scrollbar-thumb-gray-200 scrollbar-track-gray-100"
                        v-else
                    >
                        <div
                            class="flex flex-col min-h-full max-h-full"
                            id="chats"
                            ref="chats"
                        >
                            <h1
                                v-for="chats in chat"
                                :key="chats.id"
                                class="w-auto text-gray-900 my-1 max-w-xs"
                                :ref="'chatIndex' + chats.id"
                                :class="{
                                    'self-start text-left':
                                        chats.userId !== this.userId,
                                    'self-end text-right':
                                        chats.userId === this.userId,
                                    'bg-gray-200 w-fit px-4 py-2 rounded-full ':
                                        chats.userId !== this.userId,
                                    'bg-green-200 w-fit px-4 py-2 rounded-full ':
                                        chats.userId === this.userId,
                                    hidden:
                                        chats.appointmentId !== this.ConvoId,
                                }"
                            >
                                <h1 :class="{}">
                                    {{ chats.chats }}
                                </h1>
                            </h1>
                        </div>
                    </div>

                    <form
                        class="my-2"
                        @submit.prevent="sendChat"
                        v-if="this.ConvoId"
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
                                    :disabled="isOnlyWhiteSpace(this.message)"
                                    type="submit"
                                    class="bg-green-500 px-4 py-2 rounded-md text-gray-50"
                                    :class="{
                                        'cursor-not-allowed': isOnlyWhiteSpace(
                                            this.message
                                        ),
                                    }"
                                >
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <Dialog
                :v-model="visible"
                modal
                header="Messages"
                @hide="closeChat"
                class="block md:hidden"
            >
                <div class="py-5 flex items-center justify-between">
                    {{ this.ConvoWithName }}
                </div>
                <div class="min-h-full" v-if="this.chatLoading">Loading...</div>

                <div
                    class="overflow-y-scroll min-h-full h-full scrollbar-thin scrollbar-thumb-rounded-full px-2 scrollbar-thumb-gray-200 scrollbar-track-gray-100"
                    v-else
                >
                    <div
                        class="flex flex-col min-h-full max-h-full"
                        id="chats"
                        ref="chats"
                    >
                        <h1
                            v-for="chats in chat"
                            :key="chats.id"
                            class="w-auto text-gray-900 my-1 max-w-xs"
                            :ref="'chatIndex' + chats.id"
                            :class="{
                                'self-start text-left':
                                    chats.userId !== this.userId,
                                'self-end text-right':
                                    chats.userId === this.userId,
                                'bg-gray-200 w-fit px-4 py-2 rounded-full ':
                                    chats.userId !== this.userId,
                                'bg-green-200 w-fit px-4 py-2 rounded-full ':
                                    chats.userId === this.userId,
                                hidden: chats.appointmentId !== this.ConvoId,
                            }"
                        >
                            <h1 :class="{}">
                                {{ chats.chats }}
                            </h1>
                        </h1>
                    </div>
                </div>

                <form
                    class="my-2"
                    @submit.prevent="sendChat"
                    v-if="this.ConvoId"
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
                                :disabled="isOnlyWhiteSpace(this.message)"
                                type="submit"
                                class="bg-green-500 px-4 py-2 rounded-md text-gray-50"
                                :class="{
                                    'cursor-not-allowed': isOnlyWhiteSpace(
                                        this.message
                                    ),
                                }"
                            >
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </Dialog>
        </div>
    </Layout>
</template>

<script>
import { mapState, mapActions } from "vuex";
import _debounce from "lodash/debounce";
import Dialog from "primevue/dialog";

export default {
    computed: {
        ...mapState(["userId"]),
    },
    components: {
        Dialog,
    },

    data() {
        return {
            ConvoId: null,
            ConvoWithName: null,
            inbox: null,
            chatLoading: false,
            chat: null,
            message: "",
            listenerStatus: {},
            titleQuery: "",
            visible: false,
        };
    },

    methods: {
        getChat(id) {
            this.chatLoading = true;

            axios.post("/getconvo", { appointmentId: id }).then(({ data }) => {
                this.$router.push({
                    name: "chat",
                    params: { id: parseInt(id) },
                });
                this.chat = [];
                this.chat = data;

                this.$nextTick(() => this.scrollToEnd());

                if (!this.listenerStatus[id]) {
                    this.listen(id);
                    this.listenerStatus[id] = true;
                }
                this.chatLoading = false;
            });
        },
        getConvoId() {
            axios.post("/getConvoId", { role: 1 }).then(({ data }) => {
                console.log(data);
                this.inbox = data;
            });
        },

        searchConvo() {
            const { titleQuery } = this;

            axios
                .post("/searchConvo", { titleQuery: titleQuery, role: 1 })
                .then(({ data }) => {
                    console.log(data);
                    this.inbox = data;
                });
        },
        clearQuery() {
            this.titleQuery = "";
            this.getConvoId();
        },
        isOnlyWhiteSpace(string) {
            const isWhitespaceString = !string.replace(/\s/g, "").length;

            return isWhitespaceString;
        },
        sendChat: _debounce(function () {
            const { message, ConvoId } = this;

            axios
                .post("/sendconvo", {
                    appointmentId: ConvoId,
                    message,
                })
                .then(({ data }) => {
                    console.log("Message sent successfully:", data);
                    this.message = "";
                })
                .catch((error) => {
                    console.error("Error sending message:", error);
                });
        }, 400),
        openChat(appointmentId, name) {
            this.visible = true;
            this.ConvoId = appointmentId;
            this.ConvoWithName = name;
            this.getChat(appointmentId);
        },
        closeChat() {
            this.visible = false;
            this.ConvoId = null;
            this.ConvoWithName = null;
        },
        scrollToEnd() {
            this.$nextTick(() => {
                const chatContainer = this.$refs?.chats;
                if (chatContainer && this.chat.length > 0) {
                    const lastMessage =
                        this.$refs[
                            "chatIndex" + this.chat[this.chat.length - 1].id
                        ];

                    if (lastMessage) {
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
            const data = (e) => {
                console.log(e);
                if (
                    Array.isArray(this.chat) &&
                    e.appointmentId === appointmentId
                ) {
                    this.chat.push({
                        chats: e.message,
                        userId: e.userId,
                        appointmentId: e.appointmentId,
                    });
                    this.scrollToEnd(); // Scroll to the end when a new message is received
                }
            };

            window.Echo.private(`chat${appointmentId}`).listen(
                ".newchat",
                data
            );
        },
    },

    created() {
        this.getConvoId();
    },
};
</script>
<style lang=""></style>
