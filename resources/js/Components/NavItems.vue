<template>
    <div
        class="bg-white w-56 absolute top-0 right-12 flex flex-col space-y-3 p-3 rounded-md"
    >
        <Link href="/" class="self-center text-3xl">Finances</Link>
        <Link href="/debt" class="self-center text-3xl">Debts</Link>
        <Link href="/investment" class="self-center text-3xl">Investments</Link>
        <Link :href="'/goal'" class="self-center text-3xl">Goals</Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
