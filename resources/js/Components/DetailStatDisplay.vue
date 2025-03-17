<template>
    <div class="mt-2 text-2xl text-start mr">
        {{ $t("general." + name) }}
    </div>
    <div class="bg-gray-400 mt-1 mb-6 w-full h-px"></div>
    <div v-if="Object.keys(data).length" class="gap-2 grid grid-cols-6">
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".revenue")
            }}</label>
            <div v-if="data.is_green">{{ data.revenue }}</div>
            <div v-else>{{ -Math.abs(data.revenue) }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".eps")
            }}</label>
            <div v-if="data.is_eps_green">{{ data.eps }}</div>
            <div v-else>{{ -Math.abs(data.eps) }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".pe_ratio")
            }}</label>
            <div v-if="data.is_pe_green">{{ data.pe_ratio }}</div>
            <div v-else>{{ -Math.abs(data.pe_ratio) }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".dividend")
            }}</label>
            <div>{{ data.dividend }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".dividend_ex_date")
            }}</label>
            <div>{{ data.dividend_ex_date ?? "N/A" }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".dividend_pay_date")
            }}</label>
            <div>{{ data.dividend_pay_date ?? "N/A" }}</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".investment_type")
            }}</label>
            <div>
                {{
                    $t(
                        translate +
                            "." +
                            data.investment.investment_type.name.toLowerCase()
                    )
                }}
            </div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".sector")
            }}</label>
            <div>
                {{
                    $t(
                        translate +
                            "." +
                            data.investment.investment_sector.name
                                .toLowerCase()
                                .replace(" ", "_")
                    )
                }}
            </div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".earnings_call")
            }}</label>
            <div>In progress</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".dividend_payout")
            }}</label>
            <div>In progress</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".dividend_tax")
            }}</label>
            <div>In progress</div>
        </div>
        <div class="flex-col">
            <label class="font-bold text-md">{{
                $t(translate + ".dividend_frequency")
            }}</label>
            <div>
                {{
                    $t(
                        translate + "." + data.dividend_frequency.toLowerCase()
                    )
                }}
            </div>
        </div>
    </div>
    <div v-else>{{ $t("general.no_data") }}</div>
</template>

<script setup>
import { inject } from "vue";
defineProps({
    name: String,
    data: Object,
});

let translate = inject("translate");
</script>
