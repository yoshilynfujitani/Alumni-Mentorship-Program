<template lang="">
    <div class="self-start">
        <button
            @click="handleFilter('active')"
            type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        >
            Active Mentors
        </button>
        <button
            @click="handleFilter('pending')"
            type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        >
            Pending Mentors
        </button>
        <button
            @click="handleFilter('all')"
            type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
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
    <div v-if="isLoading">Loading...></div>

    <div
        class="self-start overflow-x-auto w-full shadow-md sm:rounded-lg"
        v-else
    >
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                    >
                        Instructor's Name
                    </th>
                    <th scope="col" class="px-6 py-3">Course</th>
                    <th
                        scope="col"
                        class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                    >
                        Field
                    </th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th
                        scope="col"
                        class="px-16 py-3 text-center"
                        v-if="
                            fetchMentorBy == 'all' || fetchMentorBy == 'pending'
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
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                    >
                        {{ Mentor.name }}
                    </th>
                    <td class="px-6 py-4">{{ Mentor.course }}</td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        {{ Mentor.field }}
                    </td>
                    <td class="px-6 py-4">{{ Mentor.statusName }}</td>
                    <td
                        class="px-6 py-4 text-center"
                        v-if="
                            fetchMentorBy == 'all' || fetchMentorBy == 'pending'
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
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import MentorCard from "../../component/MentorComponents/MentorCard.vue";

export default {
    components: {
        MentorCard,
    },
    data() {
        return {
            mentors: [],
            fetchMentorBy: "active",
            // ifPendingMentors: false,
            isLoading: false,
            isEdit: false,
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
    },
    mounted() {
        this.getMentors();
    },
};
</script>
<style lang=""></style>
