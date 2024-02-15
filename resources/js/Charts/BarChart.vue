<template>
    <div
        class="bg-white rounded-md h-[400px] p-5 w-full flex justify-center shadow-sm border border-gray-200"
    >
        <Bar :data="chartData" :options="chartOptions" v-if="loaded" />
    </div>
</template>

<script>
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import { Bar } from "vue-chartjs";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

export default {
    name: "BarChart",
    components: {
        Bar,
    },
    data() {
        return {
            loaded: false,
            chartData: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        label: "Number of Appointments",
                        backgroundColor: "#41B883",
                        data: [],
                    },
                ],
            },

            chartOptions: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        max: 10,
                        // Add min if needed
                        // min: 0,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: `Your number of appointment for the year ${new Date().getFullYear()}`,
                    },
                },
            },
        };
    },
    methods: {
        fetchChartData() {
            axios
                .get("/getbarchartdata")
                .then((response) => {
                    // Update the chart data with the fetched data
                    this.chartData.datasets[0].data = Object.values(
                        response.data
                    ).map((key) => parseInt(key, 10));

                    this.loaded = true;
                })
                .catch((error) => {
                    console.error("Error fetching chart data:", error);
                });
        },
    },
    created() {
        this.fetchChartData();
    },
    mounted() {
        // this.fetchChartData();
    },
};
</script>
