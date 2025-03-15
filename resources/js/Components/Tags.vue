<template>
    <div class="p-5">
        <label for="form_item" class="font-thin text-xl">{{ name }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-fit h-7">
            <div
                v-for="(tag, index) in tags"
                class="flex bg-[#006692] mt-1 mb-1 ml-2 p-1 rounded-sm w-full text-white hover:scale-105 transition"
            >
                <div class="self-center text-sm text-nowrap grow">
                    {{ tag }}
                </div>
                <Icon
                    @click="removeTag(index)"
                    icon="mdi:remove"
                    class="self-center ml-2 cursor-pointer"
                ></Icon>
            </div>
            <input
                @keypress.enter="addTag($event, newTag)"
                @keydown.prevent.tab="addTag($event, newTag)"
                :id="form.name"
                v-model="newTag"
                name="form_item"
                autocomplete="off"
                class="block pl-3 w-full"
                :placeholder="name"
            />
        </div>
        <div v-if="newTag" class="absolute bg-white shadow-md mt-2 w-52">
            <div v-if="!tag_suggestions.length" class="absolute pl-2">{{ $t('general.no_matches_found') }}</div>
            <div w class="flex flex-row-reverse h-6" :class="visible">
                <Icon
                    icon="icomoon-free:spinner2"
                    class="mt-1 mr-1 size-4 animate-spin"
                ></Icon>
            </div>
            <div
                v-for="row in tag_suggestions"
                @click="addTag($event, row.transaction_name.slice(0,20))"
                class="flex flex-col hover:bg-slate-100 p-1 pl-4 text-sm cursor-pointer"
            >
                <div>{{ row.transaction_name.slice(0,20) }}</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { router } from "@inertiajs/vue3";

let pageVariables = defineProps({
    form: Object,
    name: String,
    data: Array,
});

onMounted(() => {
    if (typeof pageVariables.data !== "undefined") {
        for (const value of pageVariables.data) {
            tags.value.push(value.tag);
        }
    }
});

const tags = ref([]);

const newTag = ref("");
const tag_suggestions = ref([]);
let visible = ref("invisible");

watch(
    () => newTag.value,
    (value) => {
        visible.value = "visible";
        router.get(
            route("budget.create"),
            { search: value },
            {
                replace: true,
                preserveState: true,
                only: ["selectData"],
                onSuccess: (page) => {
                    visible.value = "invisible";
                    tag_suggestions.value =
                        page.props.selectData.tag_suggestions;
                },
            }
        );
    }
);

const addTag = (event, tag) => {
    tags.value.push(tag);
    pageVariables.form.tags = tags;
    newTag.value = "";
    event.preventDefault();
};

const removeTag = (index) => {
    tags.value.splice(index, 1);
    pageVariables.form.tags = tags;
};
</script>
