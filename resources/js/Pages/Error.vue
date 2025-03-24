<template>
    <div class="bg-[#FEEDDD] h-screen">
        <div class="flex justify-center md:justify-start pt-10 md:pl-10">
            <img src="/./storage/app/public/images/Group 31.svg" />
        </div>
        <div
            class="relative flex flex-col bg-white shadow-lg mx-4 2xl:mx-[20em] mt-[10em] 2xl:mt-[15em] py-6 rounded-2xl font-semibold text-center"
        >
            <div class="font-semibold text-6xl sm:text-8xl">{{ status }}</div>
            <div class="sm:text-2xl">
                {{ $t("general.error.something_went_wrong") }}
            </div>
            <div>
                <Link
                    href="/"
                    as="button"
                    class="bg-orange-700 hover:bg-orange-400 mt-4 px-4 py-2 rounded-md font-bold text-white hover:scale-105 transition"
                    >{{ $t("general.go_back") }}
                </Link>
            </div>
        </div>
        <div class="flex justify-center -mt-3">
            <div class="self-center bg-white size-6 rotate-45"></div>
        </div>
        <div class="flex justify-center mt-5">
            <img
                src="\.\storage\app\public\images\cat.png"
                class="size-36 md:size-60"
            />
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    status: Number,
    message: String,
});
</script>
