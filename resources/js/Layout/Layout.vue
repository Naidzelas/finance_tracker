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
                    <div class="top-0 -left-16 absolute flex gap-2">
                        <input
                            @change="changeLanguage('lt')"
                            type="radio"
                            id="lang-lt"
                            name="language"
                            ref="checked"
                            class="sr-only peer/lt"
                            :checked="i18n.global.locale.value === 'lt'"
                        />
                        <label
                            for="lang-lt"
                            class="opacity-20 hover:opacity-100 peer-checked/lt:opacity-100 p-0.5 rounded-full hover:scale-110 peer-checked/lt:scale-110 transition duration-200 ease-in-out cursor-pointer"
                        >
                            <Icon
                                icon="circle-flags:lang-lt"
                                class="size-6"
                            ></Icon>
                        </label>
                        <input
                            @change="changeLanguage('en')"
                            type="radio"
                            id="lang-en"
                            name="language"
                            ref="checked"
                            class="sr-only peer/en"
                            :checked="i18n.global.locale.value === 'en'"
                        />
                        <label
                            for="lang-en"
                            class="peer-checked/en:disabled opacity-20 hover:opacity-100 peer-checked/en:opacity-100 p-0.5 rounded-full hover:scale-110 peer-checked/en:scale-110 transition duration-200 ease-in-out cursor-pointer"
                        >
                            <Icon
                                icon="circle-flags:lang-en"
                                class="size-6"
                            ></Icon>
                        </label>
                    </div>
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
import { Icon } from "@iconify/vue/dist/iconify.js";
import Nav from "../Components/Nav.vue";
import { i18n } from "../app";

const page = usePage();
const user = computed(() => page.props.auth.user);

const changeLanguage = (locale) => {
    i18n.global.locale.value = locale;
    localStorage.setItem("locale", locale);
};
</script>
