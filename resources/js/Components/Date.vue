<template>
    <div class="p-5">
        <label for="form_item" class="font-thin text-xl">{{ name }}</label>
        <Datepicker
            v-model="form.loan_end_date"
            :format-locale="lt"
            :enable-time-picker="false"
            :format="format"
            class="mt-1"
        ></Datepicker>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import Datepicker from "@vuepic/vue-datepicker";
import "../../css/custom-vue-datepicker.css";
import { lt } from "date-fns/locale";

let pageVariables = defineProps({
    form: Object,
    name: String,
    data: Object,
});

let date = ref();

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
