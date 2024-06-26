<template>
    <div class="my-10 w-full">
        <div class="border border-gray-200 rounded-md bg-white">
            <h1 class="text-2xl font-bold p-5">Schedule History</h1>
            <div
                class="flex items-center justify-center w-full"
                v-if="schedule.length === 0"
            >
                <Spinner />
            </div>
            <table
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                v-else
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="pl-6 py-2">
                            Available Day for Appointment
                        </th>
                        <th scope="col" class="text-center">Time Available</th>
                        <th scope="col" class="text-center">Effective Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(day, index) in schedule"
                        :key="index"
                        class="border-b border-gray-200"
                    >
                        <td class="px-6 py-4 font-medium w-fit">
                            <div class="flex gap-2">
                                <div
                                    class="px-2 py-1 text-lg border rounded-md font-semibold"
                                    v-for="dayOfWeek in daysOfTheWeek"
                                    :key="dayOfWeek.id"
                                    :class="{
                                        'border-blue-600 text-blue-600  ':
                                            day.days.includes(dayOfWeek.id),
                                        'border-red-200 text-red-500':
                                            !day.days.includes(dayOfWeek.id),
                                    }"
                                >
                                    {{ dayOfWeek.name }}
                                </div>
                            </div>
                        </td>
                        <td class="text-center px-[100px] py-4">
                            <span class="text-green-600">{{ day.start }}</span>
                            to
                            <span class="text-red-600">{{ day.end }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <h1 v-if="0 !== index">
                                {{
                                    moment(
                                        day.created_at,
                                        "YYYY-MM-DD HH:mm:ss"
                                    ).format("MMMM Do YYYY")
                                }}
                            </h1>
                            <h1 v-else class="text-green-600 font-semibold">
                                Active
                            </h1>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="my-5">
                <Pagination
                    @next="goToNextPage"
                    @back="goToPrevPage"
                    :total="this.pagination?.total"
                    :current_page="this.pagination?.current_page"
                    :last_page="this.pagination?.last_page"
                />
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import axios from "axios";
import Pagination from "../../utils/Pagination.vue";
import Spinner from "../../utils/Spinner.vue";

export default {
    components: {
        Pagination,
        Spinner,
    },
    data() {
        return {
            schedule: [],
            moment: moment,
            daysOfTheWeek: [
                { id: 1, name: "Sun" },
                { id: 2, name: "Mon" },
                { id: 3, name: "Tue" },
                { id: 4, name: "Wed" },
                { id: 5, name: "Thu" },
                { id: 6, name: "Fri" },
                { id: 7, name: "Sat" },
            ],
            pagination: null,
        };
    },
    methods: {
        getSchedule() {
            axios.post("/getAllSchedule").then(({ data }) => {
                console.log();
                this.pagination = data;
                this.schedule = data.data.map((number) => {
                    return {
                        days: Array.from(number.daysOfTheWeek.toString()).map(
                            Number
                        ),
                        created_at: number.created_at,
                        start: number.start,
                        end: number.end,
                    };
                });
            });
        },
        goToPrevPage() {
            if (this.pagination.current_page > 1) {
                const prevPage = this.pagination.current_page - 1;
                this.fetchRequests(prevPage);
            }
        },
        goToNextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                const nextPage = this.pagination.current_page + 1;
                this.fetchRequests(nextPage);
            }
        },
        fetchRequests(page) {
            axios.post(`/getAllSchedule?page=${page}`).then(({ data }) => {
                console.log(data);
                this.pagination = data;
                this.schedule = data.data.map((number) => {
                    return {
                        days: Array.from(number.daysOfTheWeek.toString()).map(
                            Number
                        ),
                        created_at: number.created_at,
                    };
                });
            });
        },
    },
    mounted() {
        this.getSchedule();
    },
};
</script>
