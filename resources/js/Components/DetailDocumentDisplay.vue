<template>
    <div class="mt-2 text-2xl text-start mr">{{ name }}</div>
    <div class="bg-gray-400 mt-1 mb-6 w-full h-px"></div>
    <div class="gap-x-3 gap-y-3 grid grid-cols-12">
        <div v-for="item in data" class="bg-[#D9D9D9] rounded w-fit size-32">
            <div class="flex justify-end space-x-1 mt-2 mr-2">
                <Icon icon="fa6-solid:trash" class="self-center size-4"></Icon>
                <Icon
                    icon="material-symbols:download-rounded"
                    class="size-6"
                ></Icon>
            </div>
            <div>
                {{ item.filename }}
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    name: String,
    data: Object,
});
</script>
