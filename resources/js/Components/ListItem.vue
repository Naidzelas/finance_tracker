<template>
    <!-- String input -->
    <div v-if="list.dataType == 'String'" class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{ list.name }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-52 h-7">
            <!-- <span class="right-8 absolute text-gray-400">%</span> -->
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
    <div v-if="list.dataType == 'Number'" class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{ list.name }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-52 h-7">
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
    <DropDown v-if="list.dataType == 'Select'" :options="selectData[list.name]" :name="(list.name).toString()" :form="form"></DropDown>

    <!-- Boolean value input -->
    <div
        v-if="list.dataType == 'Boolean'"
        class="relative flex items-center mt-8 p-5"
    >
        <input
            :id="list.item"
            name="form_item"
            v-model="form[list.name]"
            type="checkbox"
            class="relative border-[#006692] border-1 checked:border-0 bg-white checked:bg-[#006692] mr-3 rounded-none cursor-pointer appearance-none peer shrink-0 size-7"
        />
        <label for="form_item" class="font-thin text-xl">{{ list.name }}</label>
        <Icon
            icon="material-symbols:check-rounded"
            class="peer-checked:block absolute hidden text-white pointer-events-none size-7"
        ></Icon>
    </div>

    <!-- Date value input -->
    <!-- <div v-if="pageVariables.list.dataType == 'Date'" class="relative p-5">
        <label for="form_item" class="font-thin text-xl"></label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-52 h-7">
        <div
                @click="yourCustomMethod"
                class="right-8 bottom-7 absolute text-gray-400"
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
import DropDown from "./DropDown.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "../../css/custom-vue-datepicker.css";
let pageVariables = defineProps({ list: Object, form: Object });

// onMounted(() => {
//     pageVariables.form[pageVariables.list.name] = pageVariables.list.value;
// });

let selectData = inject("selectData");
let date = ref("2020/01/01");
</script>
