<template>
    <div class="dark:bg-surface-950 px-6 md:px-12 lg:px-20 py-8">
        <div
            class="flex flex-col gap-8 bg-surface-0 dark:bg-surface-900 shadow-lg mx-auto p-8 rounded-2xl max-w-4xl"
        >
          <div class="flex items-center gap-4">
                <div
                    class="flex justify-center items-center bg-cyan-500 dark:bg-cyan-600 rounded-full w-8 h-8"
                >
                    <i
                        class="text-surface-0 !text-base !leading-none pi pi-calculator"
                    />
                </div>

                <div class="flex flex-col gap-1">
                    <span
                        class="text-md text-surface-900 dark:text-surface-0 text-xl leading-tight"
                        >{{ $t("user.budget") }}</span
                    >
                    <span
                        class="text-surface-600 dark:text-surface-200 text-sm leading-tight"
                        >{{ $t("user.budget_sub_text") }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <span
                        class="font-semibold text-surface-900 dark:text-surface-0 text-4xl leading-tight"
                        >{{ getPercent(user.income, budgetSum) }}%</span
                    >
                    <span
                        class="text-surface-700 dark:text-surface-300 leading-tight"
                    >
                        {{ budgetSum }}/ {{ user.income }}</span
                    >
                </div>

                <MeterGroup
                    :max="100"
                    :value="meterItems"
                    :pt="{
                        meters: {
                            class: '!h-3 !bg-sky-500 dark:!bg-surface-700',
                        },
                        meter: {
                            class: '!h-3 first:!rounded-l-lg last:!rounded-r-lg',
                        },
                        labellist: { class: '!hidden' },
                    }"
                />
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <span
                        class="font-semibold text-surface-900 dark:text-surface-0 leading-tight"
                        >Budget items</span
                    >
                </div>

                <div class="flex flex-col gap-4">
                    <div
                        v-for="(item, index) in meterItems"
                        :key="index"
                        class="flex items-center gap-4"
                    >
                        <span
                            :class="[
                                {
                                    'bg-sky-500': item.color === 'sky',
                                    'bg-green-500': item.color === 'green',
                                    'bg-yellow-500': item.color === 'yellow',
                                    'bg-orange-500': item.color === 'orange',
                                    'bg-blue-500': item.color === 'blue',
                                    'bg-red-500': item.color === 'red',
                                    'bg-purple-500': item.color === 'purple',
                                    'bg-teal-500': item.color === 'teal',
                                    'bg-lime-500': item.color === 'lime',
                                    'bg-pink-500': item.color === 'pink',
                                    'bg-indigo-500': item.color === 'indigo',
                                    'bg-amber-500': item.color === 'amber'
                                },
                                'rounded-full w-4 h-4'
                            ]"
                        />
                        <span
                            class="flex-1 font-normal text-surface-900 dark:text-surface-0 leading-tight"
                            >{{ item.label }}</span
                        >
                        <span
                            class="text-surface-700 dark:text-surface-300 leading-tight"
                            >{{ item.amount }} / {{ item.budget_left }}</span
                        >
                    </div>
                </div>
                <Button :outlined="true" @click="addBudgetItem">
                    <i class="pi pi-plus"></i><span>Add</span>
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import BudgetItem from "./BudgetItem.vue";
import { inject, computed, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { MeterGroup, Button } from "primevue";

const page = usePage();
const user = computed(() => page.props.auth.user);
const budget_types = inject("budget_types");

const getPercent = (fullSum = 0, sum = 0) => {
    let percent = (sum / fullSum) * 100;
    if (percent > 0) {
        return Number(percent.toFixed());
    } else {
        return Number(0);
    }
};

// Use PrimeVue color palette for consistency
function generateColors(count) {
    const palette = [
        "sky", "green", "yellow", "orange", "blue", "red", "purple", "teal", "lime", "pink", "indigo", "amber"
    ];
    // If more items than palette, repeat but try to shuffle for variety
    if (count <= palette.length) {
        return palette.slice(0, count);
    }
    // Generate more colors by cycling and appending index
    return Array.from({ length: count }, (_, i) => palette[i % palette.length]);
}

// Dynamically generate meterItems based on budget_types
const meterItems = ref([]);

if (budget_types) {
    const keys = Object.keys(budget_types.value);
    const colors = generateColors(keys.length);
    meterItems.value = keys.map((key, index) => {
        return {
            label: budget_types.value[key].name,
            value: getPercent(
                user.value.income,
                budget_types.value[key].amount
            ),
            color: colors[index],
            amount: Number(budget_types.value[key].amount).toFixed(2),
            budget_left: Number(budget_types.value[key].budget_left).toFixed(2),
        };
    });
}

const budgetSum = computed(() => {
    return Object.values(budget_types.value).reduce((sum, item) => {
        return sum + Number(item.amount);
    }, 0);
});

function addBudgetItem() {
    router.visit(route("budget.create"));
}
</script>
