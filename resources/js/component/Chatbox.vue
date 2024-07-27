<template>
    <div
        class="bg-gray-50 min-h-full rounded-md w-full overflow-scroll flex-grow border border-gray-200 shadow-sm md:overflow-clip"
    >
        <div
            class="w-full h-full flex items-center justify-center"
            v-if="chat === null"
        >
            <h1>No conversation selected</h1>
        </div>
        <div
            class="w-full min-h-full md:h-full flex pb-32 md:pb-36 flex-col justify-between"
            v-else
        >
            <div
                class="py-2.5 px-5 w-full flex justify-between bg-white shadow-sm"
                v-if="convoId"
            >
                <div class="">
                    <div class="flex items-center gap-1.5">
                        <img
                            class="w-10 h-10 rounded-full shadow-lg"
                            src="../../../public/DefaultAvatar.webp"
                            alt=""
                        />
                        {{ userName }}
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
                <button class="md:hidden text-sm" @click="$emit('clear')">
                    Back
                </button>
            </div>
            <div class="flex items-center justify-center h-full" v-else>
                Please Select chat to get started
            </div>
            <div class="min-h-full" v-if="chatLoading">Loading...</div>

            <div
                v-else
                :class="{
                    hidden: chat === null,
                    'overflow-y-scroll': chat.length > 0,
                }"
                class="px-5 min-h-full h-full w-full scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-gray-200 scrollbar-track-gray-100"
            >
                <!-- <h1 class="text-center my-2.5">Load more</h1> -->

                <!-- Chat messages -->
                <div
                    class="flex flex-col min-h-full max-h-full"
                    id="chats"
                    ref="chats"
                >
                    <div
                        v-for="(chats, index) in chat"
                        :key="chats.id"
                        class="w-full text-white my-1 font-medium flex flex-col"
                        :ref="'chatIndex' + chats.id"
                    >
                        <div
                            v-if="shouldShowUserLabel(chats, index)"
                            class="text-xs text-gray-400 italic"
                            :class="{
                                'self-start text-left': chats.userId !== userId,
                                'self-end text-right': chats.userId === userId,
                            }"
                        >
                            <h1 v-if="chats.role === 3">Admin</h1>
                            <h1 v-if="chats.role === 2">Mentor</h1>
                            <h1 v-if="chats.role === 1">Student</h1>
                            <h1 v-if="chats.role === 4">PDC User</h1>
                        </div>
                        <p
                            v-if="!chats.fileName"
                            class="w-auto text-white max-w-xs font-medium"
                            :class="{
                                'self-start text-left': chats.userId !== userId,
                                'self-end text-right': chats.userId === userId,
                                'bg-gray-400 w-fit px-4 py-2 rounded-full':
                                    chats.userId !== userId && !chats.fileName,
                                'bg-green-500 w-fit px-4 py-2 rounded-full':
                                    chats.userId === userId && !chats.fileName,
                                ' w-fit  rounded-full': chats.fileName,
                                'bg-yellow-400 w-fit px-4 py-2 self-start text-left':
                                    chats.role === 3 && chats.userId !== userId,
                            }"
                        >
                            {{ chats.chats }}
                        </p>

                        <div v-else class="flex flex-col">
                            <p
                                class="bg-green-500 px-4 py-2 rounded-full"
                                :class="{
                                    'self-start bg-gray-400':
                                        chats.userId !== userId,
                                    'self-end': chats.userId === userId,
                                    hidden: !chats.chats,
                                }"
                            >
                                {{ chats.chats }}
                            </p>
                            <div
                                :class="{
                                    'self-start': chats.userId !== userId,
                                    'self-end': chats.userId === userId,
                                }"
                                class="bg-gray-600 rounded-md flex items-center gap-1.5 my-1.5 p-2.5 max-w-[300px] hover:cursor-pointer"
                                @click="
                                    onDownload(chats.filePath, chats.fileName)
                                "
                            >
                                <i
                                    class="pi pi-file bg-green-500 rounded-full p-2.5"
                                ></i>
                                <p
                                    class="text-ellipsis overflow-hidden whitespace-nowrap text-sm"
                                >
                                    {{ chats.fileName }}
                                </p>
                                <i class="pi pi-cloud-download text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form
                class="flex w-full pb-2.5 mt-1.5 px-2.5 items-center gap-2.5"
                @submit.prevent="sendChat"
                v-if="convoId"
            >
                <input
                    type="file"
                    ref="fileInput"
                    style="display: none"
                    @change="onFileChange"
                />
                <button
                    type="button"
                    @click="triggerFileInput"
                    class="bg-green-800 px-4 py-2 rounded-md text-gray-50 text-ellipsis overflow-hidden max-w-[200px] max-h-10 break-keep"
                >
                    <span v-if="fileName">{{ fileName }}</span>
                    <span class="flex items-center gap-2.5" v-else
                        ><i class="pi pi-cloud-download"></i>
                        <span class="hidden md:block">Upload File</span></span
                    >
                </button>

                <div class="relative flex-1">
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
                    <div class="flex items-center gap-2.5">
                        <input
                            v-model="message"
                            type="search"
                            id="search"
                            class="block w-full px-4 py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                            placeholder="Send message..."
                        />
                        <button
                            type="submit"
                            class="bg-green-800 px-4 py-2 rounded-md text-gray-50"
                            :class="{ 'opacity-60': isSending }"
                            :disabled="isSending"
                        >
                            <p v-if="!isSending">Send</p>
                            <p v-else>
                                <i class="pi pi-spin pi-spinner"></i>
                            </p>
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
import FileUpload from "primevue/fileupload";

export default {
    props: ["convoId", "userIsOnline", "userName"],
    data() {
        return {
            chat: [],
            message: null,
            moment,
            chatLoading: false,
            listenerStatus: {},
            subscription: null,
            selectedFile: null,
            fileName: null,
            isSending: false,
        };
    },
    components: {
        FileUpload,
    },
    computed: {
        ...mapState(["userId"]),
    },
    methods: {
        sendChat: _debounce(function () {
            const { message, convoId, selectedFile, i } = this;

            this.isSending = true;

            const created_at = new Date()
                .toISOString()
                .slice(0, 19)
                .replace("T", " ");
            const formData = new FormData();

            if (message && message.trim()) {
                formData.append("message", message);
            }

            if (selectedFile) {
                formData.append("file", selectedFile);
            }

            formData.append("appointmentId", convoId);
            formData.append("created_at", created_at);

            axios
                .post("/sendconvo", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    console.log("Message sent successfully:", data);
                    this.isSending = false;
                    this.message = null;
                    this.selectedFile = null;
                    this.fileName = null; // Reset the filename
                    this.$refs.fileInput.value = "";

                    this.scrollToEnd();
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
                    this.chat = data;
                    this.scrollToEnd();

                    if (!this.listenerStatus[id]) {
                        this.listen(id);
                        this.listenerStatus[id] = true; // Set to true when subscribing
                    }

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
        shouldShowUserLabel(message, index) {
            // Always show the label for the first message
            if (index === 0) return true;

            // Show the label if the user is different from the previous message
            const previousMessage = this?.chat[index - 1];
            return previousMessage.userId !== message.userId;
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
                    // this is for the real time chat
                    this.chat.push({
                        id: e.id,
                        chats: e.message,
                        userId: e.userId,
                        appointmentId: e.appointmentId,
                        created_at: e.created_at,
                        fileName: e.fileName,
                        filePath: e.filePath,
                        role: e.role,
                    });
                    // Scroll to the end when a new message is received
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

        triggerFileInput() {
            this.$refs.fileInput.click();
        },

        onFileChange(event) {
            this.selectedFile = event.target.files[0];
            this.fileName = this.selectedFile ? this.selectedFile.name : null;
        },

        onDownload(filePath, fileName) {
            axios
                .post(
                    "/downloadfile",
                    { filePath, fileName },
                    {
                        responseType: "blob",
                    }
                )
                .then(({ data }) => {
                    const blob = new Blob([data]);
                    const url = window.URL.createObjectURL(blob);
                    // Create a temporary link element
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", fileName);
                    // Append the link to the body
                    document.body.appendChild(link);
                    // Trigger the download
                    link.click();
                    // Clean up
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(link);
                })
                .catch((error) => {
                    console.error("Error downloading file:", error);
                });
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
