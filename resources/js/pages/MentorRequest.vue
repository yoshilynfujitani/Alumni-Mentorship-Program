<template>
    <section
        class="flex flex-col items-center justify-center h-screen dark:bg-gray-900"
    >
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:py-10 lg:py-12"
        >
            <a
                href="#"
                class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
            >
                <img
                    class="w-8 h-8 mr-2"
                    src="../../../public/mmsu_logo.png"
                    alt="logo"
                />
                Alumni Mentorship Program
            </a>
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
            >
                <div
                    class="p-6 space-y-4 md:space-y-6 sm:p-8"
                    v-if="!this.hasRequest"
                >
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                    >
                        Apply as an Alumni Mentor
                    </h1>

                    <form
                        class="space-y-4 md:space-y-6"
                        action="#"
                        @submit.prevent="sendRequest"
                    >
                        <div>
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Send email</label
                            >
                            <input
                                :value="this.email"
                                disabled
                                type="email"
                                name="email"
                                id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Send Email
                        </button>

                        <p
                            class="text-sm font-light text-gray-500 dark:text-gray-400 flex flex-col text-center"
                        >
                            Your request will be verified
                        </p>
                    </form>
                </div>
                <div
                    class="p-6 flex flex-col items-center justify-center space-y-4 md:space-y-6 sm:p-8"
                    v-else
                >
                    <InlineMessage severity="warn"
                        >You have already sent a request</InlineMessage
                    >
                    <router-link to="/">
                        <button
                            class="bg-green-700 rounded-md text-white font-semibold px-4 py-2"
                        >
                            Go back to Log In
                        </button></router-link
                    >
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import InlineMessage from "primevue/inlinemessage";

export default {
    components: {
        InlineMessage,
    },
    data() {
        return {
            email: "",
            hasRequest: false,
        };
    },
    methods: {
        sendRequest() {
            const { email, o } = this;
            axios.post("/sendrequest", { email: email }).then(() => {
                this.hasRequest = true;
            });
        },
        checkApplication() {
            axios.post("/checkrequest", { email: email }).then(({ data }) => {
                this.hasRequest = data;
                // this.hasRequest = ;
            });
        },
    },
    mounted() {
        this.email = this.$route.query.email;
        this.checkApplication();
    },
};
</script>
