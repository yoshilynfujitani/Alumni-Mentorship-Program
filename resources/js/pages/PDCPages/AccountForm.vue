<template>
    <div class="flex">
        <div
            class="mt-5 bg-white rounded-lg shadow flex flex-col w-full transition-all ease-in duration-300"
        >
            <div class="flex flex-col">
                <div class="flex-1 py-5 pl-5 overflow-hidden">
                    <h1 class="inline text-2xl font-semibold leading-none">
                        Account Details
                    </h1>
                </div>
            </div>
            <div class="px-5 pb-5">
                <input
                    v-model="formData.name"
                    placeholder="Name"
                    class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-100 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"
                />
                <span v-if="errors.name" class="text-red-600">{{
                    errors.name
                }}</span>
                <input
                    v-model="formData.email"
                    placeholder="user@email.com"
                    type="email"
                    class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-100 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"
                />
                <span v-if="errors.email" class="text-red-600">{{
                    errors.email
                }}</span>
                <div class="flex items-center gap-5 my-2.5">
                    <div class="flex-grow">
                        <Dropdown
                            v-model="formData.college"
                            :options="colleges"
                            optionLabel="CollegeName"
                            placeholder="Select a College"
                            class="w-full"
                        />
                        <span v-if="errors.college" class="text-red-600">{{
                            errors.college
                        }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-row p-3">
                <div class="flex-initial pl-3">
                    <button
                        type="button"
                        @click="handleSave"
                        :disabled="hasErrors"
                        class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-green-600 rounded-md"
                    >
                        <span class="">Save</span>
                    </button>
                </div>
                <div class="flex-initial">
                    <button
                        type="button"
                        @click="$emit('cancel')"
                        class="flex items-center px-5 py-2.5 font-medium tracking-wide text-black capitalize rounded-md"
                    >
                        <span class="">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Dropdown from "primevue/dropdown";

export default {
    components: {
        Dropdown,
    },
    data() {
        return {
            formData: { name: "", email: "", college: "" },
            colleges: [],
            errors: {},
        };
    },
    computed: {
        hasErrors() {
            return Object.keys(this.errors).length > 0;
        },
    },
    methods: {
        validateForm() {
            this.errors = {};
            if (!this.formData.name) {
                this.errors.name = "Name is required.";
            }
            if (!this.formData.email) {
                this.errors.email = "Email is required.";
            }
            if (!this.formData.college) {
                this.errors.college = "College is required.";
            }
        },
        handleSave() {
            this.validateForm();
            if (!this.hasErrors) {
                axios
                    .post("/createpdc", {
                        name: this.formData.name,
                        email: this.formData.email,
                        course: this.formData.college.id,
                    })
                    .then(({ data }) => {
                        console.log(data);
                        this.$emit("success");
                    });
            }
        },
        getColleges() {
            axios.get("/getcolleges").then(({ data }) => {
                this.colleges = data;
            });
        },
    },
    mounted() {
        this.getColleges();
    },
};
</script>

<style scoped>
/* Add any necessary scoped styles here */
</style>
