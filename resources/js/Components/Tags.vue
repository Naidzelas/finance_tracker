<template>
    <div class="p-5">
        <label for="form_item" class="font-thin text-xl">{{ name }}</label>
        <div class="flex bg-white mt-1 border-b-2 border-black w-fit h-7">
            <div
                v-for="(tag, index) in tags"
                class="flex bg-[#006692] mt-1 mb-1 ml-2 p-1 rounded-sm w-full text-white hover:scale-110"
            >
                <div class="self-center text-sm text-nowrap grow">
                    {{ tag }}
                </div>
                <Icon
                    @click="removeTag(index)"
                    icon="mdi:remove"
                    class="self-center ml-2 cursor-pointer"
                ></Icon>
            </div>
            <input
                @keypress.enter="addTag($event, newTag)"
                @keydown.prevent.tab="addTag($event, newTag)"
                :id="form.name"
                v-model="newTag"
                name="form_item"
                class="block pl-3 w-full"
                :placeholder="name"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
let pageVariables = defineProps({
    form: Object,
    name: String,
    data: Array,
});

onMounted(() => {
    if (typeof(pageVariables.data) !== 'undefined') {
        for (const value of pageVariables.data) {
            tags.value.push(value.tag);
        }
    }
});

const tags = ref([]);
const newTag = ref("");

const addTag = (event, tag) => {
    tags.value.push(tag);
    pageVariables.form.tags = tags;
    newTag.value = "";
    event.preventDefault();
};

const removeTag = (index) => {
    tags.value.splice(index, 1);
};
</script>
