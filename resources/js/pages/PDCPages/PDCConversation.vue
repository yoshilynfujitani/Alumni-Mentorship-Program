<template lang="">
    <LayoutPDC>
        <div class="flex w-full gap-5 h-screen py-10">
            <!-- Message Headers -->
            <div
                class="p-5 bg-white rounded-md min-w-[400px] max-w-[400px] min-h-full max-h-full border border-gray-200 shadow-sm overflow-y-scroll scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-50 scrollbar-track-gray-50"
            >
                <div class="">
                    <h1 class="font-bold text-2xl py-2">Messages</h1>
                    <div class="w-full flex justify-between">
                        <div class="relative">
                            <input
                                v-model="titleQuery"
                                class="border border-gray-200 rounded-md active:border-green-200 focus:border-green-200"
                                placeholder="Search User..."
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
                class="bg-gray-50 pb-32 px-5 rounded-md w-full flex-grow border border-gray-200 shadow-sm"
            >
                <div
                    class="w-full h-full flex items-center justify-center"
                    v-if="this.chat === null"
                >
                    <h1>No conversation selected</h1>
                </div>
                <div class="w-full h-full" v-else>
                    <div class="py-5">{{ this.ConvoWithName }}</div>
                    <div class="min-h-full" v-if="this.chatLoading">
                        Loading...
                    </div>

                    <div
                        class="overflow-y-scroll min-h-full h-full scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-200 scrollbar-track-gray-100"
                        v-else
                    >
                        <div class="flex flex-col" id="chats" ref="chats">
                            <div class="flex flex-col">
                                <h1
                                    v-for="chats in chat"
                                    :key="chats.id"
                                    :ref="'chatIndex' + chats.id"
                                    class="w-auto flex items-center text-gray-900 my-1 self-end relative"
                                >
                                    <p class="text-sm text-gray-400 mr-2">
                                        {{
                                            moment(
                                                chats.created_at,
                                                "YYYY-MM-DD HH:mm:ss"
                                            ).format(" HH:mm:ss")
                                        }}
                                    </p>
                                    <h1
                                        class=""
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
                                                chats.appointmentId !==
                                                this.ConvoId,
                                        }"
                                    >
                                        {{ chats.chats }}
                                    </h1>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <form
                        class="my-2"
                        @submit.prevent="sendChat"
                        v-if="this.ConvoId"
                    >
                        <h1 class="text-center text-gray-400">
                            You cannot reply to this conversation
                        </h1>
                    </form>
                </div>
            </div>
        </div>
    </LayoutPDC>
</template>

<script>
import { mapState, mapActions } from "vuex";
import _debounce from "lodash/debounce";
import LayoutMentor from "../../Layout/LayoutMentor.vue";
import moment from "moment";
export default {
    computed: {
        ...mapState(["userId"]),
    },
    components: {
        LayoutMentor,
    },

    data() {
        return {
            ConvoId: null,
            ConvoWithName: null,
            inbox: null,
            chatLoading: false,
            chat: [],
            message: "",
            listenerStatus: {},
            moment,
        };
    },

    methods: {
        getChat(id) {
            this.chatLoading = true;

            axios.post("/getconvo", { appointmentId: id }).then(({ data }) => {
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
            axios.post("/getConvoId", { role: 3 }).then(({ data }) => {
                console.log(data);
                this.inbox = data;
            });
        },
        searchConvo() {
            const { titleQuery } = this;

            axios
                .post("/searchConvo", { titleQuery, role: 3 })
                .then(({ data }) => {
                    console.log(data);
                    this.inbox = data;
                });
        },
        clearQuery() {
            this.titleQuery = "";
            this.getConvoId();
        },
        sendChat: _debounce(function () {
            const { message, ConvoId } = this;
            let created_at = new Date(Date.now())
                .toISOString()
                .slice(0, 19)
                .replace("T", " ");

            axios
                .post("/sendconvo", {
                    appointmentId: ConvoId,
                    message,
                    created_at: created_at,
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
            this.ConvoId = appointmentId;
            this.ConvoWithName = name;
            this.getChat(appointmentId);
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
                        created_at: e.created_at,
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
