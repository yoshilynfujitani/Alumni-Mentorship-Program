<template lang="">
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
    >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>

    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar"
    >
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
                    >Mentor Portal</span
                >
            </div>
            <ul class="space-y-2 font-medium flex flex-col justify-between">
                <div class="pb-[350px] space-y-4">
                    <li>
                        <router-link to="/mentor/home">
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
                        <router-link to="/mentor/studentrequests">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-briefcase"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Appointments</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/mentor/chat">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-send"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Conversation</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/mentor/schedule">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-book"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Schedule History</span>
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
    <div class="ml-[250px] bg-[#fdfdff]">
        <div class="flex flex-col items-center min-h-screen px-5 md:px-20">
            <router-view></router-view>
            <a href="https://www.google.com/" target="_blank">
                <div
                    class="rounded-full bottom-0 right-0 fixed m-5"
                    @mouseover="logohover = true"
                    @mouseleave="logohover = false"
                >
                    <div class="flex items-center gap-2.5">
                        <Transition>
                            <div
                                v-if="logohover"
                                class="py-2 px-2 bg-green-50 rounded-full border-2 border-green-400 text-sm text-green-600 flex items-center gap-1.5"
                            >
                                <i class="pi pi-envelope"></i>Have questions?
                                Email Us!
                            </div>
                        </Transition>
                        <img
                            src="../../../public/mmsu_logo.png"
                            alt=""
                            class="w-12 h-12 transition-all hover:cursor-pointer hover:scale-125"
                        />
                    </div>
                </div>
            </a>
        </div>
        <div class="bg-green-400 px-10">footer</div>
    </div>
</template>

<script>
export default {
    emits: ["userStatus"],
    data() {
        return {
            logohover: false,
        };
    },
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
                } else {
                    // this.$emit("userStatus", {
                    //     userName: data.userName,
                    //     userId: data.userId,
                    // });
                }
            });
        },
        popupEmail() {
            this.logohover = true;
            setTimeout(() => {
                this.logohover = false;
            }, 2000);
        },
        updateLastActive() {
            axios
                .get("user/update-last-active")
                .then((response) => {
                    console.log("Last active timestamp updated.");
                })
                .catch((error) => {
                    console.error(
                        "Error updating last active timestamp:",
                        error
                    );
                });
        },
        startHeartbeat() {
            setInterval(() => {
                axios.get("/checkUser").then(({ data }) => {
                    if (data.loggedIn) {
                        this.updateLastActive();
                    }
                });
            }, 60000); // every minute
        },
    },
    mounted() {
        this.checkAuth();
        this.popupEmail();
        axios.get("/checkUser").then(({ data }) => {
            if (data.loggedIn) {
                this.updateLastActive();
                this.startHeartbeat();
            }
        });
    },
};
</script>
<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
