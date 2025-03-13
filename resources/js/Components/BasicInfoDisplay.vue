<template>
    <div class="bg-[white] border-6 rounded text-center">
        <div class="gap-1 grid grid-cols-3 p-4">
            <div class="font-semibold text-2xl">{{ $t("user.income") }}</div>
            <div class="font-semibold text-2xl">{{ $t("user.invested") }}</div>
            <div class="font-semibold text-2xl">{{ $t("user.debt") }}</div>
            <div class="text-xl">{{ user.income }}</div>
            <div class="text-xl">{{ invested }}</div>
            <div class="text-xl">{{ debt.paid + " / " + debt.total }}</div>
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
