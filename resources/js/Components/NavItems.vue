<template>
    <div
        class="top-0 right-12 absolute flex flex-col space-y-3 bg-white p-3 rounded-md w-56"
    >
        <Link href="/" class="hover:bg-orange-400 rounded-md w-full hover:text-white text-3xl text-center scale-105 transition">{{ $t("general.finance").toLocaleLowerCase() }}</Link>
        <Link href="/debt" class="hover:bg-orange-400 rounded-md w-full hover:text-white text-3xl text-center scale-105 transition">{{ $t("general.debts").toLocaleLowerCase() }}</Link>
        <Link href="/investment" class="hover:bg-orange-400 rounded-md w-full hover:text-white text-3xl text-center scale-105 transition">{{ $t("general.investments").toLocaleLowerCase() }}</Link>
        <Link :href="'/goal'" class="hover:bg-orange-400 rounded-md w-full hover:text-white text-3xl text-center scale-105 transition">{{ $t("general.goals").toLocaleLowerCase() }}</Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
