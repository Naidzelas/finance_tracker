<template>
    <div class="w-28 group">
        <div
            class="flex w-0 gap-2 p-2 absolute invisible group-hover:visible cursor-pointer group-hover:transition-all group-hover:ease-in-out hover:scale-110 group-hover:w-32 justify-center"
        >
            <Link
                :href="route('budget.edit', { id: item.id })"
                as="button"
                class="bg-[#297A9D] hover:bg-[#153d4f] flex-1 text-white rounded h-8 grid place-items-center"
            >
                <Icon icon="tabler:edit" class="size-6"></Icon>
            </Link>
            <button
                @click="deleteItem(item.id)"
                class="bg-[#5A0000] hover:bg-[#942929] flex-1 text-white rounded h-8 grid place-items-center"
            >
                <Icon icon="fa6-solid:trash" class="size-4"></Icon>
            </button>
        </div>
        <div class="flex flex-row group-hover:invisible">
            <div class="flex place-items-center basis-1/2">
                <Icon :icon="item.icon.iconify_name" class="size-8"></Icon>
            </div>
            <div class="text-4xl basis-1/2 text-right">
                {{ item.amount }}
            </div>
        </div>
        <div
            class="rounded-full border mb-0.5 bg-[white] mt-px group-hover:invisible"
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
