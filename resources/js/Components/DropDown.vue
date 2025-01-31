<template>
    <div class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{ name }}</label>
        <div
            class="relative flex-col bg-white mt-1 border-b-2 border-black w-fit h-7"
        >
            <input
                @click="dropdown()"
                :id="name"
                name="form_item"
                v-model="value"
                class="block pl-3 w-full cursor-pointer"
                :placeholder="name"
                :value="value"
            />
            <div class="top-0 right-0 absolute place-items-center grid h-full">
                <Icon icon="ri:arrow-drop-down-line" class="size-5"></Icon>
            </div>
            <div class="bg-white shadow-md mt-3" :class="style" >
                <div
                    @click="selected(item.id, item.data)"
                    v-for="item in options"
                    class="flex items-center gap-2 hover:bg-slate-100 pr-3 h-10 hover:cursor-pointer"
                >
                    <div class="place-items-center grid pl-3">
                        <Icon
                            :icon="item.data"
                            class="text-slate-500 size-fit"
                        ></Icon>
                    </div>
                    {{ item.data }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

let pageVariables = defineProps({
    name: String,
    options: Object,
    form: Object,
});

const style = ref("invisible");
const value = ref();
function dropdown() {
    style.value = "visible";
    router.reload();
}

function selected(id, item) {
    pageVariables.form[pageVariables.name] = id;
    value.value = item;
    style.value = "invisible";
    router.reload();
}
</script>
