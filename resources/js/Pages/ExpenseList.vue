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
            <!-- TODO foreach data -->
            <div v-for="item in expense" :key="item.id">
                <div class="rounded-md bg-[#F4F4F4] flex p-3">
                    <div class="flex flex-1 pl-10">
                        <div><Icon icon="lucide:house" class="size-12"></Icon></div>
                    </div>
                    <div class="flex flex-col flex-1">
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
                <button @click="detailToggle(true)" class="w-full mb-4">
                    <div
                        v-if="state.expand"
                        class="rounded-md mb-0.5 bg-[#F4F4F4] mt-1 flex justify-center"
                    >
                        <Icon icon="tabler:dots" class="h-5 w-5"></Icon>
                    </div>
                </button>
                <div
                    v-if="state.visible"
                    class="rounded-md bg-[#F4F4F4] mt-[-1.5em] mb-5 w-full pb-6 relative"
                >
                    <div class="pt-2 pl-10 pr-6">
                        <div class="text-2xl mt-2 mr text-start">
                            towards savings
                        </div>
                        <div class="flex absolute top-3 right-6 space-x-2">
                            <Icon icon="fa-regular:edit" class="size-8"></Icon>
                            <button @click="detailToggle(false)">
                                <Icon icon="icon-park:close" class="size-8"></Icon>
                            </button>
                        </div>
                        <div class="w-full mt-1 bg-gray-400 h-px"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive } from "vue";

defineProps({ expenses: Object });

let state = reactive({ details: true, expand: true });
function detailToggle(toggle) {
    state.visible = toggle;
    toggle ? (state.expand = false) : (state.expand = true);
}
</script>
