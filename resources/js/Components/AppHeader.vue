<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
    <div class="bg-surface-50 dark:bg-surface-950 px-6 md:px-4 py-8">
        <ul class="flex items-center gap-3 m-0 mb-5 p-0 font-medium list-none">
            <li
                v-for="(item, index) in breadcrumbs"
                :key="index"
                class="flex gap-2"
            >
                <span
                    v-if="item.route"
                    class="text-surface-500 dark:text-surface-300 no-underline leading-normal cursor-pointer"
                >
                    <Link :href="item.route">
                        {{ item.label }}
                    </Link>
                </span>
                <span v-else class="text-surface-500 dark:text-surface-300">
                    {{ item.label }}
                </span>
                <i
                    v-if="index < breadcrumbs.length - 1"
                    class="pi-angle-right self-center text-surface-500 dark:text-surface-300 text-sm! leading-normal! pi"
                />
            </li>
        </ul>
        <div class="flex md:flex-row flex-col md:justify-between items-start">
            <div>
                <div
                    class="mb-2 font-bold text-surface-900 dark:text-surface-0 text-3xl"
                >
                    {{ title }}
                </div>
                <div
                    class="mb-4 text-md text-surface-600 dark:text-surface-200 leading-tight"
                >
                    {{ subtitle }}
                </div>
            </div>
            <div class="flex items-center mt-6 md:mt-0">
                <Button
                    @click="add()"
                    label="Add"
                    class="mr-3"
                    icon="pi pi-plus"
                />
            </div>
        </div>
    </div>
</template>
<script setup>
import { Button } from "primevue";
import { Link, Head, router } from "@inertiajs/vue3";
defineOptions({ inheritAttrs: false });
const props = defineProps({
    breadcrumbs: Array,
    title: String,
    subtitle: String,
});

function add() {
    console.log("Adding new " + props.title.toLowerCase());
    router.get(route(`${props.title.toLowerCase().slice(0, -1)}.create`));
}
</script>
