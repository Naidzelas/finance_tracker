<template>
    <div class="bg-[#FEEDDD] h-screen">
        <div class="flex justify-center md:justify-start pt-10 md:pl-10">
            <img src="/./storage/app/public/images/Group 31.svg" />
        </div>
        <div class="mt-24 mr-10 2xl:mr-40 ml-10 2xl:ml-40">
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
                        Welcome to Finance Tracker
                    </h1>
                    <p class="text-lg">
                        This introduction will help you set up your personal
                        finance tracking. Follow the steps to configure your
                        income and budget categories.
                    </p>
                </div>
            </div>
            <div class="bg-white shadow-md p-6 rounded-md">
                <Stepper value="1">
                    <StepList>
                        <Step value="1">Introduction</Step>
                        <Step value="2">Income & Budget Setup</Step>
                        <Step value="3">Header III</Step>
                    </StepList>
                    <StepPanels>
                        <StepPanel v-slot="{ activateCallback }" value="1">
                            <div class="p-4">
                                <h2 class="mb-4 font-semibold text-xl">
                                    About Finance Tracker
                                </h2>
                                <p class="mb-3">
                                    Finance Tracker is a powerful tool designed
                                    to help you manage your personal finances
                                    with ease. With this application, you can:
                                </p>
                                <ul class="mb-3 pl-6 list-disc">
                                    <li>Track your income and expenses</li>
                                    <li>Create and manage budget categories</li>
                                    <li>
                                        Set financial goals and monitor your
                                        progress
                                    </li>
                                    <li>
                                        Visualize your spending with detailed
                                        charts and reports
                                    </li>
                                    <li>Track investments and debts</li>
                                </ul>
                                <p class="mb-3">
                                    In the next steps, we'll help you set up
                                    your initial income and budget allocation to
                                    get started on your financial journey.
                                </p>
                            </div>
                            <div class="flex justify-end pt-6">
                                <Button
                                    label="Next"
                                    severity="contrast"
                                    @click="activateCallback('2')"
                                />
                            </div>
                        </StepPanel>
                        <StepPanel v-slot="{ activateCallback }" value="2">
                            <div class="p-4">
                                <h2 class="mb-4 font-semibold text-xl">
                                    Setup Your Income and Budget Categories
                                </h2>
                                <div class="mb-6 w-[20em]">
                                    <label class="block mb-2 font-semibold"
                                        >Your Monthly Income</label
                                    >
                                    <InputGroup>
                                        <InputGroupAddon>€</InputGroupAddon>
                                        <InputNumber
                                            v-model="income"
                                            type="number"
                                            placeholder="Enter your income"
                                            @input="calculateRemaining"
                                        />
                                    </InputGroup>
                                </div>

                                <BlockUI :blocked="!income">
                                    <div class="mb-6">
                                        <div class="flex justify-between mb-2">
                                            <label class="font-semibold"
                                                >Budget Categories</label
                                            >
                                            <Button
                                                label="Add Budget Item"
                                                @click="addBudgetItem"
                                                :disabled="!income"
                                                class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md text-white"
                                            />
                                        </div>

                                        <div
                                            v-if="budgetItems.length === 0"
                                            class="text-gray-500 italic"
                                        >
                                            Add budget categories to allocate
                                            your income
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
                                                    <InputGroup>
                                                        <InputText
                                                            v-model="item.name"
                                                            placeholder="Category name (e.g. Food, Housing)"
                                                            @input="
                                                                updateItemId(
                                                                    index
                                                                )
                                                            "
                                                        />
                                                        <InputNumber
                                                            v-model="
                                                                item.amount
                                                            "
                                                            :id="item.id"
                                                            :max="
                                                                getMaxAmount(
                                                                    index
                                                                )
                                                            "
                                                            @input="
                                                                calculateRemaining
                                                            "
                                                        />
                                                    </InputGroup>
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
                                                            class="size-6"
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
                                                <span class="font-semibold"
                                                    >Remaining to
                                                    allocate:</span
                                                >
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
                                    label="Back"
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
                                    About Finance Tracker
                                </h2>
                                END
                            </div>
                            <div class="flex justify-between pt-6">
                                <Button
                                    label="Back"
                                    severity="warn"
                                    @click="activateCallback('2')"
                                />
                                <Button
                                    label="Finish"
                                    severity="contrast"
                                    @click="activateCallback('3')"
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

const activeStep = ref(1);
const income = ref(null);
const budgetItems = ref([]);
const remainingAmount = ref(0);

function addBudgetItem() {
    budgetItems.value.push({
        id: "",
        name: "",
        amount: 0,
    });
}

function removeBudgetItem(index) {
    budgetItems.value.splice(index, 1);
    calculateRemaining();
}

function updateItemId(index) {
    if (budgetItems.value[index].name) {
        // Create kebab-case id from name
        budgetItems.value[index].id = budgetItems.value[index].name
            .toLowerCase()
            .replace(/\s+/g, "-")
            .replace(/[^a-z0-9-]/g, "");
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
</script>
