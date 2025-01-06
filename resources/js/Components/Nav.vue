<template class="relative">
    <ImportFileModal></ImportFileModal>
    <div class="flex flex-col">
        <div class="relative">
            <button @click="navToggle(true)">
                <Icon icon="ph:cube-fill" class="size-10 mt-1"></Icon>
            </button>
            <div v-if="pageVariables.menu_visible">
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
            <div v-if="pageVariables.routeName === '/'">
                <button @click="modalToggle(true)">
                    <Icon icon="basil:add-solid" class="size-6 mt-4"></Icon>
                </button>
            </div>
            <Link v-else :href="pageVariables.routeName + '/create'"
                ><Icon icon="basil:add-solid" class="size-6 mt-4"></Icon
            ></Link>
        </div>
        <div v-if="pageVariables.routeName === '/'" class="self-center">
            <Link href="/expense_list">
                <Icon icon="material-symbols:list-alt" class="size-6 mt-4"></Icon>
            </Link>
        </div>
    </div>
    <div class="flex mr-10 text-4xl">finance</div>
</template>
<script setup>
import { reactive, provide, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import NavItems from "../Components/NavItems.vue";
import ImportFileModal from "./ImportFileModal.vue";

let pageVariables = reactive({
    menu_visible: false,
    routeName: "/",
});

let modal_visible = ref(false);
function navToggle(toggle) {
    pageVariables.menu_visible = toggle;
}
function modalToggle(toggle) {
    modal_visible.value = toggle;
}
provide("modal_state", modal_visible);

// TODO this needs to be obliterated and needs a new solution. Very janky...
router.on("start", (event) => {
    pageVariables.routeName = event.detail.visit.url.pathname;
});
</script>
