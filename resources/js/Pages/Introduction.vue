<template>
    <div class="bg-[#FEEDDD] h-screen">
        <div class="flex justify-center md:justify-start pt-10 md:pl-10">
            <img src="/./storage/app/public/images/Group 31.svg" />
        </div>
        <div class="mt-24 mr-10 2xl:mr-40 ml-10 2xl:ml-40">
            <div class="md:top-10 md:-left-16 float-end relative flex gap-2">
                <LanguageSelect></LanguageSelect>
            </div>
            <div
            class="flex md:flex-row flex-col bg-white shadow-md mb-10 p-6 px-20 rounded-md"
            >
            <div class="flex-shrink-0 md:mr-8">
                <img
                src="\.\storage\app\public\images\cat.png"
                class="size-36 md:size-60 scale-x-[-1]"
                />
            </div>
            <div class="flex flex-col justify-center mt-4 md:mt-0">
                <h1 class="mb-4 font-bold text-3xl">
                        {{ $t("introduction.welcome") }}
                    </h1>
                    <p class="text-lg">
                        {{ $t("introduction.introduction_intro") }}
                    </p>
                </div>
            </div>
            <div class="bg-white shadow-md p-6 rounded-md">
                <Stepper value="1">
                    <StepList>
                        <Step value="1">{{
                            $t("introduction.introduction")
                        }}</Step>
                        <Step value="2">{{
                            $t("introduction.income_and_budget_step")
                        }}</Step>
                        <Step value="3">{{
                            $t("introduction.setup_parameters")
                        }}</Step>
                    </StepList>
                    <StepPanels>
                        <StepPanel v-slot="{ activateCallback }" value="1">
                            <div class="p-4">
                                <h2 class="mb-4 font-semibold text-xl">
                                    {{
                                        $t(
                                            "introduction.introduction_step_title"
                                        )
                                    }}
                                </h2>
                                <p class="mb-3">
                                    {{
                                        $t(
                                            "introduction.introduction_step_text_header"
                                        )
                                    }}
                                </p>
                                <ul class="mb-3 pl-6 list-disc">
                                    <li>
                                        {{
                                            $t(
                                                "introduction.introduction_step_list.1"
                                            )
                                        }}
                                    </li>
                                    <li>
                                        {{
                                            $t(
                                                "introduction.introduction_step_list.2"
                                            )
                                        }}
                                    </li>
                                    <li>
                                        {{
                                            $t(
                                                "introduction.introduction_step_list.3"
                                            )
                                        }}
                                    </li>
                                    <li>
                                        {{
                                            $t(
                                                "introduction.introduction_step_list.4"
                                            )
                                        }}
                                    </li>
                                    <li>
                                        {{
                                            $t(
                                                "introduction.introduction_step_list.5"
                                            )
                                        }}
                                    </li>
                                </ul>
                                <p class="mb-3">
                                    {{
                                        $t(
                                            "introduction.introdution_step_text_footer"
                                        )
                                    }}
                                </p>
                            </div>
                            <div class="flex justify-end pt-6">
                                <Button
                                    :label="$t('introduction.next')"
                                    severity="contrast"
                                    @click="activateCallback('2')"
                                />
                            </div>
                        </StepPanel>
                        <StepPanel v-slot="{ activateCallback }" value="2">
                            <div class="p-4">
                                <h2 class="mb-4 font-semibold text-xl">
                                    {{
                                        $t(
                                            "introduction.setup_parameters_step_title"
                                        )
                                    }}
                                </h2>
                                <div class="mb-6 w-[20em]">
                                    <label class="block mb-2 font-semibold">{{
                                        $t("introduction.your_monthly_income")
                                    }}</label>
                                    <InputGroup>
                                        <InputGroupAddon>€</InputGroupAddon>
                                        <InputNumber
                                            v-model="income"
                                            type="number"
                                            :placeholder="
                                                $t(
                                                    'introduction.setup_income_input'
                                                )
                                            "
                                        />
                                    </InputGroup>
                                </div>

                                <BlockUI :blocked="!income">
                                    <div class="mb-6">
                                        <div class="flex justify-between mb-2">
                                            <label class="font-semibold">{{
                                                $t(
                                                    "introduction.setup_budget_title"
                                                )
                                            }}</label>
                                            <Button
                                                :label="
                                                    $t(
                                                        'introduction.add_buddget_item'
                                                    )
                                                "
                                                @click="addBudgetItem"
                                                :disabled="!income"
                                                class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md text-white"
                                            />
                                        </div>

                                        <div
                                            v-if="budgetItems.length === 0"
                                            class="text-gray-500 italic"
                                        >
                                            {{
                                                $t(
                                                    "introduction.setup_budget_explanation"
                                                )
                                            }}
                                        </div>

                                        <div
                                            class="lg:gap-6 lg:grid lg:grid-cols-4 mb-4"
                                        >
                                            <div
                                                v-for="(
                                                    item, index
                                                ) in budgetItems"
                                                :key="index"
                                            >
                                                <div class="flex gap-2 mb-4">
                                                    <InputText
                                                        class="w-[60%]"
                                                        v-model="item.name"
                                                        :placeholder="
                                                            $t(
                                                                'introduction.setup_budget_input'
                                                            )
                                                        "
                                                        @input="
                                                            updateItemId(index)
                                                        "
                                                    />
                                                    <InputNumber
                                                        class="2xl:w-[50%] h-full"
                                                        :disabled="!item.name"
                                                        v-model="item.amount"
                                                        :id="item.id"
                                                        :max="
                                                            getMaxAmount(index)
                                                        "
                                                        @input="
                                                            calculateRemaining
                                                        "
                                                    />
                                                    <Button
                                                        severity="danger"
                                                        @click="
                                                            removeBudgetItem(
                                                                index
                                                            )
                                                        "
                                                    >
                                                        <Icon
                                                            icon="mdi:delete"
                                                            class="w-10 size-6"
                                                        />
                                                    </Button>
                                                </div>
                                                <Slider
                                                    v-model="item.amount"
                                                    :min="0"
                                                    :max="getMaxAmount(index)"
                                                    class="mb-4 w-full"
                                                    @change="calculateRemaining"
                                                />
                                            </div>
                                        </div>

                                        <div
                                            v-if="budgetItems.length > 0"
                                            class="bg-gray-100 mt-4 p-3 rounded-md"
                                        >
                                            <div class="flex justify-between">
                                                <span class="font-semibold">{{
                                                    $t(
                                                        "introduction.remaining_allocation"
                                                    )
                                                }}</span>
                                                <span
                                                    :class="{
                                                        'text-red-500':
                                                            remainingAmount < 0,
                                                        'text-green-500':
                                                            remainingAmount > 0,
                                                    }"
                                                >
                                                    €
                                                    {{
                                                        remainingAmount.toFixed(
                                                            2
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </BlockUI>
                            </div>
                            <div class="flex justify-between pt-6">
                                <Button
                                    :label="$t('introduction.previous')"
                                    severity="warn"
                                    @click="activateCallback('1')"
                                />
                                <Button
                                    label="Next"
                                    severity="contrast"
                                    @click="activateCallback('3')"
                                />
                            </div>
                        </StepPanel>
                    </StepPanels>
                    <StepPanel v-slot="{ activateCallback }" value="3">
                        <div class="p-4">
                            <h2 class="mb-4 font-semibold text-xl">
                                {{ $t("introduction.parameters_title") }}
                            </h2>
                            WORK IN PROGRESS
                        </div>
                        <div class="flex justify-between pt-6">
                            <Button
                                :label="$t('introduction.previous')"
                                severity="warn"
                                @click="activateCallback('2')"
                            />
                            <Button
                                :label="$t('introduction.finish')"
                                severity="contrast"
                                @click="handleSubmit"
                            />
                        </div>
                    </StepPanel>
                </Stepper>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import Stepper from "primevue/stepper";
import StepList from "primevue/steplist";
import StepPanels from "primevue/steppanels";
import Step from "primevue/step";
import StepPanel from "primevue/steppanel";
import { Button } from "primevue";
import { InputText, InputNumber, InputGroupAddon, InputGroup } from "primevue";
import { BlockUI } from "primevue";
import { Slider } from "primevue";
import { router } from "@inertiajs/vue3";
import LanguageSelect from "../Components/LanguageSelect.vue";

// Form object to store all form data
const form = ref({
    income: null,
    budgetItems: [],
});

const income = ref(null);
const budgetItems = ref([]);
const remainingAmount = ref(0);

function addBudgetItem() {
    budgetItems.value.push({
        id: "",
        name: "",
        amount: 0,
    });

    // Also add to form object
    form.value.budgetItems.push({
        id: "",
        name: "",
        amount: 0,
    });
}

function removeBudgetItem(index) {
    budgetItems.value.splice(index, 1);
    form.value.budgetItems.splice(index, 1);
    calculateRemaining();
}

function updateItemId(index) {
    if (budgetItems.value[index].name) {
        budgetItems.value[index].id = budgetItems.value[index].name
            .toLowerCase()
            .replace(/\s+/g, "-")
            .replace(/[^a-z0-9-]/g, "");

        // Also update in form object
        form.value.budgetItems[index].id = budgetItems.value[index].id;
    }
}

function calculateRemaining() {
    const total = budgetItems.value.reduce(
        (sum, item) => sum + (Number(item.amount) || 0),
        0
    );
    remainingAmount.value = Number(income.value || 0) - total;
}

function getMaxAmount(index) {
    const currentItem = budgetItems.value[index];
    const otherItemsTotal = budgetItems.value.reduce((sum, item, i) => {
        return i !== index ? sum + (Number(item.amount) || 0) : sum;
    }, 0);

    return Number(income.value || 0) - otherItemsTotal;
}

watch(
    income,
    (newValue) => {
        form.value.income = newValue;
        calculateRemaining();
    },
    { immediate: true }
);

// Sync budgetItems with form.budgetItems
watch(
    budgetItems,
    (newValue) => {
        form.value.budgetItems = JSON.parse(JSON.stringify(newValue));
        calculateRemaining();
    },
    { deep: true }
);

// Also watch the form object to keep the UI in sync
watch(
    () => form.value.income,
    (newValue) => {
        income.value = newValue;
    }
);

watch(
    () => form.value.budgetItems,
    (newValue) => {
        // Only update if there's an actual difference to avoid loops
        if (JSON.stringify(newValue) !== JSON.stringify(budgetItems.value)) {
            budgetItems.value = JSON.parse(JSON.stringify(newValue));
        }
    },
    { deep: true }
);

function handleSubmit() {
    router.post(route("introduction.store"), form.value);
}
</script>
