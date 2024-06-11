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
                    src="../../../../public/mmsu_logo.png"
                    alt="logo"
                />
                Alumni Mentorship Program
            </a>
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                    >
                        Reset Password
                    </h1>

                    <form
                        class="space-y-4 md:space-y-6"
                        action="#"
                        @submit.prevent="sendRequest"
                    >
                        <InlineMessage
                            severity="error"
                            class="w-full"
                            v-if="passwordDontMatch"
                            >Passwords do not match!</InlineMessage
                        >
                        <div>
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Reset Password</label
                            >
                            <input
                                v-model="password"
                                placeholder="••••••••"
                                type="password"
                                name="password"
                                id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                        <div>
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Confirm Password</label
                            >
                            <input
                                v-model="password2"
                                placeholder="••••••••"
                                type="password"
                                name="password2"
                                id="password2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Send Email
                        </button>
                    </form>
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
        return { password: "", password2: "", passwordDontMatch: false };
    },
    methods: {
        sendRequest() {
            const { email, password, password2 } = this;
            if (password !== password2) {
                return (this.passwordDontMatch = true);
            } else if (this.passwordDontMatch) {
                this.passwordDontMatch = false;
            }
            axios
                .post("/resetpassword", { email: email, password: password })
                .then(() => {
                    this.$router.push("/");
                });
        },
    },
    mounted() {
        this.email = this.$route.query.email;
    },
};
</script>
