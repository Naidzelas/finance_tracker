<template>
    <main>
        <header class="flex flex-row-reverse mt-5 mr-32 h-40">
            <div v-if="!user" class="top-10 left-0 absolute flex ml-40">
                <Icon icon="unjs:untyped" class="size-6"></Icon>
                <Link :href="route('login')" as="button" class="bg-slate-500 hover:bg-slate-600 pr-2 pl-2 rounded text-white">-in</Link>
            </div>
            <div v-else class="top-10 left-0 absolute flex ml-40">
                <Icon icon="unjs:untyped" class="size-6"></Icon>
                <Link :href="route('logout')" as="button" method="post" class="bg-slate-500 hover:bg-slate-600 pr-2 pl-2 rounded text-white">-out</Link>
            </div>
            <Nav></Nav>
        </header>
        <slot />
    </main>
</template>
<script setup>
import Nav from "../Components/Nav.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const page = usePage();
const user = computed(() => page.props.auth.user)
console.log(user.name);
</script>
