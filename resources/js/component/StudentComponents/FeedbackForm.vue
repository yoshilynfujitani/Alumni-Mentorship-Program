<template lang="">
    <div class="">
        <Modal
            :modalContent="{
                title: 'Feedback Form',
                disablebtn: disable,
                // content: 'Please fill out the form below:',
            }"
            type="rate"
            buttonIcon="FlFilledPersonStar"
            iconLabel="Rate"
            cancelLabel="Back"
            :saveLabel="
                !this.appointmentDetails?.feedbackSent
                    ? 'Submit Feedback'
                    : null
            "
            @save="submitFeedback"
            @modalopen="getAppointmentDetails"
        >
            <div class="" v-if="!this.appointmentDetails">Loading...</div>
            <div class="" v-if="!this.appointmentDetails.feedbackSent">
                <div
                    class="max-w-xl mx-auto my-8 flex w-full flex-col border border-gray-200 rounded-lg bg-white p-8"
                >
                    <h2
                        class="title-font mb-1 text-lg font-medium text-gray-900"
                    >
                        Feedback
                    </h2>
                    <p class="mb-5 leading-relaxed text-gray-600">
                        If you had any issues or you enjoyed the experience,
                        please share with us!
                    </p>
                    <div class="mb-4 flex flex-col items-center">
                        <label
                            for="email"
                            class="text-sm leading-7 text-gray-600"
                            >Rating</label
                        >
                        <StarRating
                            :value="this.rating"
                            @input="handleChangeRating"
                        />
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label
                            for="message"
                            class="text-sm leading-7 text-gray-600"
                            >Feedback</label
                        >
                        <textarea
                            v-model="comments"
                            id="message"
                            name="message"
                            class="h-32 w-full resize-none rounded border border-gray-300 bg-white py-1 px-3 text-base leading-6 text-gray-700 outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                        ></textarea>
                    </div>

                    <p class="mt-3 text-xs text-gray-500 text-center">
                        Feel free to connect with us through your insitutional
                        email.
                    </p>
                </div>
            </div>
            <div class="" v-else>
                <h1>You have already submitted a feedback</h1>
            </div>
        </Modal>
    </div>
</template>
<script>
import Modal from "../Modal.vue";
import StarRating from "../StarRating.vue";
import { mapState, mapActions } from "vuex";

export default {
    props: {
        appointmentId: {
            type: Number,
        },
        userToRateId: {
            type: String,
        },
        disable: {
            type: Boolean,
        },
        userRole: {
            type: String,
        },
    },
    components: {
        Modal,
        StarRating,
    },
    data() {
        return {
            rating: 3,
            comments: "",
            appointmentDetails: null,
        };
    },
    computed: {
        ...mapState(["userId"]),
    },
    methods: {
        handleChangeRating(data) {
            this.rating = data;
        },

        submitFeedback() {
            const {
                rating,
                comments,
                appointmentId,
                userToRateId,
                userId,
                userRole,
            } = this;

            axios
                .post("/sendfeedback", {
                    rating,
                    comments,
                    appointmentId,
                    userToRateId,
                    userId,
                    userRole,
                })
                .then(({ data }) => {
                    this.getAppointmentDetails();
                    this.updateUserRating();
                });
        },
        getAppointmentDetails() {
            axios
                .post("/getAppointment", { appointmentId: this.appointmentId })
                .then(({ data }) => {
                    this.appointmentDetails = data;
                });
        },
        updateUserRating() {
            const { userToRateId } = this;
            axios
                .post("/updateUserRating", { userId: userToRateId })
                .then(({ data }) => {});
        },
    },

    mounted() {
        console.log(this.userToRateId);
    },
};
</script>
