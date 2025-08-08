<template>
    <div class="bg-surface-50 dark:bg-surface-950 px-6 md:px-12 lg:px-12 py-8">
        <div>
            <div
                class="relative flex flex-col gap-4 bg-surface-0 dark:bg-surface-900 shadow-sm rounded-2xl w-full overflow-hidden"
            >
                <div class="flex flex-1 items-center gap-4 mb-8 p-4">
                    <div class="flex flex-1 items-center gap-2">
                        <div
                            class="flex justify-center items-center bg-primary-500 rounded-lg w-7 h-7"
                        >
                            <i class="text-white pi pi-wallet"></i>
                        </div>
                        <div
                            class="text-surface-900 dark:text-surface-100 text-sm leading-tight"
                        >
                            {{ $t("expenses.balance") }}
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-1 font-semibold text-surface-900 dark:text-surface-100 text-base leading-tight"
                    >
                        <span class="text-lg">2000</span
                        ><i class="pi pi-euro"></i>
                    </div>
                </div>
                <div class="bg-surface-50 dark:bg-surface-950">
                    <div class="bg-surface-0 dark:bg-surface-900 shadow-sm p-6">
                        <ul class="flex flex-col gap-6 m-0 p-0 list-none">
                            <li>
                                <div
                                    class="bg-surface-50 dark:bg-surface-800 p-6 border-2 border-surface border-dashed rounded-2xl"
                                >
                                    Category spent most
                                </div>
                            </li>
                            <Divider class="my-0!" />
                            <li>
                                <div
                                    class="bg-surface-50 dark:bg-surface-800 p-6 border-2 border-surface border-dashed rounded-2xl"
                                ></div>
                            </li>
                            <Divider class="my-0!" />
                            <li>
                                <div
                                    class="bg-surface-50 dark:bg-surface-800 p-6 border-2 border-surface border-dashed rounded-2xl"
                                />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- stats -->
        </div>
    </div>
</template>
<script setup>
import { Divider } from "primevue";
import Chart from "primevue/chart";
import { ref } from "vue";

const chartData = {
    labels: ["January", "February", "March", "April", "May", "June"],
    datasets: [
        {
            label: "Current Expenses",
            data: [400, 450, 300, 500, 600, 700],
            fill: true,
            borderColor: "var(--p-primary-500)",
        },
        {
            label: "Previous Expenses",
            data: [300, 400, 350, 450, 500, 600],
            fill: true,
            borderColor: "var(--p-secondary-500)",
        },
    ],
};

const chartOptions = {
    responsive: true,
    plugins: {
        legend: {
            position: "top",
        },
        tooltip: {
            callbacks: {
                label: (context) => {
                    let label = context.dataset.label || "";
                    if (label) {
                        label += ": ";
                    }
                    label +=
                        context.parsed.y !== null
                            ? `${context.parsed.y} BTC`
                            : "";
                    return label;
                },
            },
        },
    },
};
</script>
