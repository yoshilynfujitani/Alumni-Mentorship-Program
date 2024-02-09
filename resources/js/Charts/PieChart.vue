<template>
    <!-- <div
        class="bg-white rounded-md flex justify-center items-center p-5 h-full shadow-sm border border-gray-200"
    >
        <Doughnut
            v-if="loaded"
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData"
        />
    </div> -->
    <div
        class="bg-white rounded-md flex justify-center items-center shadow-sm border border-gray-200 h-[400px]"
    >
        <Chart
            type="doughnut"
            :data="chartData"
            :options="chartOptions"
            class="w-[200px] h-[350px]"
        />
    </div>
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut } from "vue-chartjs";
import Chart from "primevue/chart";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "PieChart",
    components: { Doughnut, Chart },
    data() {
        return {
            loaded: false,
            chartData: null,
            chartOptions: {
                maintainAspectRatio: false,
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
