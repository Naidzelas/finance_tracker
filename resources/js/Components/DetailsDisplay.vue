<template>
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
</template>

<script setup>
import { reactive } from "vue";
let state = reactive({ details: true, expand: true });
function detailToggle(toggle) {
    state.visible = toggle;
    toggle ? (state.expand = false) : (state.expand = true);
}
</script>
