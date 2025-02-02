<template>
    <div
        class="group-hover:visible group-hover:ease-in-out group-hover:w-32 top-4 right-10 absolute flex gap-2 p-2 w-0 group-hover:transition-all cursor-pointer invisible hover:scale-110"
    >
        <Link
            :href="route((action.edit).toString(), { id: id })"
            as="button"
            class="flex-1 place-items-center grid bg-[#297A9D] hover:bg-[#153d4f] rounded h-8 text-white"
        >
            <Icon icon="tabler:edit" class="size-6"></Icon>
        </Link>
        <button
            @click="deleteItem(id)"
            class="flex-1 place-items-center grid bg-[#5A0000] hover:bg-[#942929] rounded h-8 text-white"
        >
            <Icon icon="fa6-solid:trash" class="size-4"></Icon>
        </button>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
let pageVariables = defineProps({
    action: Object,
    id: Number,
});

// const deleteItem = async (id) => {
//     router.delete(route(pageVariables.action.delete, id), {
//         onSuccess: () => {
//             router.visit((pageVariables.action.redirect).toString(), { only: [] });
//         },
//         onError: (errors) => {
//             console.error("Delete failed:", errors);
//         },
//     });
// };
</script>
