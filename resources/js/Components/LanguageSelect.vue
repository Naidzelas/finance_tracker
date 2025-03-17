<template>
    <div class="top-5 md:top-0 left-10 md:-left-16 absolute flex gap-2">
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
            <Icon icon="circle-flags:lang-lt" class="size-6"></Icon>
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
            <Icon icon="circle-flags:lang-en" class="size-6"></Icon>
        </label>
    </div>
</template>

<script setup>
import { i18n } from "../i18n";

let changeLanguage = (locale) => {
    i18n.global.locale.value = locale;
    localStorage.setItem("locale", locale);
};
</script>
