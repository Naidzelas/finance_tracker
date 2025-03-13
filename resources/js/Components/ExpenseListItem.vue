<template>
    <div v-if="!Object.keys(data).length">{{ $t("general.no_data") }}</div>
    <div
        v-for="item in data"
        class="columns-3 bg-[white] mt-1 border-2 rounded h-10"
    >
        <div class="pt-1 pl-4 font-bold text-left">
            {{ item.transaction_name.substring(0, 20) }}
        </div>
        <div class="pt-1 font-bold">
            {{ item.debit_credit == "C" ? item.amount : "-" + item.amount }}
        </div>
        <div class="pt-1 font-bold">{{ item.date }}</div>
    </div>
</template>

<script setup>
defineProps({ data: Object, tableDates: Object });
</script>
