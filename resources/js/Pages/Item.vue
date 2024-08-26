<template>
    <section class="mr-40 ml-40">
        <div class="flex flex-col">
            <div class="text-5xl mb-2">
                add new {{ page.props.registerRoute }}
            </div>
            <div class="text-gray-500 text-lg mb-8 flex">
                <div>current goals</div>
                <div class="self-center">
                    <Icon icon="mdi:dot" class="size-8"></Icon>
                </div>
                <div>add new {{ page.props.registerRoute }}</div>
            </div>
        </div>
        <!-- input block -->
        <form @submit.prevent="form.post('/' + page.props.registerRoute)">
            <div class="flex flex-wrap ml-[-1em]">
                <ListItem
                    v-for="listItem in listObject"
                    :list="listItem"
                    :form="form"
                ></ListItem>
            </div>
            <div
                class="bg-white border-2 border-dashed border-black p-5 w-64 h-24 flex items-center justify-center"
            >
                <button @click="$refs.file.click()" class="flex">
                    <div>Drag and</div>
                    <Icon
                        icon="material-symbols-light:water-drop"
                        class="text-[#006692] size-6 ml-1"
                    ></Icon>
                </button>
            </div>
            <input
                type="file"
                ref="file"
                class="file:bg-white file:border-0 invisible"
                @input="form.avatar = $event.target.files[0]"
            />

            <!-- input block end -->
            <div class="w-full mt-1 bg-gray-400 h-px"></div>
            <div class="flex justify-end space-x-2">
                <button
                    class="bg-[#525252] w-40 pb-px text-center text-white text-xl mt-2"
                >
                    CANCEL
                </button>

                <button
                    type="submit"
                    class="bg-[#006692] w-40 pb-px text-center text-white text-xl mt-2"
                >
                    CONFIRM
                </button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import ListItem from "../Components/ListItem.vue";
defineProps({ registerRoute: String, list: Object });
const page = usePage();
const formObject = {};
const listObject = {};
Object.entries(page.props.list).forEach(
    (el) => (
        (listObject[el[0]] = { dataType: el[1], value: null, name: el[0] }),
        (formObject[el[0]] = null)
    )
);
const form = useForm(formObject);
</script>
