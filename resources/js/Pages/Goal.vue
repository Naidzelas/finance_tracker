<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current goals</div>
        <div class="rounded-full mb-0.5 bg-[white]">
            <div
                class="rounded-full bg-gradient-to-r from-black to-[#606060] w-[28%] h-2"
            ></div>
        </div>
        <div class="rounded-md bg-[#F4F4F4] flex p-3">
            <div class="flex flex-1 pl-10">
                <div><Icon icon="lucide:house" class="size-12"></Icon></div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Need</div>
                <div>€ 15 000</div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Monthly</div>
                <div>€ 625</div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Months to complete</div>
                <div>24</div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Saved</div>
                <div>€ 0</div>
            </div>
        </div>
        <button @click="detailToggle(true)">
            <div v-if="state.expand"
                class="rounded-md mb-0.5 bg-[#F4F4F4] mt-1 w-full flex justify-center"
            >
                <Icon icon="tabler:dots" class="h-5 w-5"></Icon>
            </div>
        </button>
        <div
            v-if="state.visible"
            class="rounded-md mb-0.5 bg-[#F4F4F4] mt-1 w-full pb-6 relative"
        >
            <div class="pt-2 pl-10 pr-6">
                <div class="text-2xl mt-2 mr text-start">towards savings</div>
                <div class="flex absolute top-3 right-6 space-x-2">
                    <Icon icon="fa-regular:edit" class="size-8"></Icon>
                    <button @click="detailToggle(false)">
                        <Icon icon="icon-park:close" class="size-8"></Icon>
                    </button>
                </div>
                <div class="w-full mt-1 bg-gray-400 h-px"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive } from "vue";
let state = reactive({ details: true, expand: true });
function detailToggle(toggle) {
    state.visible = toggle;
    toggle ? state.expand = false : state.expand = true;
}
</script>
