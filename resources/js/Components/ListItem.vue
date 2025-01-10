<template>
    <!-- String input -->
    <div v-if="list.dataType == 'String'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin">{{ list.name }}</label>
        <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1">
            <span class="absolute text-gray-400 right-8">%</span>
            <input
                :id="list.name"
                v-model="form[list.name]"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="list.name"
            />
        </div>
    </div>

    <!-- Number value input -->
    <div v-if="list.dataType == 'Number'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin">{{ list.name }}</label>
        <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1">
            <input
                :id="list.name"
                v-model="form[list.name]"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="list.name"
            />
        </div>
    </div>

    <!-- Select value input -->
    <div v-if="list.dataType == 'Select'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin">{{ list.name }}</label>
        <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1">
            <select
                class="bg-white w-full pl-3"
                :id="list.name"
                v-model="form[list.name]"
                name="form_item"
            >
                <option v-for="icon in icons" :value="icon.id">
                    {{ icon.iconify_name }}
                </option>
            </select>
        </div>
    </div>

    <!-- Boolean value input -->
    <div
        v-if="list.dataType == 'Boolean'"
        class="p-5 relative mt-8 flex items-center"
    >
        <input
            :id="list.item"
            name="form_item"
            v-model="form[list.name]"
            type="checkbox"
            class="relative appearance-none mr-3 size-7 bg-white rounded-none border-1 border-[##006692] checked:bg-[#006692] checked:border-0 cursor-pointer peer shrink-0"
        />
        <label for="form_item" class="text-xl font-thin">{{ list.name }}</label>
        <Icon
            icon="material-symbols:check-rounded"
            class="absolute size-7 hidden peer-checked:block text-white pointer-events-none"
        ></Icon>
    </div>

    <!-- Date value input -->
    <!-- <div v-if="pageVariables.list.dataType == 'Date'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin"></label>
        <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1">
        <div
                @click="yourCustomMethod"
                class="absolute text-gray-400 right-8 bottom-7"
            >
                <Icon icon="ion:calendar" class="size-4"></Icon>
            </div>
        <input
                :id="pageVariables.list.name"
                v-model="date"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="pageVariables.list.name"
            />
        <Datepicker ref="datepicker" v-model="date"></Datepicker>
        </div>
    </div> -->
</template>

<script setup>
import { ref, inject, onMounted } from "vue";
import Datepicker from "@vuepic/vue-datepicker";
import "../../css/custom-vue-datepicker.css";
let pageVariables = defineProps({ list: Object, form: Object });

onMounted(() => {
    pageVariables.form[pageVariables.list.name] = pageVariables.list.value;
});

let icons = inject("icons");
let date = ref("2020/01/01");
</script>
