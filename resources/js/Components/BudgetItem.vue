<template>
    <div class="w-28">
        <div class="flex flex-row">
            <div class="flex place-items-center basis-1/2">
                <Icon :icon=iconify_name  class="size-8"></Icon>
            </div>
            <div class="text-4xl basis-1/2 text-right">1</div>
        </div>
        <div class="rounded-full border mb-0.5 bg-[white] mt-px">
            <div class="bg-black w-[25%] h-1"></div>
        </div>
    </div>
    {{  }}
</template>

<script setup>
import { defineProps } from "vue";

defineProps({ iconify_name: String });
</script>
