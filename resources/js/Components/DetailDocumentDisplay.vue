<template>
    <div class="text-2xl mt-2 mr text-start">{{name}}</div>
    <div class="w-full mt-1 bg-gray-400 h-px mb-6"></div>
    <div class="grid grid-cols-12 gap-2">
       <div v-for="item in 30" class="size-32 bg-[#D9D9D9] rounded">
            <div class="flex justify-end mt-2 mr-2 space-x-1">
                <Icon icon="fa6-solid:trash" class="size-4 self-center"></Icon>
                <Icon icon="material-symbols:download-rounded" class="size-6"></Icon>
            </div>
       </div>
    </div>
</template>

<script setup>
defineProps({
    name: String
})
</script>
