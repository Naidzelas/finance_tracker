<template>
    <section class="mr-40 ml-40">
        <div class="flex flex-col">
            <div class="mb-2 text-5xl">
                add new {{ registerRoute }}
            </div>
            <div class="flex mb-8 text-gray-500 text-lg">
                <div>current goals</div>
                <div class="self-center">
                    <Icon icon="mdi:dot" class="size-8"></Icon>
                </div>
                <div>add new {{ registerRoute }}</div>
            </div>
        </div>
        <!-- input block -->
        <form @submit.prevent="handleForm(method)">
            <div class="flex flex-wrap ml-[-1em]">
                <ListItem
                    v-for="listItem in listObject"
                    :list="listItem"
                    :form="form"
                ></ListItem>
            </div>
            <!-- Don't forget to undo HIDDEN -->
            <DragAndDrop></DragAndDrop>
            <!-- input block end -->
            <div class="bg-gray-400 mt-1 w-full h-px"></div>
            <div class="flex justify-end space-x-2">
                <Link
                    href="/"
                    class="bg-[#525252] mt-2 pb-px w-40 text-center text-white text-xl"
                >
                    CANCEL
                </Link>

                <button
                    type="submit"
                    class="bg-[#006692] mt-2 pb-px w-40 text-center text-white text-xl"
                >
                    CONFIRM
                </button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { provide } from "vue";
import ListItem from "../Components/ListItem.vue";
import DragAndDrop from "../Components/DragAndDrop.vue";
defineProps({
    registerRoute: String,
    list: Object,
    selectData: Object,
    method: String,
});
const page = usePage();
const formObject = {};
const listObject = {};
provide("selectData", page.props.selectData);
provide("data", page.props.data);

Object.entries(page.props.list).forEach(
    (el) => (
        (listObject[el[0]] = {
            dataType: el[1][0],
            value: el[1][1],
            name: el[0],
        }),
        (formObject[el[0]] = null)
    )
);
const form = useForm(formObject);

function handleForm(method){
    form.submit(method, '/' + page.props.registerRoute, form)
}
</script>
