<template>
    <div class="py-10 self-start h-full w-full">
        <h1
            class="text-2xl font-bold w-full border rounded-md border-gray-200 p-2.5 bg-white"
        >
            Dashboard
        </h1>
        <div class="dark:bg-gray-800 flex justify-between gap-5 my-5">
            <div class="w-3/4 h-full"><Fields /></div>
            <div class="w-1/4"><PieChart /></div>
        </div>
    </div>
</template>

<script>
import PieChart from "../../Charts/PieChart.vue";
import Fields from "../../component/PDCComponents/Fields.vue";

export default {
    components: { Fields, PieChart },
    data() {
        return {};
    },
    mounted() {},
    methods: {},
};
</script>
