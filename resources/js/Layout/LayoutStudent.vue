<template lang="">
    <div class="fixed md:hidden top-0 left-0 z-40 w-64 h-screen" v-if="navOpen">
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200 shadow-sm"
        >
            <div class="flex items-center ps-2.5 mb-5 gap-2">
                <img
                    src="../../../public/mmsu_logo.png"
                    alt=""
                    class="w-10 h-10"
                />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"
                    >Student Portal</span
                >
            </div>
            <div v-if="navOpen" class="md:hidden">
                <button
                    class="text-gray-400 pb-5"
                    @click="this.navOpen = false"
                >
                    <a
                        href="#"
                        class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <i class="pi pi-times" style="font-size: 1rem"></i>
                        <span class="ms-3 text-sm">Back</span>
                    </a>
                </button>
            </div>
            <ul
                class="space-y-2 font-medium flex flex-col justify-between min-h-[500px] max-h-full"
            >
                <div class="space-y-4">
                    <li @click="this.navOpen = false">
                        <router-link to="/student/home">
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

                    <li @click="this.navOpen = false">
                        <router-link to="/student/mentors">
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

                    <li @click="this.navOpen = false">
                        <router-link to="/student/appointments">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-calendar"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Appointments</span>
                            </a>
                        </router-link>
                    </li>

                    <li @click="this.navOpen = false">
                        <router-link to="/student/chat">
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
                    <li @click="this.navOpen = false">
                        <router-link to="/student/studenttickets">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-ticket"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Ticket Log</span>
                            </a>
                        </router-link>
                    </li>
                </div>

                <li @click="logout">
                    <a
                        href="#"
                        class="flex items-center p-2 py-10 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
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
    </div>
    <!-- desktop -->
    <div class="md:fixed top-0 left-0 md:z-40 w-64 md:h-screen">
        <div
            class="hidden md:block h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200 shadow-sm"
        >
            <div class="flex items-center ps-2.5 mb-5 gap-2">
                <img
                    src="../../../public/mmsu_logo.png"
                    alt=""
                    class="w-10 h-10"
                />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"
                    >Student Portal</span
                >
            </div>

            <ul class="space-y-2 font-medium flex flex-col justify-between">
                <div class="pb-[300px] space-y-4">
                    <li>
                        <router-link to="/student/home">
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
                        <router-link to="/student/mentors">
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
                        <router-link to="/student/appointments">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-calendar"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Appointments</span>
                            </a>
                        </router-link>
                    </li>

                    <li>
                        <router-link to="/student/chat">
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
                    <li>
                        <router-link to="/student/studenttickets">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-ticket"
                                    style="font-size: 1rem"
                                ></i>
                                <span class="ms-3">Ticket Log</span>
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
    </div>

    <div
    v-if="!navOpen"
        class="sticky flex items-center justify-center top-0 z-40 bg-gray-50 shadow-sm py-2.5 md:hidden"
    >
        <button @click="this.navOpen = true" class="absolute left-0 ml-5">
            <i class="pi pi-list text-xl"></i>
        </button>
        <div class="">
            <img src="../../../public/mmsu_logo.png" alt="" class="w-10 h-10" />
        </div>
    </div>
    <div class="m-0 md:ml-[250px] bg-[#fdfdff]">
        <div class="min-h-screen md:flex flex-col md:px-20">
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
    </div>
</template>

<script>
export default {
    emits: ["appointment-access-data"],
    data() {
        return {
            appointmentAccess: {
                allowedToAppoint: null,
                ticketStatus: null,
                fieldToTake: null,
                userId: null,
            },
            navOpen: false,
            logohover: false,
        };
    },
    provide() {
        return {
            appointmentAccess: this.appointmentAccess,
        };
    },
    methods: {
        logout() {
            axios.post("/logout").then(() => {
                this.$router.push("/");
            });
        },
        popupEmail() {
            this.logohover = true;
            setTimeout(() => {
                this.logohover = false;
            }, 5000);
        },
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                if (!data.loggedIn) {
                    this.$router.push("/");
                }
            });
        },
        checkUserStatus() {
            axios.get("/checkuserstatus").then(({ data }) => {
                this.appointmentAccess.ticketStatus = data.ticketStatus;
                this.appointmentAccess.fieldToTake = data.fieldToTake;
                this.appointmentAccess.userId = data.userId;

                this.appointmentAccess.allowedToAppoint = data.allowToAppoint;
                this.$emit("appointment-access-data", this.appointmentAccess);
            });
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
        this.checkUserStatus();
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
