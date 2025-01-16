<template>
    <div v-for="goal in goal_data" class="mb-2 group relative">
        <div
            class="flex w-0 gap-2 p-2 absolute top-[25%] right-10 invisible group-hover:visible cursor-pointer group-hover:transition-all group-hover:ease-in-out hover:scale-110 group-hover:w-32"
        >
            <Link
                :href="route('goal.edit', { id: goal.id })"
                as="button"
                class="bg-[#297A9D] hover:bg-[#153d4f] flex-1 text-white rounded h-8 grid place-items-center"
            >
                <Icon icon="tabler:edit" class="size-6"></Icon>
            </Link>
            <button
                @click="deleteItem(goal.id)"
                class="bg-[#5A0000] hover:bg-[#942929] flex-1 text-white rounded h-8 grid place-items-center"
            >
                <Icon icon="fa6-solid:trash" class="size-4"></Icon>
            </button>
        </div>
        <div class="rounded-full mb-0.5 bg-[white]">
            <div class="bg-black w-[25%] h-1" :class="percent(goal)"></div>
        </div>
        <div
            class="flex p-4 place-items-center rounded border-6 bg-[white] text-center"
        >
            <div class="flex flex-auto justify-center">
                <Icon :icon="goal.icon.iconify_name" class="size-10"></Icon>
            </div>
            <div class="w-96 text-3xl font-semibold">{{ goal.name }}</div>
            <div class="flex-auto text-3xl group-hover:invisible">{{ goal.end_goal }}</div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({ goal_data: Object });

const deleteItem = async (id) => {
    router.delete(route("goal.destroy", id), {
        onSuccess: () => {
            router.visit("/", { only: ["goals"] });
        },
        onError: (errors) => {
            console.error("Delete failed:", errors);
        },
    });
};

// TODO make this a component
let percent = computed(() =>{
    return (goal) => {
        return 'w-['+getPercent(goal.end_goal, goal.deposit)+'%]';
    }
})

function getPercent(fullSum = 0, sum = 0){
    return (sum / fullSum * 100) > 100 ? 100 : (sum / fullSum * 100).toFixed();
}
</script>
