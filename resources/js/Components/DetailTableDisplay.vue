<template>
    <div class="text-2xl mt-2 mr text-start">{{name}}</div>
    <div class="w-full mt-1 bg-gray-400 h-px mb-6"></div>
    <table v-if="tableData" class="table-fixed w-full text-left">
        <thead>
            <tr>
                <th v-for="item in tableData.thead">{{ item }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in tableData.tbody" class="even:bg-[#D9D9D9]">
                <td>{{ item.Nr }}</td>
                <td>{{ item.Date }}</td>
                <td>{{ item.Paid }}</td>
                <td>{{ item.Progress }}</td>
                <td class="flex justify-end mr-10"><Icon icon="fa6-solid:trash"></Icon></td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
defineProps({
    name: String,
    tableData: Object
})

// let data = inject('data');
</script>
