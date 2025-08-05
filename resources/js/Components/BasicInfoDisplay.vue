<template>
    <div class="bg-surface-50 dark:bg-surface-950 px-6 md:px-12 lg:px-20 py-8">
        <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <div
                class="flex flex-col gap-6 bg-cyan-50 dark:bg-cyan-400/30 p-4 border border-cyan-200 dark:border-cyan-400/20 rounded-2xl"
            >
                <div class="flex justify-between items-start">
                    <div
                        class="flex justify-center items-center bg-cyan-500 dark:bg-cyan-600 rounded-lg w-8 h-8"
                    >
                        <i
                            class="text-surface-0 !text-base !leading-none pi pi-inbox"
                        />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <span
                        class="font-normal text-cyan-700 dark:text-cyan-300 leading-tight"
                        >{{ $t("user.income") }}</span
                    >
                    <div
                        class="font-medium text-cyan-900 dark:text-cyan-100 !text-2xl !leading-tight"
                    >
                        {{ user.income }}
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col gap-6 bg-orange-50 dark:bg-orange-400/30 p-4 border border-orange-200 dark:border-orange-400/20 rounded-2xl"
            >
                <div class="flex justify-between items-start">
                    <div
                        class="flex justify-center items-center bg-orange-500 dark:bg-orange-600 rounded-lg w-8 h-8"
                    >
                        <i
                            class="text-surface-0 !text-base !leading-none pi pi-bolt"
                        />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <span
                        class="font-normal text-orange-700 dark:text-orange-300 leading-tight"
                        >{{ $t("user.invested") }}</span
                    >
                    <div
                        class="font-medium text-orange-900 dark:text-orange-100 !text-2xl !leading-tight"
                    >
                        {{ invested }}
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col gap-6 bg-slate-50 dark:bg-slate-400/30 p-4 border border-slate-200 dark:border-slate-400/20 rounded-2xl"
            >
                <div class="flex justify-between items-start">
                    <div
                        class="flex justify-center items-center bg-slate-500 dark:bg-slate-600 rounded-lg w-8 h-8"
                    >
                        <i
                            class="text-surface-0 !text-base !leading-none pi pi-gift"
                        />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <span
                        class="font-normal text-slate-700 dark:text-slate-300 leading-tight"
                        >{{ $t("user.debt") }}</span
                    >
                    <div
                        class="font-medium text-slate-900 dark:text-slate-100 !text-2xl !leading-tight"
                    >
                        {{ (debt.paid).toFixed(2) + " / " + debt.total }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
defineProps({
    debt: Object,
    invested: Number,
});
const page = usePage();
const user = computed(() => page.props.auth.user);
</script>
