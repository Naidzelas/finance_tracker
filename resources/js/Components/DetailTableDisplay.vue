<template>
    <div class="mt-2 text-2xl text-start mr">{{ $t("general." + name).toLocaleLowerCase() }}</div>
    <div class="bg-gray-400 mt-1 mb-6 w-full h-px"></div>
    <table v-if="tableData" class="w-full text-left table-fixed">
        <thead>
            <tr>
                <th v-for="item in tableHead">{{ $t(translate + '.' + item) }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in tableData" class="even:bg-[#D9D9D9]">
                <td v-for="item in row">{{ item }}</td>
                <td class="flex justify-end mr-10">
                    <Icon icon="fa6-solid:trash"></Icon>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { inject } from 'vue';
defineProps({
    name: String,
    tableData: Object,
    tableHead: Object,
});

let translate = inject('translate');
</script>
