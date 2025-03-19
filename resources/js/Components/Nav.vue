<template class="relative">
    <!-- <ImportFileModal class="z-10"></ImportFileModal> -->
    <div class="invisible md:visible flex flex-col">
        <div class="relative">
            <button @click="navToggle(true)">
                <Icon icon="ph:cube-fill" class="mt-1 size-10"></Icon>
            </button>
            <div v-if="menu_visible" @pointerleave="navToggle(false)">
                <div
                    class="top-0 right-0.5 absolute bg-white rounded-r-md w-20 size-12"
                >
                    <button @click="navToggle(false)">
                        <Icon
                            icon="fluent:receipt-cube-20-regular"
                            class="mt-1 ml-10 size-10"
                        ></Icon>
                    </button>

                    <NavItems></NavItems>
                </div>
            </div>
        </div>
        <div class="relative self-center">
            <Icon icon="clarity:bell-solid-badged" class="mt-6 size-6"></Icon>
        </div>
        <div class="self-center">
            <div v-if="!page.url.split('/')[1].length">
                <ImportFileModal></ImportFileModal>
            </div>
            <Link
                v-if="
                    page.url.split('/').length < 3 &&
                    page.url.split('/')[1].length
                "
                :href="page.url + '/create'"
                ><Icon icon="basil:add-solid" class="mt-4 size-6"></Icon
            ></Link>
        </div>
        <div v-if="!page.url.split('/')[1].length" class="self-center">
            <Link href="/expense_list">
                <Icon
                    icon="material-symbols:list-alt"
                    class="mt-4 size-6"
                ></Icon>
            </Link>
        </div>
    </div>
    <div class="invisible md:visible flex mr-10 text-4xl">
        {{ $t("general.finance").toLocaleLowerCase() }}
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import NavItems from "../Components/NavItems.vue";
import ImportFileModal from "./ImportFileModal.vue";
import "vue-toastification/dist/index.css";
import { useToast } from "vue-toastification";

const toast = useToast();
const page = usePage();
let menu_visible = ref(false);

function navToggle(toggle) {
    menu_visible.value = toggle;
}

onMounted(() => {
    Echo.channel("notification").listen("NotificationEvent", (e) => {
        notification(e.message);
    });
});

function notification(message) {
    // toast(Notifications);
    toast.success(message, {
        position: "top-right",
        timeout: 3000,
        closeOnClick: true,
        pauseOnHover: true,
        hideProgressBar: true,
        icon: true,
        closeButton: false,
    });
}
toast.clear();
</script>
