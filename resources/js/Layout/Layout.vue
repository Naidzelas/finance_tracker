<template>
    <main>
        <div v-if="user" class="group md:top-10 md:left-0 md:absolute flex justify-center md:justify-start mt-10 md:mt-0 -mb-20 md:mb-0 md:ml-40">
            <div>
                <img
                    src="\.\storage\app\public\images\cat.png"
                    class="drop-shadow-md size-20 scale-x-[-1]"
                />
            </div>
            <div class="md:static fixed md:flex-col">
                <div>
                    <Link
                        :href="route('logout')"
                        as="button"
                        method="post"
                        class="group-hover:visible invisible bg-white hover:bg-orange-400 p-2 rounded h-fit font-bold hover:text-white"
                        >{{ $t("general.logout") }}</Link
                    >
                </div>
                <div>
                    <Link
                        :href="route('profile.index')"
                        as="button"
                        class="group-hover:visible invisible bg-white hover:bg-orange-400 mt-1 ml-2 p-2 rounded h-fit font-bold hover:text-white"
                        >{{ $t("general.profile") }}</Link
                    >
                </div>
            </div>
            <LanguageSelect></LanguageSelect>
        </div>
        <header class="flex flex-row-reverse mt-5 mr-32 h-40">
            <Nav></Nav>
        </header>
        <slot />
    </main>
</template>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import Nav from "../Components/Nav.vue";
import LanguageSelect from "../Components/LanguageSelect.vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>
