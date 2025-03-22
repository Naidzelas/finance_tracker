<template>
    <form @submit.prevent="submit">
        <div class="md:flex md:flex-wrap">
            <div class="relative p-5">
                <label for="form_item" class="font-thin text-xl">{{
                    $t("user.etoro_account")
                }}</label>
                <div
                    class="flex bg-white mt-1 border-b-2 border-black md:w-52 h-7"
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
                    class="flex bg-white mt-1 border-b-2 border-black md:w-52 h-7"
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
                    class="flex bg-white mt-1 border-b-2 border-black md:w-52 h-7"
                >
                    <input
                        name="form_item"
                        class="block pl-3 w-full"
                        :value="
                            data.debt.paid.toFixed(2) + ' / ' + data.debt.total
                        "
                        disabled
                    />
                </div>
            </div>
            <div class="relative p-5">
                <label for="form_item" class="font-thin text-xl">{{
                    $t("user.invested")
                }}</label>
                <div
                    class="flex bg-white mt-1 border-b-2 border-black md:w-52 h-7"
                >
                    <input
                        name="form_item"
                        class="block pl-3 w-full"
                        :value="data.invested"
                        disabled
                    />
                </div>
            </div>
            <div class="relative p-5">
                <label for="form_item" class="font-thin text-xl">{{
                    $t("user.email")
                }}</label>
                <div class="flex bg-white mt-1 border-b-2 border-black h-7">
                    <input
                        name="form_item"
                        class="block pl-3 md:w-72"
                        :value="data.user.email"
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
</template>

<script setup>
import { reactive, onMounted } from "vue";
import { router, Link } from "@inertiajs/vue3";

const pageVariables = defineProps({
    data: Object,
});

const form = reactive({
    etoro_name: null,
    income: null,
});

function submit() {
    router.patch("/settings/profile", form);
}
onMounted(() => {
    form.etoro_name = pageVariables.data.user.etoro_name;
    form.income = pageVariables.data.user.income;
});
</script>
