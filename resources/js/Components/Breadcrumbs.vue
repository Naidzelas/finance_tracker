<template>
    <Breadcrumb :model="breadcrumbs">
        <template #item="{ item }">
            <div>
                <Link as="button" :href="item.route">{{ item.label }}</Link>
            </div>
        </template>
    </Breadcrumb>
</template>

<script setup>
import { Breadcrumb } from "primevue";
import { Link } from "@inertiajs/vue3";

defineProps({
    breadcrumbs: Object,
});
</script>
