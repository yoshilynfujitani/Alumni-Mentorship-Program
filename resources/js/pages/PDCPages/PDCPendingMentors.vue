<template>
    <LayoutPDC>
        <div
            class="self-start overflow-x-auto w-full min-h-full shadow-md sm:rounded-lg"
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
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th
                            scope="col"
                            class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                        >
                            College
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Others
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
                        <td class="px-6 py-4">{{ Mentor.email }}</td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                            {{ Mentor.course }}
                        </td>
                        <td class="flex justify-center">
                            <button>Verify</button>
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
            /></div
    ></LayoutPDC>
</template>
<script>
export default {
    data() {
        return {
            mentors: null,
        };
    },
    methods: {
        getApplications() {
            axios
                .get("/getmentorapplications")
                .then(({ data }) => {
                    this.mentors = data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        verify(statusId, mentorId) {
            axios
                .post("/editmentorstatus", { statusId, mentorId })
                .then(({ data }) => {})
                .catch((error) => {
                    console.error("Error verifying mentor status:", error);
                });
        },
    },

    mounted() {
        this.getApplications();
    },
};
</script>
