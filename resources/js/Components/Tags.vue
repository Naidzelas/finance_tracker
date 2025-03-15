<template>
    <!-- TODO refactor this into components and styling -->
    <div class="p-5">
        <label for="form_item" class="font-thin text-xl">{{ name }}</label>
        <div
            class="flex flex-wrap bg-white mt-1 border-b-2 border-black w-fit max-w-[500px] h-auto overflow-x-auto transition ease-in"
        >
            <div
                v-for="(tag, index) in tags"
                class="flex bg-[#006692] mt-1 mb-1 ml-2 p-1 rounded-sm text-white hover:scale-105 transition"
                :style="{
                    maxWidth: 'calc(100% - 2rem)',
                    whiteSpace: 'nowrap',
                    overflow: 'hidden',
                    textOverflow: 'ellipsis',
                }"
            >
                <div class="self-center text-sm grow">
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
                class="block pl-3 w-full max-w-[320px] overflow-x-auto"
                :placeholder="name"
            />
        </div>
        <div v-if="newTag" class="absolute bg-white shadow-md mt-2 w-56">
            <div v-if="!tag_suggestions.length" class="absolute pl-2">
                {{ $t("general.no_matches_found") }}
            </div>
            <div class="flex flex-row-reverse h-6" :class="visible">
                <Icon
                    icon="icomoon-free:spinner2"
                    class="mt-1 mr-1 size-4 animate-spin"
                ></Icon>
            </div>
            <div
                v-for="(row, index) in tag_suggestions"
                class="flex flex-col hover:bg-slate-100 p-1 pl-4 text-sm cursor-pointer"
            >
                <div class="flex">
                    <input
                        type="checkbox"
                        v-model="row.checked"
                        class="peer bg-white checked:bg-[#006692] mt-[1%] mr-2 border border-[#006692] border-1 checked:border-0 rounded-none size-4 transition ease-in-out appearance-none cursor-pointer shrink-0"
                    />
                    <Icon
                        icon="material-symbols:check-rounded"
                        class="hidden peer-checked:block absolute mt-[1%] size-4 text-white pointer-events-none"
                    ></Icon>

                    <div @click="toggleCheck(index)" class="ml-2">
                        {{ row.transaction_name.slice(0, 20) }}
                    </div>
                </div>
            </div>
            <div v-if="tag_suggestions.length" class="mt-4 mb-2 text-center">
                <button
                    @click="addSelectedTags"
                    class="bg-orange-400 hover:bg-orange-500 px-4 text-white transition ease-in-out"
                >
                    {{ $t("general.confirm") }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, inject } from "vue";
import { router, usePage } from "@inertiajs/vue3";

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

const page = usePage();
const tags = ref([]);
const method = inject("method");
const registerRoute = page.url.split("/");
const newTag = ref("");
const tag_suggestions = ref([]);
let visible = ref("invisible");
let routeAction = [];

watch(
    () => newTag.value,
    (value) => {
        visible.value = "visible";
        switch (method) {
            case "put":
                routeAction = [
                    registerRoute[1] + ".edit",
                    { id: registerRoute[2] },
                ];
                break;
            case "post":
                routeAction = [registerRoute[1] + ".create"];
                break;
            default:
        }
        router.get(
            route(routeAction[0], routeAction[1]),
            { search: value },
            {
                replace: true,
                preserveState: true,
                only: ["selectData"],
                onSuccess: (page) => {
                    visible.value = "invisible";
                    tag_suggestions.value =
                        page.props.selectData.tag_suggestions.map(
                            (suggestion) => ({
                                ...suggestion,
                                checked: false, // Reset checked state
                            })
                        );
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

const toggleCheck = (index) => {
    tag_suggestions.value[index].checked =
        !tag_suggestions.value[index].checked;
};

const addSelectedTags = (event) => {
    event.preventDefault();
    const selectedTags = tag_suggestions.value
        .filter((suggestion) => suggestion.checked)
        .map((suggestion) => suggestion.transaction_name.slice(0, 20));
    tags.value.push(...selectedTags);
    pageVariables.form.tags = tags;
    tag_suggestions.value.forEach((suggestion) => (suggestion.checked = false));
};
</script>
