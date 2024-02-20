<template lang="">
    <div class="fixed top-0 left-0 z-40 w-64 h-screen">
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
            <ul class="space-y-2 font-medium flex flex-col justify-between">
                <div class="pb-[300px] space-y-4">
                    <li>
                        <router-link to="/home">
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
                        <router-link to="/mentors">
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
                        <router-link to="/appointments">
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
                        <router-link to="/chat">
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
                        <router-link to="/studenttickets">
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
    <div class="ml-[250px] bg-[#fdfdff]">
        <div
            class="flex flex-col items-center min-h-screen px-10 laptop:mx-[50px] desktop:mx-[150px]"
        >
            <slot />
        </div>
        <div class="bg-green-400 px-10">footer</div>
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
    },
    mounted() {
        this.checkAuth();
        this.checkUserStatus();
    },
};
</script>
