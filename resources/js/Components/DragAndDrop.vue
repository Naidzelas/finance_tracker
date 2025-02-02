<template>
    <div
        class="group flex justify-center border-2 bg-white p-5 border-black border-dashed w-64 h-24 cursor-pointer"
        @click="triggerFileInput"
    >
        <button class="flex self-center">
            <div>Drag and</div>
            <Icon
                icon="material-symbols-light:water-drop"
                class="ml-1 text-[#006692] group-hover:animate-bounce size-6"
            ></Icon>
        </button>
    </div>
    <div v-if="files">Files:</div>
    <div class="flex-col">
        <div v-for="(file, index) in files" class="mr-2 font-thin">
            {{ index + 1 }}.
            {{ file.name.substr(0, 10) }}
            {{ (file.size / 1000).toFixed(2) }}MB
        </div>
    </div>
    <input
        type="file"
        ref="fileInput"
        :showUploadButton="false"
        class="file:border-0 file:bg-white invisible"
        :multiple="true"
        @input="form.avatar = $event.target.files"
        @change="files = form.avatar"
    />
</template>

<script setup>
import { ref } from "vue";

const fileInput = ref(null);
let files = ref("");

let pageVariables = defineProps({
    form: Object,
});

function triggerFileInput(event) {
    event.preventDefault();
    fileInput.value.click();
}
</script>
