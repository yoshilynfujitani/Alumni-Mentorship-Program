<template lang="">
    <div class="h-full w-full">
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm h-full w-56 py-5"
        >
            <div class="flex flex-col justify-end items-center h-full">
                <div class="items-center flex flex-col">
                    <img
                        class="w-24 h-24 mb-3 rounded-md shadow-lg"
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
                    <div class="flex gap-2 px-2">
                        <button
                            @click="onCardClick"
                            class="bg-blue-400 text-white px-2 py-1 rounded-md flex items-center justify-center"
                        >
                            <i class="pi pi-eye"></i>
                        </button>
                        <Dialog
                            v-model:visible="visible"
                            modal
                            :header="MentorDetails.name + '\'s Profile'"
                        >
                            <div
                                class="flex gap-5 border border-gray-100 rounded p-2"
                            >
                                <img
                                    class="w-24 h-24 mb-3 rounded-full shadow-lg"
                                    src="../../../../public/DefaultAvatar.webp"
                                    alt="Avatar"
                                />
                                <div class="">
                                    <label
                                        for=""
                                        class="text-sm text-green-700 font-medium"
                                        >Mentor's Field</label
                                    >
                                    <h1>{{ MentorDetails.fieldName }}</h1>

                                    <label
                                        for=""
                                        class="text-sm text-green-700 font-medium"
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
                                        <span class="text-gray-400 text-sm">
                                            ({{ MentorDetails.feedBackCount }})
                                            reviews</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="pb-5 flex flex-col">
                                <h1
                                    class="text-green-700 text-sm font-medium py-2.5 flex items-center gap-1"
                                >
                                    <i class="pi pi-calendar"></i> Available Day
                                    for Appointments
                                </h1>
                                <div class="flex space-x-2.5">
                                    <div
                                        class="border px-2 py-1 rounded-md border-gray-200 text-gray-200"
                                        v-for="day in daysOfTheWeek"
                                        :class="{
                                            'border-blue-600 border-2 text-blue-500':
                                                isActiveDay(day.id),
                                        }"
                                    >
                                        <p class="font-semibold">
                                            {{ day.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <h1 class="text-green-700 font-medium">
                                    <i class="pi pi-megaphone"></i> Most Recent
                                    Feedbacks
                                </h1>
                                <div
                                    class="text-center text-gray-400 py-20"
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
            activeAvailableDays: [],
            daysOfTheWeek: [
                {
                    id: 1,
                    name: "Sun",
                },
                {
                    id: 2,
                    name: "Mon",
                },
                {
                    id: 3,
                    name: "Tue",
                },
                {
                    id: 4,
                    name: "Wed",
                },
                {
                    id: 5,
                    name: "Thu",
                },
                {
                    id: 6,
                    name: "Fri",
                },
                {
                    id: 7,
                    name: "Sat",
                },
            ],
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
        getLatestSchedule() {
            axios
                .post("/getLatestSchedule", { mentorId: this.MentorDetails.id })
                .then(({ data }) => {
                    this.activeAvailableDays = data.map((day) =>
                        parseInt(day, 10)
                    );
                });
        },
        isActiveDay(dayId) {
            return this.activeAvailableDays.includes(dayId);
        },
        onCardClick() {
            this.visible = true;
            this.getRecentFeedbacks();
            this.getLatestSchedule();
        },
    },
};
</script>
<style lang=""></style>
