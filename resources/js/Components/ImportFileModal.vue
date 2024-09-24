<template>
    <div v-if="modal_state">
        <div
            class="fixed top-0 left-0 blur-sm opacity-80 w-full h-full bg-[#4D4D4D]"
        ></div>
        <div
            class="absolute inset-[45%] bg-[#D9D9D9] w-80 h-fit flex flex-col justify-center items-center"
        >
            <div class="text-2xl mb-6 pt-6">import documents</div>
            <div
                class="bg-white border-2 border-dashed border-black p-5 h-24 flex items-center justify-center w-[90%]"
            >
                <button @click="$refs.file.click()" class="flex">
                    <div>Drag and</div>
                    <Icon
                        icon="material-symbols-light:water-drop"
                        class="text-[#006692] size-6 ml-1"
                    ></Icon>
                </button>
            </div>
            <input
                type="file"
                ref="file"
                class="file:bg-white file:border-0 invisible"
                @input="form.avatar = $event.target.files[0]"
            />
            <button
                @click="modalToggle(false)"
                class="bg-[#525252] w-[90%] pb-px text-center text-white text-xl mt-2"
            >
                CANCEL
            </button>

            <button
                type="submit"
                class="bg-[#006692] w-[90%] pb-px text-center text-white text-xl mt-2 mb-4"
            >
                CONFIRM
            </button>
        </div>
    </div>
</template>

<script setup>
import { inject } from "vue";
let modal_state = inject("modal_state");
function modalToggle(toggle) {
    modal_state.value = toggle;
}
</script>
