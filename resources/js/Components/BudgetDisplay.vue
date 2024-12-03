<template>
    <div class="rounded border-6 bg-[white]">
        <div class="grid grid-cols-3 gap-1 p-4 justify-items-center">
            <BudgetItem v-for="icon in budgetIcons" :iconify_name="icon.iconify_name"></BudgetItem>
                <Link
                    href='/'
                    method="post"
                    as="button"
                    type="button"
                    class="text-2xl uppercase flex"
                >
                <Icon icon="carbon:add-filled" class="size-8 mr-3"></Icon>
                Add new
                </Link>
        </div>
    </div>
</template>

<script setup>
import BudgetItem from "./BudgetItem.vue";
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'

const page = usePage()

const budgetIcons = computed(() => page.props.budgetIcons)

</script>
