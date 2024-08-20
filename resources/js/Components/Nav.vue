<template>
    <div class="flex flex-col">
        <div class="relative">
            <button @click="navToggle(true)">
                <Icon icon="ph:cube-fill" class="size-10 mt-1"></Icon>
            </button>
            <div v-if="state.visible">
                <div
                    class="bg-white size-12 w-20 absolute top-0 right-0.5 rounded-r-md"
                >
                    <button @click="navToggle(false)">
                        <Icon
                            icon="fluent:receipt-cube-20-regular"
                            class="size-10 mt-1 ml-10"
                        ></Icon>
                    </button>
                    <NavItems></NavItems>
                </div>
            </div>
        </div>
        <div class="self-center">
            <Icon icon="clarity:bell-solid-badged" class="size-6 mt-6"></Icon>
        </div>
        <div class="self-center">
            <Icon icon="basil:add-solid" class="size-6 mt-4"></Icon>
        </div>
        <div class="self-center">
            <Icon icon="material-symbols:list-alt" class="size-6 mt-4"></Icon>
        </div>
    </div>
    <div class="flex mr-10 text-4xl">finance</div>
</template>
<script setup>
import { reactive } from "vue";
import NavItems from "../Components/NavItems.vue";
let state = reactive({ visible: false });
function navToggle(toggle) {
    state.visible = toggle;
}
</script>
