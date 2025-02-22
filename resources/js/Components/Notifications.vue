<template>
    <div class="top-6 right-10 absolute flex-col container">
        <div
            class="flex items-stretch bg-[#8EB7C9] mb-3 pt-3 pb-3 rounded-md w-72 h-fit text-white transition-opacity duration-200 delay-100"
            :class="opacity"
        >
            <Icon icon="gg:check-o" class="self-center mr-4 ml-4 size-8"></Icon>
            <div class="self-center mr-4 w-full text-lg text-right">
                {{ 'test' }}
            </div>
            <div
                class="top-2 -right-2 absolute bg-[#8EB7C9] size-4 rotate-45"
            ></div>
        </div>
        <!-- <button @click="$emit('close-toast')">Close Toast</button> -->
        <!-- <div
            class="relative flex items-stretch bg-[#C98E8E] mb-3 pt-3 pb-3 rounded-md w-72 h-fit text-white"
        >
            <Icon icon="ix:error" class="self-center mr-4 ml-4 size-8"></Icon>
            <div class="self-center mr-4 w-full text-lg text-right">
                Failure
            </div>
            <div
                class="top-2 -right-2 absolute bg-[#C98E8E] size-4 rotate-45"
            ></div>
        </div> -->
        <!-- <div
            class="relative flex items-stretch bg-[#C9AA8E] mb-3 pt-3 pb-3 rounded-md w-72 h-fit text-white"
        >
            <Icon
                icon="ic:round-error-outline"
                class="self-center mr-4 ml-4 size-8"
            ></Icon>
            <div class="self-center mr-4 w-full text-lg text-right">
                Warning
            </div>
            <div
                class="top-2 -right-2 absolute bg-[#C9AA8E] size-4 rotate-45"
            ></div>
        </div> -->
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { watch, ref, onMounted, onUpdated } from "vue";

let pageVariables = defineProps({
    data: Object,
});

const opacity = ref("opacity-100");
// watch(
//     () => pageVariables.data.message,
//     () => {
//         setTimeout(() => {
//             opacity.value = "opacity-0";
//             router.reload();
//         }, 5000);
//         opacity.value = "opacity-100";
        
//         router.reload();
//     }
// );



// const message = ref(pageVariables.data.message);
// function handleNewMessage(newValue) {
//   if (newValue) {
//     opacity.value = "opacity-100";
//     console.log("Prop changed", newValue);

//     setTimeout(() => {
//       opacity.value = "opacity-0";
//       pageVariables.data.message = "";
//       message.value = ""; // Reset the reactive message value
//       router.reload();
//       console.log(pageVariables.data);
//     }, 5000);
//   }
// }

// onMounted(() => {
//   handleNewMessage(message.value);
// });

// watch(
//   () => pageVariables.data.message,
//   (newValue) => {
//     message.value = newValue; // Update the reactive message value
//     handleNewMessage(newValue);
//   }
// );
</script>
