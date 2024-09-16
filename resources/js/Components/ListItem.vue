<template>
    <!-- String input -->
    <div v-if="pageVariables.list.dataType == 'String'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin">{{
            pageVariables.list.name
        }}</label>
        <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1">
            <span class="absolute text-gray-400 right-8">%</span>
            <input
                :id="pageVariables.list.name"
                v-model="pageVariables.form[pageVariables.list.name]"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="pageVariables.list.name"
            />
        </div>
    </div>
    <!-- Integer value input -->
    <div v-if="pageVariables.list.dataType == 'Integer'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin">{{
            pageVariables.list.name
        }}</label>
        <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1">
            <span class="absolute text-gray-400 right-8">%</span>
            <input
                :id="pageVariables.list.name"
                v-model="pageVariables.form[pageVariables.list.name]"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="pageVariables.list.name"
            />
        </div>
    </div>
    <!-- Date value input -->
    <div v-if="pageVariables.list.dataType == 'Date'" class="p-5 relative">
        <label for="form_item" class="text-xl font-thin">{{
            pageVariables.list.name
        }}</label>
        <!-- <div class="flex bg-white border-b-2 border-black w-52 h-7 mt-1"> -->
            <!-- <div
                @click="yourCustomMethod"
                class="absolute text-gray-400 right-8 bottom-7"
            >
                <Icon icon="ion:calendar" class="size-4"></Icon>
            </div> -->
            <!-- <input
                :id="pageVariables.list.name"
                v-model="date"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="pageVariables.list.name"
            /> -->
            <Datepicker ref="datepicker" v-model="date"></Datepicker>
        <!-- </div> -->
    </div>
</template>

<script setup>
import { ref } from "vue";
import Datepicker from '@vuepic/vue-datepicker';
import '../../css/custom-vue-datepicker.css';
let pageVariables = defineProps({ list: Object, form: Object });
let date = ref("2020/01/01");
</script>
