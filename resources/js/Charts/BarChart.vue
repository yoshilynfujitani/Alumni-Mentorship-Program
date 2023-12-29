<template>
    <div
        class="bg-gray-100/40 rounded-md p-5 w-1/2 flex justify-center shadow-md"
    >
        <Bar :data="chartData" :options="chartOptions" />
    </div>
</template>

<script lang="ts">
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
    name: "App",
    components: {
        Bar,
    },
    data() {
        return {
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
                        data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
                    },
                ],
            },
            chartOptions: {
                responsive: true,
            },
        };
    },
};
</script>
