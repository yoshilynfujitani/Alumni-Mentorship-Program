<template lang="">
    <Modal
        :modalContent="{
            title: 'Chat',
            // content: 'Please fill out the form below:',
        }"
        buttonLabel="Chat"
        cancelLabel="Back"
        saveLabel="Send"
        @save="sendTicket"
        ><div class="w-auto mx-60">
            <div class="w-full bg-green-400">Hello</div>
        </div></Modal
    >
</template>
<script>
import Modal from "./Modal.vue";
export default {
    props: ["appointmentId"],
    components: { Modal },
    data() {
        return {};
    },
    methods: {},

    mounted() {},
};
</script>
<style lang=""></style>
