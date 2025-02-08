<template>
    <div v-if="!Object.keys(data).length"> Empty </div>
    <div v-for="item in data" class="border-2 bg-[white] mt-1 rounded h-10 columns-3">
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
