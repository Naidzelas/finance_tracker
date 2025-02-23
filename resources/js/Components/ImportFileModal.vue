<template>
    <form @submit.prevent="handleSubmit" v-if="modal_state">
        <div
            class="top-0 left-0 fixed bg-[#4D4D4D] opacity-80 w-full h-full"
        ></div>
        <div
            class="absolute inset-[45%] flex flex-col justify-center items-center bg-[#D9D9D9] w-80 h-fit"
        >
            <div class="mb-6 pt-6 text-2xl">import documents</div>

            <div class="flex space-x-2 mb-2 w-[90%]">
                <div class="flex-1">
                    <input
                        type="radio"
                        id="seb"
                        name="bank"
                        v-model="form.bank"
                        value="seb"
                        class="peer/seb hidden"
                        checked
                    />
                    <label
                        for="seb"
                        class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/seb:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/seb:text-blue-600 cursor-pointer"
                        >SEB</label
                    >
                </div>
                <div class="flex-1">
                    <input
                        type="radio"
                        id="swed"
                        name="bank"
                        v-model="form.bank"
                        value="swed"
                        class="peer/swed hidden"
                    />
                    <label
                        for="swed"
                        class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/swed:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/swed:text-blue-600 cursor-pointer"
                        >SWEDBANK</label
                    >
                </div>
            </div>

            <div
                class="flex justify-center items-center bg-white p-5 border-2 border-black border-dashed w-[90%] h-24"
            >
                <button @click="triggerFileInput" class="flex">
                    <div>Drag and</div>
                    <Icon
                        icon="material-symbols-light:water-drop"
                        class="ml-1 size-6 text-[#006692]"
                    ></Icon>
                </button>
            </div>
            <input
                type="file"
                ref="fileInput"
                class="invisible file:bg-white file:border-0"
                @input="form.avatar = $event.target.files[0]"
            />
            <button
                @click="modalToggle(false)"
                class="bg-[#525252] mt-2 pb-px w-[90%] text-white text-xl text-center"
            >
                CANCEL
            </button>

            <button
                type="submit"
                class="bg-[#006692] mt-2 mb-4 pb-px w-[90%] text-white text-xl text-center"
            >
                CONFIRM
            </button>
        </div>
    </form>
</template>

<script setup>
import { inject, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
let modal_state = inject("modal_state");
const fileInput = ref(null);
const form = useForm({
    avatar: null,
    bank: "seb",
});

function triggerFileInput(event) {
    event.preventDefault();
    fileInput.value.click();
}

function modalToggle(toggle) {
    modal_state.value = toggle;
}

function handleSubmit() {
    form.post("/", { onFinish: () => modalToggle(false) });
}
</script>
