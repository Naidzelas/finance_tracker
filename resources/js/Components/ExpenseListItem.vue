<template>
    <div
        v-if="
            data.date.substring(5, 7) ===
                tableDates.primaryDate.substring(5, 7) && tableDates.state
        "
        class="rounded border-2 bg-[white] columns-3 h-10 mt-1"
    >
        <div class="font-bold pt-1 pl-4 text-left">
            {{ data.transaction_name.substring(0, 20) }}
        </div>
        <div class="font-bold pt-1">
            {{ data.debit_credit == "C" ? data.amount : "-" + data.amount }}
        </div>
        <div class="font-bold pt-1">{{ data.date }}</div>
    </div>
    <div
        v-if="
            data.date.substring(5, 7) ===
                tableDates.secondaryDate.substring(5, 7) && !tableDates.state
        "
        class="rounded border-2 bg-[white] columns-3 h-10 mt-1"
    >
        <div class="font-bold pt-1 pl-4 text-left">
            {{ data.transaction_name.substring(0, 20) }}
        </div>
        <div class="font-bold pt-1">
            {{ data.debit_credit == "C" ? data.amount : "-" + data.amount }}
        </div>
        <div class="font-bold pt-1">{{ data.date }}</div>
    </div>
</template>

<script setup>
defineProps({ data: Object, tableDates: Object });
</script>
