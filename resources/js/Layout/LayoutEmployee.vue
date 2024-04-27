<template lang="">
    <aside class="fixed top-0 left-0 z-40 w-64 h-screen">
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800"
        >
            <div class="flex items-center ps-2.5 mb-5 gap-2">
                <img
                    src="../../../public/mmsu_logo.png"
                    alt=""
                    class="w-10 h-10"
                />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"
                    >PDC Portal</span
                >
            </div>
            <ul class="space-y-2 font-medium flex flex-col justify-between">
                <div class="space-y-4">
                    <li>
                        <router-link to="/pdchome">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-chart-pie"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Dashboard</span>
                            </a>
                        </router-link>
                    </li>

                    <li>
                        <router-link to="/pdcmentors">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-users"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Mentors</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/alumniinvite">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-megaphone"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Invite Alumni</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/pdcstudenttickets">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-ticket"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Student Requests</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/pendingmentors">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-ticket"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Mentor Requests</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/allconvo">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-send"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Conversations</span>
                            </a>
                        </router-link>
                    </li>
                </div>

                <li @click="logout">
                    <a
                        href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 18 16"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                            />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"
                            >Logout</span
                        >
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <div class="ml-[300px] mx-10">
        <div class="flex flex-col items-center min-h-screen">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    methods: {
        logout() {
            axios.post("/logout").then(() => {
                this.$router.push("/");
            });
        },
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                if (!data) {
                    this.$router.push("/");
                }
            });
        },
    },
    mounted() {
        this.checkAuth();
    },
};
</script>
