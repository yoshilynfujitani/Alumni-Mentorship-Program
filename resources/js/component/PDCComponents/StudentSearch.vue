<template lang="">
    <div class="min-w-[400px]">
        <input
            type="text"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
            v-model="searchQuery"
        />
        <button @click="findUser">Search</button>
        <div class="" v-if="this.students === null">Enter Student Name...</div>
        <div class="" v-else>
            <div class="" v-for="Student in students">
                <StudentSearchCard :studentDetails="Student" />
            </div>
        </div>
    </div>
</template>
<script>
import StudentSearchCard from "./StudentSearchCard.vue";
export default {
    components: {
        StudentSearchCard,
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
    },
};
</script>
<style lang=""></style>
