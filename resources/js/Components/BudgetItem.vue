<template>
    <div class="group relative w-28">
        <!-- TODO change this to component -->
        <div
            class="group-hover:visible group-hover:ease-in-out group-hover:w-32 absolute flex justify-center gap-2 p-2 w-0 group-hover:transition-all cursor-pointer invisible hover:scale-110"
        >
            <Link
                :href="route('budget.edit', { id: item.id })"
                as="button"
                class="flex-1 place-items-center grid bg-[#297A9D] hover:bg-[#153d4f] rounded h-8 text-white"
            >
                <Icon icon="tabler:edit" class="size-6"></Icon>
            </Link>
            <button
                @click="deleteItem(item.id)"
                class="flex-1 place-items-center grid bg-[#5A0000] hover:bg-[#942929] rounded h-8 text-white"
            >
                <Icon icon="fa6-solid:trash" class="size-4"></Icon>
            </button>
        </div>
        <div class="flex flex-row group-hover:invisible">
            <div class="flex place-items-center basis-1/2">
                <Icon :icon="item.icon.iconify_name" class="size-8"></Icon>
            </div>
            <div class="text-right text-4xl basis-1/2">
                {{ item.amount }}
            </div>
        </div>
        <div
            class="bg-[white] mt-px mb-0.5 border rounded-full group-hover:invisible"
        >
            <div class="bg-black w-[25%] h-1"></div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";

defineProps({ item: Object });

const deleteItem = async (id) => {
    router.delete(route("budget.destroy", id), {
        onSuccess: () => {
            router.visit("/", { only: ["budget_types"] });
        },
        onError: (errors) => {
            console.error("Delete failed:", errors);
        },
    });
};
</script>
