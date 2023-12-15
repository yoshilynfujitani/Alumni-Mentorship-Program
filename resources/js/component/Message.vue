<template>
    <div>
        <h1 class="p3 text-2-2xl font-bold">Message</h1>
        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="message" />
        <div>
            <button
                class="bg-blue-500 py-2 px-4 rounded text-white"
                @click="sendto('/yoshi')"
            >
                Send to Yoshi
            </button>
            <button
                class="bg-red-500 py-2 px-4 rounded text-white"
                @click="sendto('/simon')"
            >
                Send to Simon
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: null,
        };
    },
    methods: {
        sendto(path) {
            this.$router.push({
                path: path,
                query: { messageSent: this.message },
            });
        },
    },
};
</script>
