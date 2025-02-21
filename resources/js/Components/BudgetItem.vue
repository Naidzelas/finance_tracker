<template>
    <div class="group relative p-4 w-full">
        <div v-if="item.budget_left > 0">
            <div class="group-hover:invisible flex flex-row">
                <div class="flex place-items-center basis-1/2">
                    <Icon :icon="item.icon.iconify_name" class="size-8"></Icon>
                </div>
                <div class="text-4xl text-right basis-1/2">
                    {{ item.budget_left }}
                </div>
            </div>
            <div
                class="group-hover:invisible bg-[white] mt-px mb-0.5 border rounded-full w-full"
            >
                <div class="bg-black w-[25%] h-1"></div>
            </div>
        </div>
        <div v-else class="text-red-600">
            <div class="group-hover:invisible flex flex-row">
                <div class="flex place-items-center basis-1/2">
                    <Icon :icon="item.icon.iconify_name" class="size-8"></Icon>
                </div>
                <Icon
                    icon="fluent-emoji-high-contrast:white-exclamation-mark"
                    class="top-2 right-0 absolute size-6"
                ></Icon>
                <div class="text-4xl text-right basis-1/2">
                    {{ item.budget_left }}
                </div>
            </div>
            <div
                class="group-hover:invisible bg-[white] mt-px mb-0.5 border rounded-full w-full"
            >
                <div class="bg-red-600 w-[25%] h-1"></div>
            </div>
        </div>
        <EditOrDelete
            :action="{
                edit: 'budget.edit',
                delete: 'budget.destroy',
                redirect: '/',
            }"
            :id="item.id"
        ></EditOrDelete>
    </div>
</template>

<script setup>
import EditOrDelete from "./EditOrDelete.vue";

defineProps({ item: Object });
</script>
