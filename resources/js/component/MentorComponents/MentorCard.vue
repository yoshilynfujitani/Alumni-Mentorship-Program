<template lang="">
    <div class="h-full w-full">
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm h-full w-56 py-5"
        >
            <div class="flex flex-col justify-end items-center h-full">
                <div class="items-center flex flex-col">
                    <img
                        class="w-24 h-24 mb-3 rounded-full shadow-lg"
                        src="../../../../public/DefaultAvatar.webp"
                        alt="Avatar"
                    />
                    <h5
                        class="mb-1 text-xl text-center font-medium text-gray-900 dark:text-white"
                    >
                        {{ MentorDetails.name }}
                    </h5>
                    <h1
                        class="text-sm text-center text-gray-500 dark:text-gray-400"
                    >
                        {{ MentorDetails.fieldName }}
                    </h1>
                    <span
                        class="text-sm text-center flex items-center text-gray-500 dark:text-gray-400 gap-1"
                    >
                        <div class="" v-if="!MentorDetails.rating">
                            <h1 class="text-xs my-1 italic text-gray-400">
                                Mentor has no ratings
                            </h1>
                        </div>
                        <div class="" v-else>
                            {{ MentorDetails.rating }}
                            <i
                                class="pi pi-star-fill text-sm text-yellow-400"
                            ></i>
                        </div>
                    </span>
                </div>
                <div class="flex items-center flex-col mt-2 gap-1">
                    <div class="">
                        <button
                            @click="onCardClick"
                            class="bg-blue-400 text-white px-2 py-1 rounded-md"
                        >
                            View Details
                        </button>
                        <Dialog
                            v-model:visible="visible"
                            modal
                            :header="MentorDetails.name + '\'s Profile'"
                            :style="{ width: '25rem' }"
                        >
                            <div class="flex gap-5">
                                <img
                                    class="w-24 h-24 mb-3 rounded-full shadow-lg"
                                    src="../../../../public/DefaultAvatar.webp"
                                    alt="Avatar"
                                />
                                <div class="">
                                    <label
                                        for=""
                                        class="text-sm text-green-500 font-medium"
                                        >Mentor's Field</label
                                    >
                                    <h1>{{ MentorDetails.fieldName }}</h1>

                                    <label
                                        for=""
                                        class="text-sm text-green-500 font-medium"
                                        >Mentor's Rating</label
                                    >
                                    <div class="" v-if="!MentorDetails.rating">
                                        <h1
                                            class="text-xs my-1 italic text-gray-400"
                                        >
                                            Mentor has no ratings
                                        </h1>
                                    </div>
                                    <div class="" v-else>
                                        {{ MentorDetails.rating }}
                                        <i
                                            class="pi pi-star-fill text-sm text-yellow-400"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <h1 class="text-green-500 font-medium">
                                    Most Recent Feedbacks
                                </h1>
                                <div
                                    class="text-center text-gray-400"
                                    v-if="recentFeedbacks?.length === 0"
                                >
                                    <i
                                        class="pi pi-ban text-sm text-gray-400"
                                    ></i>
                                    No Info to show
                                </div>
                                <div
                                    class="border border-gray-200 my-2 rounded-md p-2.5"
                                    v-for="feedback in recentFeedbacks"
                                    v-else
                                >
                                    <h1 class="text-gray-400 text-sm">
                                        Anonymous (<span
                                            >{{ feedback.rating }}
                                            <i
                                                class="pi pi-star-fill text-sm text-yellow-400"
                                            ></i></span
                                        >)
                                    </h1>
                                    <p>{{ feedback?.comments }}</p>
                                </div>
                            </div>
                            <div class="flex justify-content-end gap-2">
                                <button
                                    type="button"
                                    label="Cancel"
                                    severity="secondary"
                                    @click="visible = false"
                                ></button>
                                <button
                                    type="button"
                                    label="Save"
                                    @click="visible = false"
                                ></button>
                            </div>
                        </Dialog>
                    </div>
                    <div class="flex" v-if="displaybtn">
                        <AppointmentForm
                            :MentorDetails="MentorDetails"
                            type="student"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AppointmentForm from "../StudentComponents/AppointmentForm.vue";
import Dialog from "primevue/dialog";
export default {
    props: ["MentorDetails", "displaybtn"],
    data() {
        return {
            visible: false,
            recentFeedbacks: null,
        };
    },
    components: {
        AppointmentForm,
        Dialog,
    },
    methods: {
        getRecentFeedbacks() {
            axios
                .post("/getrecentfeedback", { mentorId: this.MentorDetails.id })
                .then(({ data }) => {
                    this.recentFeedbacks = data;
                });
        },
        onCardClick() {
            this.visible = true;
            this.getRecentFeedbacks();
        },
    },
};
</script>
<style lang=""></style>
