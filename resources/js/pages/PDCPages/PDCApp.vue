<template>
    <div class="py-10 self-start h-full w-full">
        <h1
            class="text-2xl font-bold w-full border rounded-md border-gray-200 p-2.5"
        >
            Dashboard
        </h1>
        <div class="dark:bg-gray-800 flex justify-between gap-5 my-5">
            <div class="w-full h-full"><Fields /></div>
            <div class="border rounded-md border-gray-100 p-2.5">
                <section class="grid gap-6 md:grid-cols-2 mx-auto w-full mb-5">
                    <div
                        class="p-6 bg-white shadow rounded-2xl dark:bg-gray-900"
                    >
                        <dl class="space-y-2">
                            <dt
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >
                                Total Requests
                            </dt>

                            <dd
                                class="text-5xl font-light md:text-6xl dark:text-white"
                            >
                                192.1k
                            </dd>

                            <dd
                                class="flex items-center space-x-1 text-sm font-medium text-green-500 dark:text-green-400"
                            >
                                <span>32k increase</span>

                                <svg
                                    class="w-7 h-7"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17.25 15.25V6.75H8.75"
                                    ></path>
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17 7L6.75 17.25"
                                    ></path>
                                </svg>
                            </dd>
                        </dl>
                    </div>

                    <div
                        class="p-6 bg-white shadow rounded-2xl dark:bg-gray-900"
                    >
                        <dl class="space-y-2">
                            <dt
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >
                                Completion Rate
                            </dt>

                            <dd
                                class="text-5xl font-light md:text-6xl dark:text-white"
                            >
                                21%
                            </dd>

                            <dd
                                class="flex items-center space-x-1 text-sm font-medium text-red-500 dark:text-red-400"
                            >
                                <span>7% increase</span>

                                <svg
                                    class="w-7 h-7"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17.25 8.75V17.25H8.75"
                                    ></path>
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17 17L6.75 6.75"
                                    ></path>
                                </svg>
                            </dd>
                        </dl>
                    </div>
                    <div
                        class="p-6 bg-white shadow rounded-2xl dark:bg-gray-900"
                    >
                        <dl class="space-y-2">
                            <dt
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >
                                Rejection Rate
                            </dt>

                            <dd
                                class="text-5xl font-light md:text-6xl dark:text-white"
                            >
                                21%
                            </dd>

                            <dd
                                class="flex items-center space-x-1 text-sm font-medium text-red-500 dark:text-red-400"
                            >
                                <span>7% increase</span>

                                <svg
                                    class="w-7 h-7"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17.25 8.75V17.25H8.75"
                                    ></path>
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17 17L6.75 6.75"
                                    ></path>
                                </svg>
                            </dd>
                        </dl>
                    </div>

                    <div
                        class="p-6 bg-white shadow rounded-2xl dark:bg-gray-900"
                    >
                        <dl class="space-y-2">
                            <dt
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >
                                Average time on page
                            </dt>

                            <dd
                                class="text-5xl font-light md:text-6xl dark:text-white"
                            >
                                03:12
                            </dd>

                            <dd
                                class="flex items-center space-x-1 text-sm font-medium text-green-500 dark:text-green-400"
                            >
                                <span>3% increase</span>

                                <svg
                                    class="w-7 h-7"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17.25 15.25V6.75H8.75"
                                    ></path>
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17 7L6.75 17.25"
                                    ></path>
                                </svg>
                            </dd>
                        </dl>
                    </div>
                </section>
                <div class="border rounded-md border-gray-300">
                    <Chart
                        type="line"
                        :data="chartData"
                        :options="chartOptions"
                        class="min-h-[400px] w-[650px]"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Fields from "../../component/PDCComponents/Fields.vue";

import Chart from "primevue/chart";

export default {
    components: { Fields, Chart },
    data() {
        return {
            chartData: null,
            chartOptions: null,
        };
    },
    mounted() {
        this.chartData = this.setChartData();
        this.chartOptions = this.setChartOptions();
    },
    methods: {
        setChartData() {
            const documentStyle = getComputedStyle(document.documentElement);

            return {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                ],
                datasets: [
                    {
                        label: "Mentor Requests",
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: false,
                        borderColor:
                            documentStyle.getPropertyValue("--green-500"),
                        tension: 0.4,
                    },
                    {
                        label: "Student Requests",
                        data: [28, 48, 40, 19, 86, 27, 90],
                        fill: false,
                        borderColor:
                            documentStyle.getPropertyValue("--gray-500"),
                        tension: 0.4,
                    },
                ],
            };
        },
        setChartOptions() {
            const documentStyle = getComputedStyle(document.documentElement);
            const textColor = documentStyle.getPropertyValue("--text-color");
            const textColorSecondary = documentStyle.getPropertyValue(
                "--text-color-secondary"
            );
            const surfaceBorder =
                documentStyle.getPropertyValue("--surface-border");

            return {
                maintainAspectRatio: false,
                aspectRatio: 0.6,
                plugins: {
                    legend: {
                        labels: {
                            color: textColor,
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColorSecondary,
                        },
                        grid: {
                            color: surfaceBorder,
                        },
                    },
                    y: {
                        ticks: {
                            color: textColorSecondary,
                        },
                        grid: {
                            color: surfaceBorder,
                        },
                    },
                },
            };
        },
    },
};
</script>
