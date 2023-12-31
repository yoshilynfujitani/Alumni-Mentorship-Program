<template>
    <div
        class="bg-gray-100/40 rounded-md p-5 w-1/2 flex justify-center shadow-md"
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
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
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
                responsive: true,
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
