<template>
    <div class="p-5">
        <label for="form_item" class="font-thin text-xl">{{
            $t(registerRoute + "." + name)
        }}</label>
        <Datepicker
            v-model="form.loan_end_date"
            :format-locale="lt"
            :enable-time-picker="false"
            :format="format"
            class="mt-1"
        ></Datepicker>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, inject } from "vue";
import Datepicker from "@vuepic/vue-datepicker";
import "../../css/custom-vue-datepicker.css";
import { lt } from "date-fns/locale";

let pageVariables = defineProps({
    form: Object,
    name: String,
    data: String,
    error: String,
});

let date = ref();
let registerRoute = inject("registerRoute");

onMounted(() => {
    const endDate = new Date(pageVariables.data);
    date.value = endDate;
    pageVariables.form.loan_end_date = date.value;
});

watch(date, (newDate) => {
    pageVariables.form.loan_end_date = newDate;
});

const format = (date) => {
    if (date) {
        return `${date.toLocaleDateString("lt-LT")}`;
    } else {
        return "Invalid date range";
    }
};
</script>
