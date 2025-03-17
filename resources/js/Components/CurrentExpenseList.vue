<template>
    <div class="relative border text-center">
        <div class="flex mr-3 lg:mr-0 ml-3 lg:ml-0">
            <div class="bg-[white] mb-2 border-6 rounded w-52 h-8 text-lg">
                {{ today.substring(0, 7) }}
            </div>
            <div class="flex-auto"></div>
            <div
                @click="navToggle(true)"
                class="place-items-center grid bg-[#3C3C3C] hover:bg-[#006692] ml-1 rounded-md size-8 cursor-pointer"
            >
                <Icon
                    icon="tabler:category-filled"
                    color="white"
                    class="size-6"
                ></Icon>
            </div>
        </div>
        <form
            @submit.prevent="submit"
            v-if="pageVariables.menu_visible"
            @pointerleave="navToggle(false)"
        >
            <div
                class="top-10 right-0 absolute gap-1 grid grid-cols-3 bg-white shadow-lg p-2 rounded-sm w-56"
            >
                <div v-for="(type, index) in budget_types">
                    <input
                        @click="selectType($event, type.id, index)"
                        type="checkbox"
                        :id="'budget_type-' + type.name"
                        class="sr-only peer"
                        name="budget_type"
                    />
                    <label
                        :for="'budget_type-' + type.name"
                        class="peer-checked:bg-[#006692] flex justify-center items-center hover:bg-slate-200 pt-2 pb-2 border rounded-sm peer-checked:text-white cursor-pointer"
                    >
                        <Icon
                            :icon="type.icon.iconify_name"
                            class="self-center size-6"
                        ></Icon>
                    </label>
                </div>
                <button
                    type="submit"
                    class="flex justify-center items-center bg-[#006692] hover:bg-[#005a92] pt-2 pb-2 border rounded-sm text-white cursor-pointer"
                >
                    <Icon
                        icon="material-symbols:search-rounded"
                        class="self-center size-6"
                    ></Icon>
                </button>
            </div>
        </form>
        <div class="flex bg-[#9E8167] py-1 border-2 rounded h-fit">
            <div class="flex-1 font-bold text-[white]">
                {{ $t("expenses.expense_name") }}
            </div>
            <div class="flex-1 font-bold text-[white]">
                {{ $t("expenses.amount") }}
            </div>
            <div class="flex-1 font-bold text-[white]">
                {{ $t("expenses.date") }}
            </div>
        </div>
        <ExpenseListItem :data="current_expenses"></ExpenseListItem>
    </div>
</template>
<script setup>
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import ExpenseListItem from "../Components/ExpenseListItem.vue";

defineProps({
    current_expenses: Object,
    budget_types: Object,
});

let pageVariables = reactive({
    menu_visible: false,
});

const types = ref([]);

function navToggle(toggle) {
    types.value = [];
    pageVariables.menu_visible = toggle;
}

const selectType = (event, type, index) => {
    if (types.value.includes(type)) {
        types.value.splice(index, 1);
    } else {
        types.value.push(type);
    }
};

// TODO add error message that no filter is picked.
function submit() {
    if (types.value.length) {
        router.get(
            route("expense_list.fetchByType", {
                container: "current_expenses",
                budget_types: types.value,
            })
        );
    } else {
        router.visit("/", { only: ["current_expenses"] });
    }
}

let segmentDate = new Date();
let today = segmentDate.toLocaleDateString("lt-LT");
</script>
