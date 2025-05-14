<template>
    <div class="flex h-screen">
        <!-- Drawer -->
        <div class="flex-none w-[20em]">
            <Drawer visible :modal="false" :showCloseIcon="false">
                <template #header>
                    <div class="pb-8 w-full">
                        <div class="flex justify-center">
                            <img
                                src="\.\storage\app\public\images\cat.png"
                                class="size-20 scale-x-[-1]"
                            />
                        </div>
                    </div>
                </template>
                <PanelMenu :model="items">
                    <template #item="{ item }">
                        <Link
                            v-if="item.url"
                            :href="route(item.url)"
                            class="flex items-center hover:bg-primary px-4 py-2 cursor-pointer"
                        >
                            <i :class="item.icon" class="mr-2"></i>
                            {{ item.label }}
                        </Link>
                        <span v-else class="flex items-center px-4 py-2">
                            <i :class="item.icon" class="mr-2"></i>
                            {{ item.label }}
                        </span>
                    </template>
                </PanelMenu>
                <template #footer>
                    <Divider class="my-2" />
                    <div class="w-full">
                        <Button
                            @click="togglePopover"
                            ref="popoverButton"
                            class="mb-8 w-full"
                            unstyled="true"
                        >
                            <div class="flex justify-between p-2">
                                <div class="bg-slate-200 rounded-full size-12">
                                    test
                                </div>
                                <div class="flex flex-col -ml-8 text-left">
                                    <div class="font-bold">Naidželas</div>
                                    <div class="text-sm">email@email.com</div>
                                </div>
                                <div><i class="pi pi-angle-double-up"></i></div>
                            </div>
                        </Button>
                        <Popover
                            ref="overlayPanel"
                            dismissable
                            unstyled="true"
                            class="bg-white shadow-lg ml-[10em] rounded-lg"
                        >
                            <div class="p-4">
                                <p>This is a popover content!</p>
                            </div>
                        </Popover>
                    </div>
                </template>
            </Drawer>
        </div>

        <!-- Main Content -->
        <div class="flex-auto bg-white shadow-lg m-8 rounded-lg">
            <!-- Content Area -->
            <div class="flex-col p-8">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Drawer, Divider, PanelMenu, Button, Popover } from "primevue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const items = ref([
    {
        label: "Dashboard",
        icon: "pi pi-fw pi-home",
        url: "index",
    },
    {
        label: "Goal",
        icon: "pi pi-fw pi-bookmark",
        url: "goal.index",
    },
    {
        label: "Investment",
        icon: "pi pi-fw pi-users",
        url: "investment.index",
    },
    {
        label: "Debt",
        icon: "pi pi-fw pi-envelope",
        url: "debt.index",
    },
]);
const overlayPanel = ref(null);

function togglePopover(event) {
    overlayPanel.value.toggle(event);
}
</script>
