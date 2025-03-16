<template>
    <main>
        <header class="flex flex-row-reverse mt-5 mr-32 h-40">
            <div v-if="user" class="group top-10 left-0 absolute flex ml-40">
                <img
                    src="\.\storage\app\public\images\cat.png"
                    class="drop-shadow-md size-20 scale-x-[-1]"
                />
                <div class="flex-col">
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
                    <LanguageSelect></LanguageSelect>
                </div>
            </div>
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
