<template>
    <section class="mr-10 2xl:mr-40 ml-10 2xl:ml-40">
        <AppHeader
            :breadcrumbs="breadcrumbs"
            :title="headerTitle"
            :subtitle="headerSubtitle"
            class="mb-10"
        ></AppHeader>
        <form @submit.prevent="handleForm(method)">
            <!-- input block -->
            <div class="md:flex md:flex-wrap mb-10 ml-[-1em]">
                <ListItem
                    v-for="listItem in listObject"
                    :list="listItem"
                    :form="form"
                ></ListItem>
            </div>
            <DragAndDrop
                v-if="Object.keys(listObject.avatar ?? {}).length"
                :form="form"
            ></DragAndDrop>
            <!-- input block end -->

            <div class="bg-gray-400 mt-1 w-full h-px"></div>
            <div class="flex justify-center md:justify-end space-x-2 mb-20">
                <Button
                    class="mt-2 pb-px w-full md:w-40"
                    @click="redirectBack"
                    text
                    severity="secondary"
                    ><div class="font-bold">
                        {{ $t("general.cancel") }}
                    </div></Button
                >

                <Button
                    type="submit"
                    class="mt-2 pb-px w-full md:w-40"
                    :disabled="form.processing"
                    ><div class="font-bold">
                        {{ $t("general.confirm") }}
                    </div></Button
                >
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm, usePage, Link, router } from "@inertiajs/vue3";
import { provide, ref, computed } from "vue";
import { Button } from "primevue";
import ListItem from "../Components/ListItem.vue";
import DragAndDrop from "../Components/DragAndDrop.vue";
import AppHeader from "../Components/AppHeader.vue";
import { useI18n } from "vue-i18n";

const props = defineProps({
    registerRoute: String,
    list: Object,
    selectData: Object,
    method: String,
    breadcrumbs: Object,
    customData: Object | String | Number,
});

const page = usePage();
const formObject = {};
const listObject = {};
const { t } = useI18n();

provide("selectData", page.props.selectData);
provide("method", page.props.method);
provide("data", page.props.data);
provide("customData", page.props.customData);
provide("registerRoute", page.props.registerRoute.split("/", 1) + "s");

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

// AppHeader integration
const headerTitle = computed(() =>
    t(props.registerRoute.split("/", 1) + "s.add_new")
);
const headerSubtitle = computed(
    () => `Add or edit your ${headerTitle.value.toLowerCase()}`
);

function redirectBack() {
    router.visit("/" + props.registerRoute.split("/")[0]);
}
function handleForm(method) {
    form.submit(method, "/" + page.props.registerRoute);
}
</script>
