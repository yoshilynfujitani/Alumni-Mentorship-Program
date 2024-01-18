<template lang="">
    <div
        class="min-w-[225px] bg-white border p-5 border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
        :class="{
            'min-h-[250px]': displaybtn === 0,
            'min-h-[320px]': displaybtn === 1,
        }"
    >
        <div class="flex flex-col justify-end h-full items-center">
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
                <span
                    class="text-sm text-center text-gray-500 dark:text-gray-400"
                    >{{ MentorDetails.fieldName }}</span
                >
            </div>
            <div class="flex mt-4 md:mt-6" v-if="displaybtn">
                <AppointmentForm :MentorDetails="MentorDetails" />
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
