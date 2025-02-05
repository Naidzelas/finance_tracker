<template>
    <div class="mt-2 text-2xl text-start mr">{{ name }}</div>
    <div class="bg-gray-400 mt-1 mb-6 w-full h-px"></div>
    <table v-if="tableData" class="table-fixed w-full text-left">
        <thead>
            <tr>
                <th v-for="item in tableHead">{{ item }}</th>
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
defineProps({
    name: String,
    tableData: Object,
    tableHead: Object,
});

// let data = inject('data');
</script>
