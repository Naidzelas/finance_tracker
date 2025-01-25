<template>
    <div class="text-2xl mt-2 mr text-start">{{ name }}</div>
    <div class="w-full mt-1 bg-gray-400 h-px mb-6"></div>
    <div class="grid grid-cols-6 gap-2">
        <div class="flex-col">
            <label class="font-bold text-md">Revenue</label>
            <div v-if="data.is_green">{{ data.revenue }}</div>
            <div v-else>{{ -Math.abs(data.revenue) }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">EPS</label>
            <div v-if="data.is_eps_green">{{ data.eps }}</div>
            <div v-else>{{ -Math.abs(data.eps) }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">PE Ratio</label>
            <div v-if="data.is_pe_green">{{ data.pe_ratio }}</div>
            <div v-else>{{ -Math.abs(data.pe_ratio) }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Dividend</label>
            <div>{{ data.dividend }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Dividend Ex Date</label>
            <div>{{ data.dividend_ex_date ?? 'N/A' }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Dividend Pay Date</label>
            <div>{{ data.dividend_pay_date ?? 'N/A' }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Type</label>
            <div>{{ data.investment.investment_type.name }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Sector</label>
            <div>{{ data.investment.investment_sector.name }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Earnings call</label>
            <div>In progress</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Dividend Payout</label>
            <div>In progress</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Dividend Tax</label>
            <div>In progress</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">Dividend Frequency</label>
            <div>{{ data.dividend_frequency ?? 'N/A' }}</div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    name: String,
    data: Object,
});
</script>
