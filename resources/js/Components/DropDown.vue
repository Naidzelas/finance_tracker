<template>
    <div class="relative p-5">
        <label for="form_item" class="font-thin text-xl">{{
            $t(registerRoute + "." + name)
        }}</label>
        <div
            class="relative flex-col bg-white mt-1 border-b-2 border-black md:w-fit h-7"
        >
            <input
                @click="dropdown()"
                @input="handleInput"
                autocomplete="off"
                :id="name"
                name="form_item"
                v-model="value"
                class="block pl-3 w-full"
                :placeholder="
                    $t(registerRoute + '.' + name).toLocaleLowerCase()
                "
                :value="value"
            />
            <div class="top-0 right-0 absolute place-items-center grid h-full">
                <Icon icon="ri:arrow-drop-down-line" class="size-5"></Icon>
            </div>

            <!-- Loading indicator -->
            <div
                v-if="isLoading"
                class="top-0 right-6 absolute place-items-center grid h-full"
            >
                <Icon
                    icon="icomoon-free:spinner2"
                    class="size-4 animate-spin"
                ></Icon>
            </div>

            <div
                class="bg-white shadow-md mt-3 max-h-60 overflow-y-auto"
                :class="style"
                v-if="showDefaultOptions"
            >
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

            <!-- Suggestions dropdown -->
            <div
                class="bg-white shadow-md mt-3 max-h-60 overflow-y-auto"
                :class="style"
                v-if="suggestions.length && !showDefaultOptions"
            >
                <div
                    @click="selectedSuggestion(suggestion)"
                    v-for="suggestion in suggestions"
                    class="flex items-center gap-2 hover:bg-slate-100 px-3 py-2 hover:cursor-pointer"
                >
                    <Icon :icon="suggestion"></Icon>
                    {{
                        suggestion.transaction_name ||
                        suggestion.data ||
                        suggestion
                    }}
                </div>
            </div>

            <div
                v-if="
                    suggestions.length === 0 &&
                    value &&
                    !showDefaultOptions &&
                    style === 'visible'
                "
                class="bg-white shadow-md mt-3 p-3 text-gray-500"
            >
                {{ $t("general.no_matches_found") }}
            </div>
        </div>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
    </div>
</template>

<script setup>
import { ref, onMounted, inject } from "vue";
import { router, usePage } from "@inertiajs/vue3";

let pageVariables = defineProps({
    name: String,
    options: Object,
    form: Object,
    data: String | Number,
    error: String,
});

const style = ref("invisible");
let registerRoute = inject("registerRoute");
const value = ref();
const suggestions = ref([]);
const method = inject("method");
const isLoading = ref(false);
const showDefaultOptions = ref(true);
const page = usePage();

// TODO ugly, need refactor.
onMounted(() => {
    if (typeof pageVariables.data !== "undefined") {
        value.value = pageVariables.data;
        pageVariables.form[pageVariables.name] = value.value;
    }
});

function dropdown() {
    style.value ??= "visible";
    showDefaultOptions.value = true;
}

function selected(id, item) {
    pageVariables.form[pageVariables.name] = id;
    value.value = item;
    style.value = "invisible";
}

function selectedSuggestion(suggestion) {
    // Handle different suggestion formats
    const suggestionValue =
        suggestion.transaction_name || suggestion.data || suggestion;
    const suggestionId = suggestion.id || "";

    pageVariables.form[pageVariables.name] = suggestionId || suggestionValue;
    value.value = suggestionValue;
    style.value = "invisible";
}

function handleInput() {
    if (value.value && value.value.length >= 1) {
        showDefaultOptions.value = false;
        fetchSuggestions(value.value);
    } else {
        showDefaultOptions.value = true;
        suggestions.value = [];
    }

    if (style.value === "invisible") {
        style.value = "visible";
    }
}

// Debounce helper function to prevent too many requests
function debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
}

const fetchSuggestions = debounce((searchValue) => {
    if (!searchValue) return;

    isLoading.value = true;
    const currentRoute = page.url.split("/");
    let routeAction = [];

    switch (method) {
        case "put":
            routeAction = [currentRoute[1] + ".edit", { id: currentRoute[2] }];
            break;
        case "post":
            routeAction = [currentRoute[1] + ".create"];
            break;
        default:
            return;
    }

    const searchParam =
        pageVariables.name === "iconify_name" ? "suggestIcon" : "search";

    router.get(
        route(routeAction[0], routeAction[1]),
        { [searchParam]: searchValue },
        {
            replace: true,
            preserveState: true,
            only: ["selectData"],
            onSuccess: (page) => {
                isLoading.value = false;

                // Handle different suggestion types based on field
                if (pageVariables.name === "iconify_name") {
                    suggestions.value =
                        page.props.selectData.iconify_name || [];
                } else {
                    suggestions.value =
                        page.props.selectData.tag_suggestions || [];
                }
            },
            onError: () => {
                isLoading.value = false;
            },
        }
    );
}, 300);
</script>
