<template>
    <div class="mr-40 ml-40">
        <div class="mt-10 mb-10 text-5xl">
            {{ user.name }} {{ $t("user.cubicle").toLocaleLowerCase() }}
        </div>
        <div class="gap-4 grid grid-cols-3">
            <div class="col-span-3">
                <form @submit.prevent="submit">
                    <div class="flex">
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl">{{
                                $t("user.etoro_account")
                            }}</label>
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
                            <label for="form_item" class="font-thin text-xl">{{
                                $t("user.income")
                            }}</label>
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
                            <label for="form_item" class="font-thin text-xl">{{
                                $t("user.debt")
                            }}</label>
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    :value="(debt.paid).toFixed(2) + ' / ' + debt.total"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl">{{
                                $t("user.invested")
                            }}</label>
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black w-52 h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-full"
                                    :value="invested"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="relative p-5">
                            <label for="form_item" class="font-thin text-xl">{{
                                $t("user.email")
                            }}</label>
                            <div
                                class="flex bg-white mt-1 border-b-2 border-black h-7"
                            >
                                <input
                                    name="form_item"
                                    class="block pl-3 w-72"
                                    :value="user.email"
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
                            {{ $t("general.cancel") }}
                        </Link>

                        <button
                            type="submit"
                            class="bg-[#006692] mt-2 pb-px w-40 text-white text-xl text-center"
                            :disabled="form.processing"
                        >
                            {{ $t("general.confirm") }}
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
    invested: Number,
    debt: Object,
});

onMounted(() => {
    form.etoro_name = pageVariables.user.etoro_name;
    form.income = pageVariables.user.income;
});
</script>
