<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current goals</div>
        <div class="rounded-full mb-0.5 bg-[white]">
            <div
                class="rounded-full bg-gradient-to-r from-black to-[#606060] w-[28%] h-2"
            ></div>
        </div>
        <div class="rounded-md bg-[#F4F4F4] flex p-3">
            <div class="flex flex-1 pl-10">
                <div><Icon icon="lucide:house" class="size-12"></Icon></div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Need</div>
                <div>€ 15 000</div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Monthly</div>
                <div>€ 625</div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Months to complete</div>
                <div>24</div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="font-bold">Saved</div>
                <div>€ 0</div>
            </div>
        </div>
        <div
            class="rounded-md mb-0.5 bg-[#F4F4F4] mt-1 w-full flex justify-center"
        >
            <Icon icon="tabler:dots" class="h-5 w-5"></Icon>
        </div>
    </section>
</template>

<script setup></script>
