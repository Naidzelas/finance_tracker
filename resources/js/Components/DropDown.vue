<template>
    <div class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{ $t(registerRoute + "." + name) }}</label>
        <div
            class="relative flex-col bg-white mt-1 border-b-2 border-black md:w-fit h-7"
        >
            <input
                @click="dropdown()"
                autocomplete="off"
                :id="name"
                name="form_item"
                v-model="value"
                class="block pl-3 w-full cursor-pointer"
                :placeholder="$t(registerRoute + '.' + name).toLocaleLowerCase()"
                :value="value"
            />
            <div class="top-0 right-0 absolute place-items-center grid h-full">
                <Icon icon="ri:arrow-drop-down-line" class="size-5"></Icon>
            </div>
            <div class="bg-white shadow-md mt-3" :class="style">
                <div
                    @click="selected(item.id, item.data)"
                    v-for="item in options"
                    class="flex items-center gap-2 hover:bg-slate-100 pr-3 h-10 hover:cursor-pointer"
                >
                    <div class="place-items-center grid pl-3">
                        <Icon
                            :icon="item.data"
                            class="size-fit text-slate-500"
                        ></Icon>
                    </div>
                    {{ item.data }}
                </div>
            </div>
        </div>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
    </div>
</template>

<script setup>
import { ref, onMounted, inject } from "vue";

let pageVariables = defineProps({
    name: String,
    options: Object,
    form: Object,
    data: String|Number,
    error: String,
});

const style = ref("invisible");
let registerRoute = inject("registerRoute");
const value = ref();

// TODO ugly, need refactor.
onMounted(() => {
    if (typeof(pageVariables.data) !== 'undefined') {
        value.value = pageVariables.options[pageVariables.data-1].data;
        pageVariables.form[pageVariables.name] = pageVariables.options[pageVariables.data-1].id;
    }
});

function dropdown() {
    style.value = "visible";
}

function selected(id, item) {
    pageVariables.form[pageVariables.name] = id;
    value.value = item;
    style.value = "invisible";
}
</script>
