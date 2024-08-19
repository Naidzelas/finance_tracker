<template>
    <main>
        <header class="h-40 mr-32 mt-5 flex flex-row-reverse">
            <Nav></Nav>
        </header>
        <slot />
    </main>
</template>
<script setup>
import Nav from "../Components/Nav.vue";
</script>
