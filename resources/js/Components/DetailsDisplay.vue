<template>
    <button @click="detailToggle(true)" class="mt-4 mb-6 w-full">
        <div
            v-if="state.expand"
            class="flex justify-center bg-[#F4F4F4] mt-1 mb-0.5 rounded-md"
        >
            <Icon icon="tabler:dots" class="w-5 h-5"></Icon>
        </div>
    </button>
    <div
        v-if="state.visible"
        class="relative bg-[#F4F4F4] mt-[-1.5em] mb-5 pb-6 rounded-md w-full"
    >
        <div class="pt-2 pr-6 pl-10">
            <div class="top-3 right-6 absolute flex space-x-2">
                <Icon icon="fa-regular:edit" class="size-8"></Icon>
                <button @click="detailToggle(false)">
                    <Icon icon="icon-park:close" class="size-8"></Icon>
                </button>
            </div>
            <div v-for="(detailsType, type) in detailsTab" class="mt-1 w-full">
                <DetailStatDisplay
                    v-if="type == 'stats' && detailsType"
                    :name="type"
                    :data="detailsType[id]"
                ></DetailStatDisplay>
                <DetailTableDisplay
                    v-if="type == 'table' && detailsType"
                    :name="type"
                    :tableHead="detailsType['thead']"
                    :tableData="detailsType[id]['tbody']"
                ></DetailTableDisplay>
                <DetailDocumentDisplay
                    v-if="type == 'documents'"
                    :name="type"
                ></DetailDocumentDisplay>
                <DetailNoteDisplay
                    v-if="type == 'notes'"
                    :name="type"
                ></DetailNoteDisplay>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import DetailNoteDisplay from "./DetailNoteDisplay.vue";
import DetailTableDisplay from "./DetailTableDisplay.vue";
import DetailDocumentDisplay from "./DetailDocumentDisplay.vue";
import DetailStatDisplay from "./DetailStatDisplay.vue";
defineProps({ detailsTab: Object, id: Number });
let state = reactive({ detailsTab: true, expand: true });

function detailToggle(toggle) {
    state.visible = toggle;
    toggle ? (state.expand = false) : (state.expand = true);
}
</script>
