<template>
    <div class="mt-2 text-2xl text-start mr">
        {{ $t("general." + name).toLocaleLowerCase() }}
    </div>
    <div class="bg-gray-400 mt-1 mb-6 w-full h-px"></div>
    <div class="flex gap-2">
        <div
            v-for="item in data"
            class="bg-slate-300 shadow-inner rounded w-44"
        >
            <div class="flex justify-end space-x-1 mt-2 mr-2">
                <button
                    @click="deleteItem(item.id)"
                    class="hover:text-red-900 hover:scale-125 transition transform"
                    :disabled="disableState"
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
                    class="hover:text-yellow-600 hover:scale-125 transition transform"
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
                    class="hover:text-[#297A9D] hover:scale-125 transition transform"
                >
                    <Icon icon="mdi:eye" class="size-6"></Icon>
                </a>
            </div>
            <div class="mt-[50%] text-center">
                {{ item.filename }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    name: String,
    data: Object,
});

let disableState = ref(false);
let visible = ref("invisible");
const deleteItem = async (id) => {
    disableState.value = true;
    visible.value = "visible";
    router.delete(route("document.destroy", id), {
        onSuccess: () => {
            router.visit("/debt", { only: ["debts"] });
        },
        onError: (errors) => {
            disableState.value = false;
            visible.value = "invisible";
            console.error("Delete failed:", errors);
        },
    });
};
</script>
