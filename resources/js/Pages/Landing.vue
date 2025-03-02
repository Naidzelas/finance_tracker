<template>
    <div class="relative">
        <div class="mt-[20%] text-center">
            <div class="text-8xl">WELCOME</div>
            <Link
                :href="route('login')"
                as="button"
                class="bg-orange-700 hover:bg-orange-400 mt-4 p-2 rounded-md font-bold text-white hover:scale-105"
                >Come to my office</Link
            >
        </div>
        <div
            class="-top-5 left-[40%] -z-10 absolute bg-white w-[20%] h-52"
        ></div>
    </div>
    <img
        src="\.\storage\app\public\images\cat.png"
        class="top-[46%] right-[35%] absolute size-72"
    />
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
