<template>
    <button @click="detailToggle(true)" class="w-full mb-6 mt-4">
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
            <div class="flex absolute top-3 right-6 space-x-2">
                <Icon icon="fa-regular:edit" class="size-8"></Icon>
                <button @click="detailToggle(false)">
                    <Icon icon="icon-park:close" class="size-8"></Icon>
                </button>
            </div>
            <div v-for="(detailsType, type) in detailsTab" class="w-full mt-1">
                <DetailStatDisplay
                    v-if="type == 'stats' && detailsType"
                    :name="type"
                    :data="detailsType[id]"
                ></DetailStatDisplay>
                <DetailTableDisplay
                    v-if="type == 'table' && detailsType"
                    :name="type"
                    :tableHead="detailsType['thead']"
                    :tableData="detailsType[id]"
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
