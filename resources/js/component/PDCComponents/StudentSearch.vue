<template lang="">
    <div class="h-full min-w-[400px] border border-gray-200 rounded-md p-5">
        <h1 class="text-black text-start font-medium mb-2">Search Student</h1>
        <div class="flex items-center gap-2">
            <input
                type="text"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                v-model="searchQuery"
            />
            <button
                @click="findUser"
                class="px-4 py-3.5 bg-green-600 rounded-md text-white"
            >
                <BsSearch />
            </button>
        </div>
        <div
            class="pt-5 flex items-center justify-center"
            v-if="this.students === null"
        >
            <h1 class="text-8xl flex flex-col items-center opacity-50">
                <FlPeopleSearch /><span class="text-sm font-normal"
                    >Enter student name</span
                >
            </h1>
        </div>
        <div class="" v-else>
            <div class="" v-for="Student in students">
                <StudentSearchCard
                    :studentDetails="Student"
                    @clicked="handleQueryData"
                />
            </div>
        </div>
    </div>
</template>
<script>
import StudentSearchCard from "./StudentSearchCard.vue";
import { BsSearch } from "@kalimahapps/vue-icons";
import { FlPeopleSearch } from "@kalimahapps/vue-icons";
export default {
    components: {
        StudentSearchCard,
        BsSearch,
        FlPeopleSearch,
    },
    data() {
        return {
            students: null,
            searchQuery: "",
        };
    },
    methods: {
        findUser() {
            const { searchQuery } = this;
            axios.post("/searchuser", { searchQuery }).then(({ data }) => {
                console.log(data);
                this.students = data;
            });
        },
        handleQueryData(data) {
            this.$emit("query", data);
        },
    },
};
</script>
<style lang=""></style>
