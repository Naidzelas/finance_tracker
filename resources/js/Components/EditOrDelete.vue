<template>
    <div
        class="group-hover:visible group-hover:w-32 invisible top-4 right-10 absolute flex gap-2 p-2 w-0 hover:scale-110 group-hover:transition-all group-hover:ease-in-out cursor-pointer"
    >
        <Link
            :href="route(action.edit.toString(), { id: id })"
            as="button"
            class="flex-1 place-items-center grid bg-[#297A9D] hover:bg-[#153d4f] rounded h-8 text-white"
        >
            <Icon icon="tabler:edit" class="size-6"></Icon>
        </Link>
        <button
            @click="deleteItem(id)"
            class="flex-1 place-items-center grid bg-[#5A0000] hover:bg-[#942929] rounded h-8 text-white"
            :disabled="disableState"
        >
            <Icon icon="fa6-solid:trash" class="size-4"></Icon>
        </button>
    </div>
    <Icon icon="icomoon-free:spinner2" class="-top-[90%] left-[100%] relative size-4 animate-spin" :class="visible"></Icon>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

let pageVariables = defineProps({
    action: Object,
    id: Number,
});

let disableState = ref(false);
let visible = ref("invisible");
const deleteItem = async (id) => {
    disableState.value = true;
    visible.value = "visible";
    router.delete(route(pageVariables.action.delete, id), {
        onSuccess: () => {
            router.visit(pageVariables.action.redirect.toString(), {
                only: [],
            });
        },
        onError: (errors) => {
            disableState.value = false;
            visible.value = "invisible";
            console.error("Delete failed:", errors);
        },
    });
};
</script>
