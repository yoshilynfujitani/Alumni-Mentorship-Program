<template lang="">
    <LayoutPDC>
        <input type="text" v-model="searchQuery" />
        <button @click="findUser">Search</button>
        <div class="self-start space-x-2">
            <button
                @click="handleFilter('active')"
                :class="{
                    'bg-green-700 text-white': fetchMentorBy === 'active',
                    'bg-white text-green-700 border':
                        fetchMentorBy !== 'active',
                }"
                type="button"
                class="focus:outline-none hover:bg-green-200 px-4 py-2 rounded-md"
            >
                Active Mentors
            </button>
            <button
                @click="handleFilter('pending')"
                :class="{
                    'bg-green-700 text-white': fetchMentorBy === 'pending',
                    'bg-white text-green-700 border':
                        fetchMentorBy !== 'pending',
                }"
                type="button"
                class="transition-all focus:outline-none hover:bg-green-200 px-4 py-2 rounded-md"
            >
                Pending Mentors
            </button>
            <button
                @click="handleFilter('all')"
                :class="{
                    'bg-green-700 text-white': fetchMentorBy === 'all',
                    'bg-white text-green-700 border': fetchMentorBy !== 'all',
                }"
                type="button"
                class="focus:outline-none hover:bg-green-200 px-4 py-2 rounded-md"
            >
                All Mentors
            </button>

            <h1>Mentors</h1>
        </div>

        <!-- <div class="grid grid-cols-4 gap-5 mx-auto my-10">
            <div class="mx-auto" v-for="Mentor in mentors">
                <MentorCard :MentorDetails="Mentor" />
            </div>

        </div> -->
        <div v-if="isLoading">
            <UnSpinnerAlt class="animate-spin text-green-500" />
        </div>

        <div
            class="self-start overflow-x-auto w-full min-h-full shadow-md sm:rounded-lg"
            v-else
        >
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase dark:text-gray-400"
                >
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            Instructor's Name
                        </th>
                        <th scope="col" class="px-6 py-3">College</th>
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            Field
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Status
                        </th>
                        <th
                            v-if="fetchMentorBy == 'active'"
                            scope="col"
                            class="px-6 py-3 text-center"
                        >
                            Appoint
                        </th>
                        <th
                            scope="col"
                            class="px-16 py-3 text-center"
                            v-if="
                                fetchMentorBy == 'all' ||
                                fetchMentorBy == 'pending'
                            "
                        >
                            Edit
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="Mentor in mentors"
                        :key="Mentor.id"
                        class="border-b border-gray-200 dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="flex items-center gap-2 px-6 py-7 h-full font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800"
                        >
                            <img
                                class="w-7 h-7 rounded-full"
                                src="../../../../public/DefaultAvatar.webp"
                                alt="Avatar"
                            />{{ Mentor.name }}
                        </th>
                        <td class="px-6 py-4">{{ Mentor.course }}</td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                            {{ Mentor.fieldName }}
                        </td>
                        <td class="px-6 py-4 flex justify-center">
                            <h1
                                v-if="Mentor.verified === 0"
                                class="text-white font-bold bg-yellow-400 py-2 px-4 rounded-md w-fit"
                            >
                                {{ Mentor.statusName }}
                            </h1>
                            <h1
                                v-if="Mentor.verified === 1"
                                class="text-white font-bold bg-green-400 py-2 px-4 rounded-md w-fit"
                            >
                                {{ Mentor.statusName }}
                            </h1>
                            <h1
                                v-if="Mentor.verified === 2"
                                class="text-white font-bold bg-red-400 py-2 px-4 rounded-md w-fit text-center"
                            >
                                {{ Mentor.statusName }}
                            </h1>
                        </td>
                        <td
                            class="px-6 py-4 text-center"
                            v-if="
                                fetchMentorBy == 'all' ||
                                fetchMentorBy == 'pending'
                            "
                        >
                            <button
                                @click="updateStatus(Mentor)"
                                v-if="!Mentor.isEdit"
                            >
                                <svg
                                    class="w-3 h-3 text-gray-800 dark:text-white"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 16 3"
                                >
                                    <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
                                    />
                                </svg>
                            </button>
                            <div class="space-x-5" v-if="Mentor.isEdit">
                                <button @click="updateStatus(Mentor)">
                                    <svg
                                        class="w-3 h-3 text-gray-800 dark:text-white hover:text-gray-400"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 8 14"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"
                                        />
                                    </svg>
                                </button>
                                <button @click="verify(2, Mentor.id)">
                                    <svg
                                        class="w-3 h-3 text-gray-800 dark:text-white hover:text-red-500"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 14 14"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                        />
                                    </svg>
                                </button>
                                <button @click="verify(1, Mentor.id)">
                                    <svg
                                        class="w-3 h-3 text-gray-800 dark:text-white hover:text-green-600"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 16 12"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5.917 5.724 10.5 15 1.5"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="text-center">
                            <AppointmentForm
                                :MentorDetails="Mentor"
                                type="pdc"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </LayoutPDC>
</template>
<script>
import MentorCard from "../../component/MentorComponents/MentorCard.vue";
import { UnSpinnerAlt } from "@kalimahapps/vue-icons";
import AppointmentForm from "../../component/StudentComponents/AppointmentForm.vue";
import Modal from "../../component/Modal.vue";

export default {
    components: {
        MentorCard,
        UnSpinnerAlt,
        AppointmentForm,
    },
    data() {
        return {
            mentors: [],
            fetchMentorBy: "active",
            // ifPendingMentors: false,
            isLoading: false,
            isEdit: false,
            searchQuery: "",
        };
    },
    methods: {
        handleFilter(filter) {
            (this.fetchMentorBy = filter), this.getMentors();
        },
        getMentors() {
            this.isLoading = true;
            const { fetchMentorBy } = this;
            axios.post("/getmentorAPI", { fetchMentorBy }).then(({ data }) => {
                console.log(data);

                this.mentors = data;
                this.isLoading = false;
            });
        },
        updateStatus(mentor) {
            mentor.isEdit = !mentor.isEdit;
        },
        verify(statusId, mentorId) {
            axios
                .post("/editmentorstatus", { statusId, mentorId })
                .then(({ data }) => {
                    console.log(data);
                    this.getMentors();
                });
        },
        findUser() {
            const { searchQuery } = this;
            axios.post("/searchuser", { searchQuery }).then(({ data }) => {
                console.log(data);
            });
        },
    },
    mounted() {
        this.getMentors();
    },
};
</script>
<style lang=""></style>
