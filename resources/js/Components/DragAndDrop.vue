<template>
    <div
        class="hidden bg-white border-2 border-dashed w-64 h-24 border-black p-5 flex items-center justify-center"
    >
        <button @click="triggerFileInput" class="flex">
            <div>Drag and</div>
            <Icon
                icon="material-symbols-light:water-drop"
                class="text-[#006692] size-6 ml-1"
            ></Icon>
        </button>
    </div>
    <input
        type="file"
        ref="fileInput"
        class="file:bg-white file:border-0 invisible"
        @input="form.avatar = $event.target.files[0]"
    />
</template>

<script setup>
import { ref } from "vue";
const fileInput = ref(null);
function triggerFileInput(event) {
    event.preventDefault();
    fileInput.value.click();
}
</script>
