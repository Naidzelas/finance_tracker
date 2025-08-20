<template>
    <div class="relative flex bg-surface-50 dark:bg-surface-950 h-screen">
        <div
            class="top-0 left-0 z-10 flex-shrink-0 bg-surface-0 dark:bg-surface-950 border-surface-200 dark:border-surface-700 border-r w-[70px] h-screen select-none"
        >
            <div class="flex flex-col h-full">
                <div
                    class="flex flex-shrink-0 justify-center items-center p-4 h-[64px]"
                >
                    <img
                        src="../../../public/images/cat.png"
                        class="size-10 scale-x-[-1]"
                    />
                </div>

                <!-- Navigation -->
                <div class="flex flex-col flex-1 items-center gap-2 px-2 py-4">
                    <button
                        :class="[
                            'flex items-center justify-center cursor-pointer p-3 w-full rounded-lg border transition-colors duration-150',
                            selectedNav === 'Dashboard'
                                ? 'bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-surface-0 border-surface-100 dark:border-surface-700'
                                : 'bg-transparent border-transparent text-surface-600 dark:text-surface-400 hover:bg-surface-50 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-surface-0 hover:border-surface-100 dark:hover:border-surface-700',
                        ]"
                        @click="selectedNav = 'Dashboard'"
                    >
                        <i class="!text-xl !leading-normal pi pi-home" />
                    </button>
                    <button
                        :class="[
                            'flex items-center justify-center cursor-pointer p-3 w-full rounded-lg border transition-colors duration-150',
                            selectedNav === 'Goal'
                                ? 'bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-surface-0 border-surface-100 dark:border-surface-700'
                                : 'bg-transparent border-transparent text-surface-600 dark:text-surface-400 hover:bg-surface-50 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-surface-0 hover:border-surface-100 dark:hover:border-surface-700',
                        ]"
                        @click="selectedNav = 'Goal'"
                    >
                        <i class="!text-xl !leading-normal pi pi-bullseye" />
                    </button>
                    <button
                        :class="[
                            'flex items-center justify-center cursor-pointer p-3 w-full rounded-lg border transition-colors duration-150',
                            selectedNav === 'Investment'
                                ? 'bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-surface-0 border-surface-100 dark:border-surface-700'
                                : 'bg-transparent border-transparent text-surface-600 dark:text-surface-400 hover:bg-surface-50 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-surface-0 hover:border-surface-100 dark:hover:border-surface-700',
                        ]"
                        @click="selectedNav = 'Investment'"
                    >
                        <i class="!text-xl !leading-normal pi pi-calculator" />
                    </button>
                    <button
                        :class="[
                            'flex items-center justify-center cursor-pointer p-3 w-full rounded-lg border transition-colors duration-150',
                            selectedNav === 'Debt'
                                ? 'bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-surface-0 border-surface-100 dark:border-surface-700'
                                : 'bg-transparent border-transparent text-surface-600 dark:text-surface-400 hover:bg-surface-50 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-surface-0 hover:border-surface-100 dark:hover:border-surface-700',
                        ]"
                        @click="selectedNav = 'Debt'"
                    >
                        <i class="!text-xl !leading-normal pi pi-stopwatch" />
                    </button>
                    <ImportFileModal></ImportFileModal>
                </div>
                <div class="flex flex-col items-center gap-4 px-4 pt-4 pb-6">
                    <hr
                        class="border-0 border-surface-200 dark:border-surface-700 border-t w-full"
                    />
                    <a class="flex justify-center items-center">
                        <img
                            src="https://fqjltiegiezfetthbags.supabase.co/storage/v1/render/image/public/block.images/blocks/avatars/circle/avatar-f-1.png"
                            class="rounded-full w-8 h-8 cursor-pointer"
                        />
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col flex-auto min-h-screen">
            <!-- Main Content Header -->
            <div
                class="flex justify-between items-center bg-surface-0 dark:bg-surface-950 px-7 py-4 border-surface-200 dark:border-surface-700 border-b min-h-[60px]"
            >
                <div class="flex flex-1 gap-4">
                    <div class="relative">
                        <span
                            class="left-0 absolute inset-y-0 flex items-center pl-3"
                        >
                            <i
                                class="text-surface-500 dark:text-surface-400 !text-base !leading-normal pi pi-search"
                            />
                        </span>
                        <input
                            type="text"
                            class="bg-transparent py-2 pr-3 pl-10 border-0 outline-none ring-0 w-40 sm:w-80"
                            placeholder="Search"
                        />
                    </div>
                </div>
                <div class="flex items-center gap-7">
                    <a class="cursor-pointer">
                        <i
                            class="text-surface-500 dark:text-surface-400 !text-xl !leading-normal pi pi-bell"
                        />
                    </a>
                    <img
                        src="https://fqjltiegiezfetthbags.supabase.co/storage/v1/render/image/public/block.images/blocks/avatars/circle/avatar-f-1.png"
                        class="rounded-full w-8 h-8"
                    />
                    <a
                        v-styleclass="{
                            selector: '#slideover-right',
                            enterFromClass: 'hidden',
                            enterActiveClass: 'animate-fadeinright',
                            leaveToClass: 'hidden',
                            leaveActiveClass: 'animate-fadeoutright',
                            hideOnOutsideClick: true,
                        }"
                        class="cursor-pointer"
                        @click="isSidebarOpen = !isSidebarOpen"
                    >
                        <i
                            :class="[
                                isSidebarOpen
                                    ? 'pi pi-arrow-left'
                                    : 'pi pi-arrow-right',
                                '!text-xl !leading-normal text-surface-500 dark:text-surface-400 transition-transform duration-300',
                            ]"
                        />
                    </a>
                </div>
            </div>

            <!-- Main content area -->
            <div class="relative flex flex-auto h-[calc(100vh-60px)]">
                <!-- Slot here -->
                <div class="flex bg-surface-50 dark:bg-surface-950 p-7">
                    <div
                        class="bg-surface-50 dark:bg-surface-900 border-2 border-surface-200 dark:border-surface-700 border-dashed rounded-xl h-full"
                    >
                        <slot />
                    </div>
                </div>

                <!-- Right sidebar -->
                <div
                    id="slideover-right"
                    class="hidden top-0 right-0 z-10 absolute bg-surface-0 dark:bg-surface-900 shadow-xl w-full md:w-[25rem] h-full overflow-hidden"
                >
                    <div class="flex flex-col h-full">
                        <div class="flex flex-col gap-4 p-6 h-full">
                            <div class="flex items-center gap-4">
                                <span
                                    class="flex-1 font-medium text-surface-900 dark:text-surface-0 text-xl leading-tight"
                                    >Right Sidebar</span
                                >
                                <a
                                    v-styleclass="{
                                        selector: '#slideover-right',
                                        leaveToClass: 'hidden',
                                        leaveActiveClass:
                                            'animate-fadeoutright',
                                    }"
                                    class="cursor-pointer"
                                    @click="isSidebarOpen = false"
                                >
                                    <i
                                        class="text-surface-500 dark:text-surface-400 !text-xl !leading-normal pi pi-times"
                                    />
                                </a>
                            </div>
                            <div
                                class="flex-1 p-6 border-2 border-surface-200 dark:border-surface-700 border-dashed rounded-2xl"
                            >
                                <p
                                    class="text-surface-600 dark:text-surface-400"
                                >
                                    Sidebar content here
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    Drawer,
    Divider,
    PanelMenu,
    Button,
    Popover,
    ScrollPanel,
} from "primevue";
import { ref, watch } from "vue";
import ImportFileModal from "../Components/ImportFileModal.vue";
import { Link, router } from "@inertiajs/vue3";

const selectedNav = ref("home");
const isSidebarOpen = ref(false);
const importModalVisible = ref(false);

const items = ref({
    Dashboard: { url: "index" },
    Goal: { url: "goal.index" },
    Investment: { url: "investment.index" },
    Debt: { url: "debt.index" },
});

const overlayPanel = ref(null);

function importExpenses(){
    importModalVisible.value = true;
}

watch(selectedNav, (newVal) => {
    router.get(route(items.value[newVal].url));
    console.log("Selected navigation changed:", items.value[newVal].url);
});

function togglePopover(event) {
    overlayPanel.value.toggle(event);
}
</script>
