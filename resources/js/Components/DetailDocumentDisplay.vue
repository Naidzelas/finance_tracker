<template>
    <div class="mt-2 text-2xl text-start mr">{{ name }}</div>
    <div class="bg-gray-400 mt-1 mb-6 w-full h-px"></div>
    <div class="gap-x-3 gap-y-3 grid grid-cols-12">
        <div v-for="item in data" class="bg-slate-200 rounded w-fit size-32">
            <div class="flex justify-end space-x-1 mt-2 mr-2">
                <button
                    @click="deleteItem(item.id)"
                >
                    <Icon
                        icon="fa6-solid:trash"
                        class="self-center size-4"
                    ></Icon>
                </button>
                <a
                    :href="
                        route('document.download', { filename: item.filename })
                    "
                    as="button"
                >
                    <Icon
                        icon="material-symbols:download-rounded"
                        class="size-6"
                    ></Icon>
                </a>
                <a
                    :href="route('document.open', { filename: item.filename })"
                    as="button"
                    target="_blank"
                >
                    <Icon icon="mdi:eye" class="size-6"></Icon>
                </a>
            </div>
            <div>
                {{ item.filename }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
defineProps({
    name: String,
    data: Object,
});

const deleteItem = async (id) => {
    router.delete(route("document.destroy", id), {
        onSuccess: () => {
            router.visit("/debt", { only: ["debts"] });
        },
        onError: (errors) => {
            console.error("Delete failed:", errors);
        },
    });
};
</script>
