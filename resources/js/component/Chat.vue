<template lang="">
    <ChatModal
        :modalContent="{
            title: 'Chat',
            // content: 'Please fill out the form below:',
        }"
        @modalopen="getChat"
        cancelLabel="Back"
        buttonIcon="AkChatDots"
        iconLabel="Chat"
        saveLabel="Send"
        :saveOption="false"
        @save="sendChat"
        ><div class="w-auto flex flex-col"></div>
    </ChatModal>
</template>
<script>
import ChatModal from "./ChatModal.vue";

import { mapState, mapActions } from "vuex";
export default {
    computed: {
        ...mapState(["userId"]),
    },
    props: ["appointmentId"],
    components: { ChatModal },
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

                    this.$nextTick(() => this.scrollToEnd());
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

                    this.message = "";
                });
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
                        // Scroll to the last element within the chat container
                        lastMessage[0].scrollIntoView({
                            behavior: "smooth",
                            block: "end",
                            inline: "nearest",
                        });
                    }
                }
            });
        },
    },

    mounted() {},
};
</script>
<style lang=""></style>
