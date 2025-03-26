<template>
    <div class="h-[30em]">
        <v-chart :option="chartOption" autoresize />
    </div>
</template>

<script setup>
import { inject, computed } from "vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { LineChart } from "echarts/charts";
import {
    GridComponent,
    TooltipComponent,
    LegendComponent,
} from "echarts/components";
import VChart from "vue-echarts";

const chartData = inject("chartData") ?? { period: [], yAxis: [] };
const budgetTypes = inject("budgetTypes") ?? [];

function getBudgetTypeById(id) {
    const type = budgetTypes.find(type => type.id === parseInt(id));
    return type ? type.name : `Type ${id}`;
}

use([
    CanvasRenderer,
    LineChart,
    GridComponent,
    TooltipComponent,
    LegendComponent,
]);


const series = computed(() => {
    const result = [];
    
    if (chartData.yAxis) {
        result.push({
            type: "line",
            name: "Value",
            data: chartData.yAxis,
        });
    } else {
        Object.keys(chartData).forEach(key => {
            if (key !== 'period' && chartData[key]?.yAxis) {
                result.push({
                    type: "line",
                    name: getBudgetTypeById(key),
                    data: chartData[key].yAxis,
                });
            }
        });
    }
    
    return result;
});

const chartOption = computed(() => ({
    legend: {
        show: true,
        top: 10,
    },
    tooltip: {
        trigger: 'axis',
        formatter: function(params) {
            let result = params[0].data[0] + '<br/>';
            params.forEach(param => {
                result += param.seriesName + ': ' + param.data[1] + '<br/>';
            });
            return result;
        }
    },
    xAxis: {
        type: "category",
        data: chartData.period,
    },
    yAxis: {
        type: "value",
    },
    series: series.value,
}));
</script>
