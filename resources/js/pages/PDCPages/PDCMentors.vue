<template>
    <Toast />
    <div class="self-start pt-10">
        <div class="self-start">
            <h1 class="flex items-center text-2xl gap-1 font-bold">
                <i class="pi pi-users text-2xl text-yellow-400"></i>
                <span class="">Mentors</span>
            </h1>
        </div>
        <div class="mb-5 flex space-x-2">
            <div class="">
                <span class="text-sm font-medium text-green-600"
                    >Search Mentors By</span
                >
                <Dropdown
                    v-model="fetchMentorBy"
                    :options="this.mentorStatus"
                    optionLabel="name"
                    placeholder="Sort by Status"
                    class="w-full md:w-14rem border-gray-200 border focus:border-2 focus:border-green-500"
                    @change="handleFilterChange"
                />
            </div>

            <div class="self-end">
                <input
                    class="rounded-md border-gray-200 h-fit"
                    placeholder="Search Mentor"
                    v-model="mentorQuery"
                />
                <button
                    @click="searchMentor"
                    class="text-white bg-green-600 px-3 py-2 rounded-md ml-2 h-fit"
                >
                    <i class="pi pi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div v-if="isLoading">Loading...</div>

    <div
        class="self-start mb-20 overflow-x-auto w-full min-h-full shadow-md sm:rounded-lg"
        v-else
    >
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase dark:text-gray-400 border-b border-gray-200"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Instructor's Name</th>
                    <th scope="col" class="px-6 py-3">College</th>
                    <th scope="col" class="px-6 py-3">Field</th>
                    <th scope="col" class="px-6 py-3 text-center">Others</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="Mentor in mentors"
                    :key="Mentor.id"
                    class="border-gray-100 dark:border-gray-700 border-b"
                >
                    <th
                        scope="row"
                        class="flex items-center gap-2 px-6 py-7 h-full font-medium text-gray-900"
                    >
                        <img
                            class="w-7 h-7 rounded-full"
                            src="../../../../public/DefaultAvatar.webp"
                            alt="Avatar"
                        />{{ Mentor.name }}
                    </th>
                    <td class="px-6 py-4">{{ Mentor.course }}</td>
                    <td class="px-6 py-4">
                        {{ Mentor.fieldName }}
                    </td>
                    <td
                        class="px-6 py-4 flex justify-center"
                        v-if="fetchMentorBy.id == 2"
                    >
                        <button
                            @click="openDialog(Mentor)"
                            class="bg-blue-400 text-white px-2 py-1 rounded-md flex items-center justify-center"
                        >
                            <i class="pi pi-eye"></i>
                        </button>
                        <Dialog
                            v-model:visible="Mentor.visible"
                            modal
                            :header="Mentor.name + '\'s Profile'"
                            @hide="onDialogClose"
                        >
                            <div
                                class="flex gap-5 border border-gray-100 rounded p-2"
                            >
                                <img
                                    class="w-24 h-24 mb-3 rounded-full shadow-lg"
                                    src="../../../../public/DefaultAvatar.webp"
                                    alt="Avatar"
                                />
                                <div class="">
                                    <label
                                        for=""
                                        class="text-sm text-green-700 font-medium"
                                        >Mentor's Field</label
                                    >
                                    <h1>{{ Mentor.fieldName }}</h1>

                                    <label
                                        for=""
                                        class="text-sm text-green-700 font-medium"
                                        >Mentor's Rating</label
                                    >
                                    <div class="" v-if="!Mentor.rating">
                                        <h1
                                            class="text-xs my-1 italic text-gray-400"
                                        >
                                            Mentor has no ratings
                                        </h1>
                                    </div>
                                    <div class="" v-else>
                                        {{ Mentor.rating }}

                                        <i
                                            class="pi pi-star-fill text-sm text-yellow-400"
                                        ></i>
                                        <span class="text-gray-400 text-sm">
                                            ({{ Mentor.feedBackCount }})
                                            reviews</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="pb-5 flex flex-col">
                                <h1
                                    class="text-green-700 text-sm font-medium py-2.5 flex items-center gap-1"
                                >
                                    <i class="pi pi-calendar"></i> Available Day
                                    for Appointments
                                </h1>
                                <div
                                    class="flex space-x-2.5 border-gray-200 text-gray-200"
                                >
                                    <div
                                        class="border px-2 py-1 rounded-md"
                                        v-for="day in daysOfTheWeek"
                                        :class="{
                                            'border-blue-600 border-2 text-blue-600':
                                                isActiveDay(day.id),
                                        }"
                                    >
                                        <p class="font-semibold">
                                            {{ day.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <h1 class="text-green-700 font-medium">
                                    <i class="pi pi-megaphone"></i> Most Recent
                                    Feedbacks
                                </h1>
                                <div
                                    class="text-center text-gray-400 py-20"
                                    v-if="recentFeedbacks?.length === 0"
                                >
                                    <i
                                        class="pi pi-ban text-sm text-gray-400"
                                    ></i>
                                    No Info to show
                                </div>
                                <div
                                    class="border border-gray-200 my-2 rounded-md p-2.5"
                                    :key="feedback.id"
                                    v-for="feedback in recentFeedbacks"
                                    v-else
                                >
                                    <h1 class="text-gray-400 text-sm">
                                        Anonymous (<span
                                            >{{ feedback.rating }}
                                            <i
                                                class="pi pi-star-fill text-sm text-yellow-400"
                                            ></i></span
                                        >)
                                    </h1>
                                    <p>{{ feedback?.comments }}</p>
                                </div>
                            </div>
                        </Dialog>
                        <button
                            @click="openSchedule(Mentor)"
                            class="bg-green-600 text-white font-semibold px-2 py-1 rounded-md ml-2"
                        >
                            Schedule
                        </button>
                        <Dialog
                            v-model:visible="Mentor.schedVisible"
                            modal
                            :header="Mentor.name + '\'s Schedule History'"
                            @hide="onDialogClose"
                        >
                            <div
                                v-if="schedule?.length === 0"
                                class="text-center"
                            >
                                No schedule available
                            </div>
                            <div class="" v-else>
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr class="">
                                        <th scope="col" class="pl-6 py-2">
                                            Available Day for Appointment
                                        </th>
                                        <th scope="col" class="text-center">
                                            Effective Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(day, index) in schedule"
                                        :key="index"
                                        class="border-b border-gray-200 dark:border-gray-700"
                                    >
                                        <td
                                            v-if="this.schedule"
                                            class="px-6 py-4 font-medium whitespace-nowrap"
                                        >
                                            <div class="flex gap-2">
                                                <div
                                                    class="px-2 py-1 text-lg border rounded-md font-semibold"
                                                    v-for="dayOfWeek in daysOfTheWeek"
                                                    :key="dayOfWeek.id"
                                                    :class="{
                                                        'border-blue-600 text-blue-600  ':
                                                            day.days.includes(
                                                                dayOfWeek.id
                                                            ),
                                                        'border-red-200 text-red-500':
                                                            !day.days.includes(
                                                                dayOfWeek.id
                                                            ),
                                                    }"
                                                >
                                                    {{ dayOfWeek.name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center text-sm"
                                        >
                                            {{
                                                moment(
                                                    day.created_at,
                                                    "YYYY-MM-DD HH:mm:ss"
                                                ).format("MMMM Do YYYY")
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                                <div class="my-5">
                                    <Pagination
                                        @next="goToNextPageSched"
                                        @back="goToPrevPageSched"
                                        :total="this.paginationSched?.total"
                                        :current_page="
                                            this.paginationSched?.current_page
                                        "
                                        :last_page="
                                            this.paginationSched?.last_page
                                        "
                                    />
                                </div>
                            </div>
                        </Dialog>
                    </td>
                    <td
                        class="px-6 py-4 text-center"
                        v-if="fetchMentorBy?.id === 1"
                    >
                        <ConfirmPopup></ConfirmPopup>
                        <div class="flex gap-2 justify-content-center">
                            <button
                                @click="AcceptRequest($event, 1, Mentor.id)"
                                class="px-2 py-1 bg-green-400 text-white rounded font-medium"
                            >
                                Approve
                            </button>
                            <button
                                @click="RejectRequest($event, 2, Mentor.id)"
                                class="px-2 py-1 bg-red-400 text-white rounded font-medium"
                            >
                                Reject
                            </button>
                        </div>
                    </td>
                    <td class="text-center" v-if="fetchMentorBy?.id === 0">
                        <AppointmentForm
                            :MentorDetails="Mentor"
                            type="pdc"
                            @sent="runToast"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination
            @next="goToNextPage"
            @back="goToPrevPage"
            :total="this.pagination?.total"
            :current_page="this.pagination?.current_page"
            :last_page="this.pagination?.last_page"
        />
    </div>
</template>
<script>
import MentorCard from "../../component/MentorComponents/MentorCard.vue";

import AppointmentForm from "../../component/StudentComponents/AppointmentForm.vue";
import Pagination from "../../utils/Pagination.vue";
import Dropdown from "primevue/dropdown";
import ConfirmPopup from "primevue/confirmpopup";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import moment from "moment";
import Toast from "primevue/toast";

export default {
    components: {
        MentorCard,

        AppointmentForm,
        Pagination,
        Dropdown,
        ConfirmPopup,
        Button,
        Dialog,
        Toast,
    },
    data() {
        return {
            mentors: [],
            pagination: {},
            fetchMentorBy: { id: 2, name: "All" },
            mentorStatus: [
                { id: 2, name: "All" },
                { id: 0, name: "Active" },
            ],
            daysOfTheWeek: [
                { id: 1, name: "Sun" },
                { id: 2, name: "Mon" },
                { id: 3, name: "Tue" },
                { id: 4, name: "Wed" },
                { id: 5, name: "Thu" },
                { id: 6, name: "Fri" },
                { id: 7, name: "Sat" },
            ],
            isLoading: false,
            activeAvailableDays: [],
            recentFeedbacks: [],
            schedule: [],
            paginationSched: {},
            moment,
            currentId: null,
            mentorQuery: null,
        };
    },
    methods: {
        onDialogClose() {
            this.activeAvailableDays = null;
            this.schedule = null;
            this.paginationSched = null;
        },
        isActiveDay(dayId) {
            return this.activeAvailableDays?.includes(dayId);
        },
        openDialog(mentor) {
            this.closeAllDialogs();
            mentor.visible = true;
            this.currentId = mentor.id;
            this.getRecentFeedbacks();
            this.getLatestSchedule();
        },
        openSchedule(mentor) {
            this.closeAllDialogs();
            mentor.schedVisible = true;
            this.currentId = mentor.id;
            this.getSchedule();
        },
        closeAllDialogs() {
            this.mentors.forEach((mentor) => {
                mentor.visible = false;
                mentor.schedVisible = false; // Close all dialogs
            });
        },
        getRecentFeedbacks() {
            axios
                .post("/getrecentfeedback", { mentorId: this.currentId })
                .then(({ data }) => {
                    this.recentFeedbacks = data;
                })
                .catch((error) => {
                    console.error("Error fetching recent feedback:", error);
                });
        },
        searchMentor() {
            let { mentorQuery } = this;
            axios
                .post("/searchMentor", { mentorQuery: mentorQuery })
                .then(({ data }) => {
                    this.mentors = data.data;
                    console.log(data.data);
                    this.pagination = data.pagination;
                });
        },
        getLatestSchedule() {
            axios
                .post("/getLatestSchedule", { mentorId: this.currentId })
                .then(({ data }) => {
                    this.activeAvailableDays = data.map((day) =>
                        parseInt(day, 10)
                    );
                })
                .catch((error) => {
                    console.error("Error fetching latest schedule:", error);
                });
        },
        handleFilterChange() {
            this.getMentors();
        },
        getMentors() {
            this.isLoading = true;
            const searchBy = this.fetchMentorBy ? this.fetchMentorBy.id : 2;

            axios
                .post(`/getmentorAPI`, { searchBy })
                .then(({ data }) => {
                    this.mentors = data.data;
                    this.pagination = data;
                })
                .catch((error) => {
                    console.error("Error fetching mentors:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        verify(statusId, mentorId) {
            axios
                .post("/editmentorstatus", { statusId, mentorId })
                .then(({ data }) => {
                    console.log(data);
                    this.getMentors();
                })
                .catch((error) => {
                    console.error("Error verifying mentor status:", error);
                });
        },
        AcceptRequest(event, statusId, mentorId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to approve this request?",
                icon: "pi pi-exclamation-triangle text-red-400",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-sm text-white bg-green-400 px-2 py-1 ml-2",
                rejectLabel: "Cancel",
                acceptLabel: "Approve",
                accept: () => {
                    this.verify(statusId, mentorId);
                },
            });
        },
        RejectRequest(event, statusId, mentorId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: "Are you sure you want to reject this request?",
                icon: "pi pi-exclamation-triangle text-red-400",
                rejectClass: "p-button-secondary p-button-outlined p-button-sm",
                acceptClass:
                    "p-button-danger p-button-sm bg-red-400 px-2 py-1 ml-2 text-white",
                rejectLabel: "Cancel",
                acceptLabel: "Reject",
                accept: () => {
                    this.verify(statusId, mentorId);
                },
            });
        },
        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                const prevPage = this.pagination.current_page - 1;
                this.fetchMentors(prevPage);
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                const nextPage = this.pagination.current_page + 1;
                this.fetchMentors(nextPage);
            }
        },
        fetchMentors(page) {
            this.isLoading = true;
            const searchBy = this.fetchMentorBy ? this.fetchMentorBy.id : 2;

            axios
                .post(`/getmentorAPI?page=${page}`, { searchBy })
                .then(({ data }) => {
                    this.mentors = data.data;
                    this.pagination = data;
                })
                .catch((error) => {
                    console.error("Error fetching mentors:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        runToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Appointment",
                detail: "Your appointment was sent successfully!",
                life: 3000,
            });
        },
        getSchedule() {
            axios
                .post("/getAllSchedule", { mentorId: this.currentId })
                .then(({ data }) => {
                    this.paginationSched = data;
                    this.schedule = data.data.map((number) => {
                        return {
                            days: Array.from(
                                number.daysOfTheWeek.toString()
                            ).map(Number),
                            created_at: number.created_at,
                        };
                    });
                })
                .catch((error) => {
                    console.error("Error fetching schedule:", error);
                });
        },
        goToPrevPageSched() {
            if (this.paginationSched.current_page > 1) {
                const prevPage = this.paginationSched.current_page - 1;
                this.fetchRequestsSched(prevPage);
            }
        },
        goToNextPageSched() {
            if (
                this.paginationSched.current_page <
                this.paginationSched.last_page
            ) {
                const nextPage = this.paginationSched.current_page + 1;
                this.fetchRequestsSched(nextPage);
            }
        },
        fetchRequestsSched(page) {
            axios
                .post(`/getAllSchedule?page=${page}`, {
                    mentorId: this.currentId,
                })
                .then(({ data }) => {
                    this.paginationSched = data;
                    this.schedule = data.data.map((number) => {
                        return {
                            days: Array.from(
                                number.daysOfTheWeek.toString()
                            ).map(Number),
                            created_at: number.created_at,
                        };
                    });
                })
                .catch((error) => {
                    console.error("Error fetching schedule:", error);
                });
        },
    },
    mounted() {
        this.getMentors();
    },
};
</script>

<style lang=""></style>
