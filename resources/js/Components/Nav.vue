<template>
    <div class="flex flex-col">
        <div class="relative">
            <button @click="navToggle(true)">
                <Icon icon="ph:cube-fill" class="size-10 mt-1"></Icon>
            </button>
            <div v-if="pageVariables.visible">
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
            <Link :href="pageVariables.routeName + '/create'"
                ><Icon icon="basil:add-solid" class="size-6 mt-4"></Icon
            ></Link>
        </div>
        <div class="self-center">
            <Icon icon="material-symbols:list-alt" class="size-6 mt-4"></Icon>
        </div>
    </div>
    <div class="flex mr-10 text-4xl">finance</div>
</template>
<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import NavItems from "../Components/NavItems.vue";

let pageVariables = reactive({ visible: false, routeName: "/" });
function navToggle(toggle) {
    pageVariables.visible = toggle;
}

router.on("start", (event) => {
    pageVariables.routeName = event.detail.visit.url.pathname;
});
</script>
