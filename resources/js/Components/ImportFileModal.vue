<template>
    <button @click="visible = true">
        <Icon icon="basil:add-solid" class="mt-4 size-6"></Icon>
    </button>
    <Dialog v-model:visible="visible" modal class="w-fit">
        <template #header>
            <div class="flex items-stretch gap-x-3 text-2xl">
                <Icon class="self-center" icon="mage:file-upload-fill"></Icon
                >import documents
            </div>
        </template>
        <form>
            <div class="flex space-x-2 mt-4 mb-2">
                <div class="flex-1">
                    <input
                        type="radio"
                        id="seb"
                        name="bank"
                        v-model="form.bank"
                        value="seb"
                        class="peer/seb hidden"
                        checked
                    />
                    <label
                        for="seb"
                        class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/seb:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/seb:text-blue-600 cursor-pointer"
                        >SEB</label
                    >
                </div>
                <div class="flex-1">
                    <input
                        type="radio"
                        id="swed"
                        name="bank"
                        v-model="form.bank"
                        value="swed"
                        class="peer/swed hidden"
                    />
                    <label
                        for="swed"
                        class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/swed:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/swed:text-blue-600 cursor-pointer"
                        >SWEDBANK</label
                    >
                </div>
            </div>
            <FileUpload
                ref="fileInput"
                @input="form.avatar = $event.target.files"
                @change="files = form.avatar"
                @select="onFileSelect"
                @clear="clearFiles"
                :chooseLabel="$t('general.choose')"
                :cancelLabel="$t('general.cancel')"
                :showUploadButton="false"
                accept=".csv,.xlsx"
                :multiple="true"
                :maxFileSize="maxFileSize"
            >
                <template #content="{ files }">
                    <DataTable v-if="files.length > 0" :value="files" class="p-5 border-2 border-black border-dashed md:w-[35em]">
                        <template #header>
                            <div class="mb-4 font-bold text-xl text-center">
                                {{ $t("general.uploaded_files") }}
                            </div>
                        </template>
                        <Column field="name" :header="$t('general.file_name')"></Column>
                        <Column :header="$t('general.status')">
                            <template #body="slotProps">
                                {{ $t("general.completed") }}
                            </template>
                        </Column>
                        <Column field="size" :header="$t('general.file_size')">
                            <template #body="slotProps">
                                {{ (slotProps.data.size / 1000).toFixed(2) }} KB
                            </template>
                        </Column>
                    </DataTable>
                </template>
                <template #empty>
                    <div
                        class="flex justify-center items-center bg-white p-5 border-2 border-black border-dashed sm:w-[20em] h-24"
                    >
                        <div class="flex">
                            <div>{{ $t("general.drag_and_drop") }}</div>
                            <Icon
                                icon="material-symbols-light:water-drop"
                                class="ml-1 size-6 text-[#006692]"
                            ></Icon>
                        </div>
                    </div>
                </template>
            </FileUpload>
        </form>
        <template #footer>
            <div class="flex gap-x-2">
                <button
                    @click="handleSubmit"
                    class="flex-1 bg-[#006692] hover:bg-[#007592] mt-2 px-2 py-2 rounded-md w-32 text-md text-white text-center"
                    :disabled="form.processing"
                >
                    {{ $t("general.confirm") }}
                </button>
            </div>
        </template>
    </Dialog>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Dialog, FileUpload, DataTable, Column } from "primevue";

const fileInput = ref(null);
const visible = ref(false);
let files = ref([]);
const maxFileSize = ref(2000000);

const form = useForm({
    avatar: null,
    bank: "seb",
});

function handleSubmit() {
    form.post("/", { onSuccess: () => (visible.value = false) });
}

function clearFiles() {
    files.value = [];
    form.avatar = null;
}

function onFileSelect(event) {
    form.avatar = event.files;
    files.value = event.files;
}
</script>
