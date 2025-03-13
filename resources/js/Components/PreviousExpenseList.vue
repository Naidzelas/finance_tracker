<template>
    <div class="relative border h-lvh text-center">
        <div class="relative flex">
            <div class="bg-[white] mb-2 border-6 rounded w-52 h-8 text-lg">
                {{ getPreviousDate() }}
            </div>
            <div class="flex-auto"></div>
            <div>
                <VueDatePicker v-model="month" :format-locale="lt" month-picker>
                    <template #trigger>
                        <div
                            class="place-items-center grid bg-[#3C3C3C] rounded-md size-8 hover:cursor-pointer"
                        >
                            <Icon
                                icon="ion:calendar"
                                color="white"
                                class="size-6"
                            ></Icon>
                        </div>
                    </template>
                </VueDatePicker>
            </div>

            <div
                @click="navToggle(true)"
                class="place-items-center grid bg-[#3C3C3C] ml-1 rounded-md size-8"
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
            v-if="visibility.menu_visible"
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
        <div class="clear-both' columns-3 bg-[#7B7B7B] border-2 'rounded h-10">
            <div class="pt-1 font-bold text-[white]">{{$t('expenses.expense_name')}}</div>
            <div class="pt-1 font-bold text-[white]">{{$t('expenses.amount')}}</div>
            <div class="pt-1 font-bold text-[white]">{{$t('expenses.date')}}</div>
        </div>
        <ExpenseListItem :data="previous_expenses"></ExpenseListItem>
    </div>
</template>

<script setup>
import ExpenseListItem from "../Components/ExpenseListItem.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { lt } from "date-fns/locale";
import { router } from "@inertiajs/vue3";
import { ref, watch, reactive, onMounted } from "vue";

const pageVariables = defineProps({
    previous_expenses: Object,
    budget_types: Object,
});

const month = ref({
    month: new Date().getMonth(),
    year: new Date().getFullYear(),
});

watch(month, async (newMonth) => {
    let yearMonth = newMonth.year + "-" + (newMonth.month + 1);
    router.get(
        route("expense_list.fetch", {
            container: "previous_expenses",
            year_month: yearMonth,
        })
    );
});

let visibility = reactive({
    menu_visible: false,
});

const types = ref([]);

function navToggle(toggle) {
    types.value = [];
    visibility.menu_visible = toggle;
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
                container: "previous_expenses",
                budget_types: types.value,
            })
        );
    } else {
        router.visit("/", { only: ["previous_expenses"] });
    }
}

// TODO fix this when no data.
function getPreviousDate(){
    if (typeof pageVariables.previous_expenses[0] !== "undefined") {
        return new Date(
            pageVariables.previous_expenses[0]["date"]
        ).toLocaleDateString("lt-LT").substring(0, 7);
    }else{
        let previousDate = new Date();
        previousDate.setDate(0);
        return previousDate.toLocaleDateString("lt-LT").substring(0, 7)
    }
}
</script>
