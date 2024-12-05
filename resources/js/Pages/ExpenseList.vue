<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="text-5xl">all expenses</div>
        <div class="text-md mt-1 mb-10">finance • expenses</div>
        <div v-for="(expense, date) in expenses">
            <div class="flex">
                <div
                    class="rounded border-6 bg-[#C9AA8E] w-36 h-8 text-lg mb-2 text-white text-center font-bold"
                >
                    {{ date }}
                </div>
                <div class="flex-auto"></div>
                <div
                    class="bg-[#3C3C3C] rounded-md size-8 grid place-items-center"
                >
                    <Icon
                        icon="ion:calendar"
                        color="white"
                        class="size-6"
                    ></Icon>
                </div>
                <div
                    class="bg-[#3C3C3C] rounded-md size-8 grid place-items-center ml-1"
                >
                    <Icon
                        icon="tabler:category-filled"
                        color="white"
                        class="size-6"
                    ></Icon>
                </div>
            </div>
            <div v-for="item in expense" :key="item.id">
                <div class="rounded-md bg-[#F4F4F4] flex p-3">
                    <div class="flex pr-10 pl-10">
                        <div><Icon icon="lucide:house" class="size-12"></Icon></div>
                    </div>
                    <div class="flex pr-36">
                        <div>{{ item.type_id + ' type name' }}</div>
                    </div>
                    <div class="flex flex-col pr-6 flex-1">
                        <div class="font-bold">Name</div>
                        <div>{{ item.transaction_name }}</div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <div class="font-bold">Amount</div>
                        <div>{{ item.amount }}</div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <div class="font-bold">Date</div>
                        <div>{{ item.date }}</div>
                    </div>
                </div>
                <DetailsDisplay></DetailsDisplay>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive } from "vue";
import DetailsDisplay from "../Components/DetailsDisplay.vue";

defineProps({ expenses: Object });
</script>
