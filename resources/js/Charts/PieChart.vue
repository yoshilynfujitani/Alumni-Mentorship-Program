<template>
    <div
        class="bg-gray-50 rounded-md flex justify-center items-center p-5 h-full shadow-md"
    >
        <Doughnut
            v-if="loaded"
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData"
        />
    </div>
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut } from "vue-chartjs";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "PieChart",
    components: { Doughnut },
    data() {
        return {
            loaded: false,
            chartData: null,
            chartOptions: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Your most frequent Field of Appointment`,
                    },
                },
            },
        };
    },
    methods: {
        fetchChartData() {
            axios
                .get("/getpiechartdata")
                .then((response) => {
                    this.chartData = response.data.chartData;

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
        this.fetchChartData();
    },
};
</script>
