<template>
    <div class="mb-10">
        <div v-if="!Object.keys(data).length">{{ $t("general.no_data") }}</div>
        <div
            v-for="item in data"
            class="flex bg-[white] mt-1 py-1 border-2 rounded h-fit text-[12px] md:text-sm"
        >
            <div class="flex-1 pt-1 pl-4 font-bold text-left">
                {{ item.transaction_name.substring(0, 20) }}
            </div>
            <div class="flex-1 pt-1 font-bold">
                {{ item.debit_credit == "C" ? item.amount : "-" + item.amount }}
            </div>
            <div class="flex-1 pt-1 font-bold">{{ item.date }}</div>
        </div>
    </div>
</template>

<script setup>
defineProps({ data: Object, tableDates: Object });
</script>
