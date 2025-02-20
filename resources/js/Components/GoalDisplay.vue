<template>
    <div v-for="goal in goal_data" class="group relative mb-2">
        <EditOrDelete :action="{edit:'goal.edit', delete:'goal.destroy', redirect:'/'}" :id="goal.id"></EditOrDelete>
        <!-- <div
            class="group-hover:visible group-hover:w-32 invisible top-[25%] right-10 absolute flex gap-2 p-2 w-0 hover:scale-110 group-hover:transition-all group-hover:ease-in-out cursor-pointer"
        >
            <Link
                :href="route('goal.edit', { id: goal.id })"
                as="button"
                class="flex-1 place-items-center grid bg-[#297A9D] hover:bg-[#153d4f] rounded h-8 text-white"
            >
                <Icon icon="tabler:edit" class="size-6"></Icon>
            </Link>
            <button
                @click="deleteItem(goal.id)"
                class="flex-1 place-items-center grid bg-[#5A0000] hover:bg-[#942929] rounded h-8 text-white"
            >
                <Icon icon="fa6-solid:trash" class="size-4"></Icon>
            </button>
        </div> -->
        <div class="bg-[white] mb-0.5 rounded-full">
            <div class="bg-black w-[25%] h-1" :class="percent(goal)"></div>
        </div>
        <div
            class="flex place-items-center bg-[white] p-4 border-6 rounded text-center"
        >
            <div class="flex flex-auto justify-center">
                <Icon :icon="goal.icon.iconify_name" class="size-10"></Icon>
            </div>
            <div class="w-96 font-semibold text-3xl">{{ goal.name }}</div>
            <div class="group-hover:invisible flex-auto text-3xl">{{ goal.end_goal }}</div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import EditOrDelete from './EditOrDelete.vue';

defineProps({ goal_data: Object });

// const deleteItem = async (id) => {
//     router.delete(route("goal.destroy", id), {
//         onSuccess: () => {
//             router.visit("/", { only: ["goals"] });
//         },
//         onError: (errors) => {
//             console.error("Delete failed:", errors);
//         },
//     });
// };

// TODO make this a component and this will only show change if the page is reloaded.
let percent = computed(() =>{
    return (goal) => {
        return 'w-['+getPercent(goal.end_goal, goal.deposit)+'%]';
    }
})

function getPercent(fullSum = 0, sum = 0){
    return (sum / fullSum * 100) > 100 ? 100 : (sum / fullSum * 100).toFixed();
}
</script>
