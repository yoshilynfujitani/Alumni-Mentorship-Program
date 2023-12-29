<template>
    <div class="bg-gray-100/40 rounded-md p-5 flex justify-center shadow-md">
        <Pie
            v-if="loaded"
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData"
        />
    </div>
</template>

<script>
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "BarChart",
    components: { Pie },
    data() {
        return {
            loaded: false,
            chartData: null,
            chartOptions: {
                responsive: true,
            },
        };
    },
    methods: {
        fetchChartData() {
            axios
                .get("/getchartdata")
                .then((response) => {
                    this.chartData = response.data.chartData;
                    console.log(response);
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
