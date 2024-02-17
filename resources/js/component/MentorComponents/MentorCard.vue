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
                            class="bg-blue-400 text-white px-2 py-1 rounded-md"
                        >
                            View Details
                        </button>
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
export default {
    props: ["MentorDetails", "displaybtn"],
    components: {
        AppointmentForm,
    },
    methods: {},
};
</script>
<style lang=""></style>
