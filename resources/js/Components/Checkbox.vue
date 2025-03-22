<template>
    <div class="relative flex items-center md:mt-8 p-5">
        <input
            :id="id"
            name="form_item"
            v-model="check"
            type="checkbox"
            class="peer relative bg-white checked:bg-[#006692] mr-3 border-[#006692] border-1 checked:border-0 rounded-none size-7 appearance-none cursor-pointer select-none shrink-0"
        />
        <label for="form_item" class="font-thin text-xl">{{
            $t(registerRoute + "." + name)
        }}</label>
        <Icon
            icon="material-symbols:check-rounded"
            class="hidden peer-checked:block absolute size-7 text-white pointer-events-none"
        ></Icon>
    </div>
    <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
</template>

<script setup>
import { onMounted, ref, watch, inject } from "vue";

let pageVariables = defineProps({
    name: String,
    form: Object,
    data: Boolean,
    id: Number,
    error: String,
});

const check = ref();
let registerRoute = inject("registerRoute");

onMounted(() => {
    if (typeof pageVariables.data !== "undefined") {
        pageVariables.form[pageVariables.name] = pageVariables.data;
        check.value = pageVariables.data;
    }
});

watch(check, (newValue) => {
    pageVariables.form[pageVariables.name] = newValue;
});
</script>
