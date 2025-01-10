<template>
    <div class="text-2xl mt-2 mr text-start">{{name}}</div>
    <div class="w-full mt-1 bg-gray-400 h-px mb-6"></div>
    <div>
        <textarea class="w-full h-fit">
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est lab  orum."</textarea
        >
    </div>
</template>

<script setup>
defineProps({
    name: String
})
</script>
