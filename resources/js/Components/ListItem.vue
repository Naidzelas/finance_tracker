<template>
    <!-- String input -->
    <div v-if="list.dataType == 'String'" class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{
            $t(registerRoute + "." + list.name)
        }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-52 h-7">
            <input
                :id="list.name"
                v-model="form[list.name]"
                autocomplete="off"
                name="form_item[]"
                class="block pl-3 w-full"
                :placeholder="
                    $t(registerRoute + '.' + list.name).toLocaleLowerCase()
                "
            />
        </div>
        <div v-if="er[list.name]" class="text-red-500 text-sm">
            {{ er[list.name] }}
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
        <label for="form_item" class="font-thin text-xl">{{
            $t(registerRoute + "." + list.name)
        }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-52 h-7">
            <input
                :id="list.name"
                v-model="form[list.name]"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="
                    $t(registerRoute + '.' + list.name).toLocaleLowerCase()
                "
            />
        </div>
        <div v-if="er[list.name]" class="text-red-500 text-sm">
            {{ er[list.name] }}
        </div>
    </div>

    <!-- Select value input -->
    <DropDown
        v-if="list.dataType == 'Select'"
        :options="selectData[list.name]"
        :name="list.name.toString()"
        :form="form"
        :data="list.value"
        :error="er[list.name]"
        class="z-10"
    ></DropDown>

    <!-- Boolean value input -->
    <Checkbox
        v-if="list.dataType == 'Boolean'"
        :name="list.name.toString()"
        :form="form"
        :data="list.value ? true : false"
        :id="list.item"
        :error="er[list.name]"
    ></Checkbox>

    <!-- Date value input -->
    <Date
        v-if="pageVariables.list.dataType == 'Date'"
        :form="form"
        :name="list.name.toString()"
        :data="list.value"
        :error="er[list.name]"
    ></Date>
</template>

<script setup>
import { inject, onMounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import DropDown from "./DropDown.vue";
import Date from "./Date.vue";
import Tags from "./Tags.vue";
import Checkbox from "./Checkbox.vue";

let pageVariables = defineProps({ list: Object, form: Object, error: Object });
const page = usePage();
const er = computed(() => page.props.errors);

onMounted(() => {
    pageVariables.form[pageVariables.list.name] = pageVariables.list.value;
});

let selectData = inject("selectData");
let registerRoute = inject("registerRoute");
</script>
