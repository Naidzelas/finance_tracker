<template>
    <div class="mr-40 ml-40">
        <div class="mt-10 mb-10 text-5xl">{{user.name}} cubicle</div>
        <div class="gap-4 grid grid-cols-3">
            <div class="col-span-3">
                <form @submit.prevent="submit">
                    <div class="flex">
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl"
                                >Etoro account</label
                            >
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    v-model="form.etoro_name"
                                />
                            </div>
                        </div>
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl"
                                >Income</label
                            >
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    v-model="form.income"
                                />
                            </div>
                        </div>
    
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl"
                                >Debt</label
                            >
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    value="test"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl"
                                >Invested</label
                            >
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    value="test"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl"
                                >Email</label
                            >
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    value="test"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-400 mt-1 w-full h-px"></div>
                    <div class="flex justify-end space-x-2">
                        <Link
                            :href="'/'"
                            class="bg-[#525252] mt-2 pb-px w-40 text-white text-xl text-center"
                        >
                            CANCEL
                        </Link>

                        <button
                            type="submit"
                            class="bg-[#006692] mt-2 pb-px w-40 text-white text-xl text-center"
                        >
                            CONFIRM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import { router, Link } from "@inertiajs/vue3";

const form = reactive({
    etoro_name: null,
    income: null,
});

function submit() {
    router.patch("/settings/profile", form);
}

const pageVariables = defineProps({
    user: Object,
});

onMounted(() => {
    form.etoro_name = pageVariables.user.etoro_name;
    form.income = pageVariables.user.income;
});
</script>
