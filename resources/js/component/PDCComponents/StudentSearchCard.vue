<template lang="">
    <div
        class="flex items-center justify-between px-4 py-2 bg-white rounded-md border border-gray-100 my-2"
        :class="{
            'border-2 border-green-500': this.isActive,
        }"
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
        <div
            class="transition-all px-2.5 py-1 text-xl bg-green-600 rounded-full text-white hover:cursor-pointer hover:bg-green-500"
            @click="handleQueryData"
        >
            <i class="pi pi-plus"></i>
        </div>
    </div>
</template>
<script>
export default {
    props: ["studentDetails", "isActive"],
    components: {},
    data() {
        return {
            students: null,
            searchQuery: "",
        };
    },
    methods: {
        handleQueryData() {
            this.$emit("clicked", this.studentDetails);
        },
    },
};
</script>
<style lang=""></style>
