<template>
    <div class="mb-4">
        <FileUpload
            ref="fileInput"
            @input="pageVariables.form.avatar = $event.target.files"
            @change="files = form.avatar"
            @select="onFileSelect"
            @clear="clearFiles"
            :chooseLabel="$t('general.choose')"
            :cancelLabel="$t('general.clear')"
            :showUploadButton="false"
            accept=".csv,.xlsx,.pdf"
            :multiple="true"
            :maxFileSize="maxFileSize"
        >
            <template #content="{ files }">
                <DataTable
                    v-if="files.length > 0"
                    :value="files"
                    class="p-5 border-2 border-black border-dashed"
                >
                    <template #header>
                        <div class="mb-4 font-bold text-xl text-center">
                            {{ $t("general.uploaded_files") }}
                        </div>
                    </template>
                    <Column
                        field="name"
                        :header="$t('general.file_name')"
                    ></Column>
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
                    class="flex justify-center items-center bg-white p-5 border-2 border-black border-dashed h-24"
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
    </div>
</template>

<script setup>
import { ref } from "vue";
import { FileUpload, DataTable, Column } from "primevue";

const fileInput = ref(null);
let files = ref("");
const maxFileSize = ref(2000000);

let pageVariables = defineProps({
    form: Object,
});

function clearFiles() {
    files.value = [];
    pageVariables.form.avatar = null;
}

function onFileSelect(event) {
    pageVariables.form.avatar = event.files;
    files.value = event.files;
}
</script>
