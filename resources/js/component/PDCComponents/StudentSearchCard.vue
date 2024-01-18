<template lang="">
    <div
        class="flex items-center justify-between px-4 py-2 bg-white rounded-md border border-gray-100 my-2"
    >
        <div class="font-semibold text-black flex items-center gap-2 py-2">
            <img
                src="../../../../public/DefaultAvatar.webp"
                class="w-12 h-12 rounded-full"
                alt=""
            />
            <div class="flex flex-col items-start">
                <h1>{{ this.studentDetails.name }}</h1>
                <h1 class="text-gray-400 font-normal">
                    {{ this.studentDetails.course }}
                </h1>
            </div>
        </div>
        <div class="">Add</div>
    </div>
</template>
<script>
import AppointmentForm from "../StudentComponents/AppointmentForm.vue";
export default {
    props: ["studentDetails"],
    data() {
        return {
            students: null,
            searchQuery: "",
        };
    },
};
</script>
<style lang=""></style>
