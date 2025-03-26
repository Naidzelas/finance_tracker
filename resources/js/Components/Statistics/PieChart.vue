<template>
    <div class="h-[30em]">
        <v-chart :option="chartOption" autoresize />
    </div>
</template>

<script setup>
import { inject, computed } from "vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart } from "echarts/charts";
import {
    TooltipComponent,
    LegendComponent,
} from "echarts/components";
import VChart from "vue-echarts";

const budgetAllocation = inject("budgetAllocation") ?? [];

use([
    CanvasRenderer,
    PieChart,
    TooltipComponent,
    LegendComponent,
]);

// Chart options
const chartOption = computed(() => ({
    tooltip: {
        trigger: "item",
        formatter: "{b}: {c} ({d}%)"
    },
    legend: {
        orient: "horizontal",
        bottom: "0",
        type: "scroll",
        pageIconSize: 12,
        pageTextStyle: {
            color: "#888"
        }
    },
    series: [
        {
            name: "Budget Allocation",
            type: "pie",
            radius: "55%",
            center: ["50%", "45%"],
            data: budgetAllocation,
            label: {
                show: true,
                formatter: "{b}: {d}%"
            },
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: "rgba(0, 0, 0, 0.5)"
                }
            }
        }
    ]
}));
</script>
