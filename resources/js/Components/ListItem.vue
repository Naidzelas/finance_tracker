<template>
    <!-- String input -->
    <div v-if="list.dataType == 'String'" class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{ list.name }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-52 h-7">
            <input
                :id="list.name"
                v-model="form[list.name]"
                name="form_item[]"
                class="block pl-3 w-full"
                :placeholder="list.name"
            />
        </div>
    </div>
    <!-- Tags input -->
    <Tags
        v-if="pageVariables.list.dataType == 'Tag'"
        :form="form"
        :name="list.name.toString()"
        :data="list.value"
    ></Tags>

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
    <DropDown
        v-if="list.dataType == 'Select'"
        :options="selectData[list.name]"
        :name="list.name.toString()"
        :form="form"
        :data="list.value"
    ></DropDown>

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
            class="peer relative bg-white checked:bg-[#006692] mr-3 border-[#006692] border-1 checked:border-0 rounded-none size-7 appearance-none cursor-pointer shrink-0"
        />
        <label for="form_item" class="font-thin text-xl">{{ list.name }}</label>
        <Icon
            icon="material-symbols:check-rounded"
            class="hidden peer-checked:block absolute size-7 text-white pointer-events-none"
        ></Icon>
    </div>

    <!-- Date value input -->
    <Date
        v-if="pageVariables.list.dataType == 'Date'"
        :form="form"
        :name="list.name.toString()"
        :data="list.value"
    ></Date>
</template>

<script setup>
import { inject, onMounted } from "vue";
import DropDown from "./DropDown.vue";
import Date from "./Date.vue";
import Tags from "./Tags.vue";

let pageVariables = defineProps({ list: Object, form: Object });

onMounted(() => {
    pageVariables.form[pageVariables.list.name] = pageVariables.list.value;
});

let selectData = inject("selectData");
</script>
