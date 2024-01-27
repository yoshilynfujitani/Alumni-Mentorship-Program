<template lang="">
    <Modal
        :modalContent="{
            title: 'Feedback Form',
            disablebtn: disable,
            // content: 'Please fill out the form below:',
        }"
        type="rate"
        buttonLabel="Rate"
        cancelLabel="Back"
        saveLabel="Submit Feedback"
        @save=""
    >
        <div
            class="max-w-xl mx-auto my-8 flex w-full flex-col border border-gray-200 rounded-lg bg-white p-8"
        >
            <h2 class="title-font mb-1 text-lg font-medium text-gray-900">
                Feedback
            </h2>
            <p class="mb-5 leading-relaxed text-gray-600">
                If you had any issues or you enjoyed the experience, please
                share with us!
            </p>
            <div class="mb-4 flex flex-col items-center">
                <label for="email" class="text-sm leading-7 text-gray-600"
                    >Rating</label
                >
                <StarRating :value="this.rating" @input="handleChangeRating" />
            </div>
            <div class="mb-4">
                <label for="message" class="text-sm leading-7 text-gray-600"
                    >Feedback</label
                >
                <textarea
                    id="message"
                    name="message"
                    class="h-32 w-full resize-none rounded border border-gray-300 bg-white py-1 px-3 text-base leading-6 text-gray-700 outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                ></textarea>
            </div>

            <p class="mt-3 text-xs text-gray-500">
                Feel free to connect with us through your insitutional email.
            </p>
        </div>
    </Modal>
</template>
<script>
import Modal from "../Modal.vue";
import StarRating from "../StarRating.vue";

export default {
    props: {
        appointmentId: {
            type: String,
        },
        disable: {
            type: Boolean,
        },
    },
    components: {
        Modal,
        StarRating,
    },
    data() {
        return {
            rating: 3,
        };
    },
    methods: {
        handleChangeRating(data) {
            this.rating = data;
            console.log(this.rating);
        },
    },

    mounted() {},
};
</script>
