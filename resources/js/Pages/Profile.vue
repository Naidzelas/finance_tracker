<template>
    <div class="mr-10 2xl:mr-40 mb-20 ml-10 2xl:ml-40">
        <div class="mt-10 mb-2 text-4xl xl:text-5xl md:text-left text-center">
            {{ user.name }} {{ $t("user.cubicle").toLocaleLowerCase() }}
        </div>
        <div>
            <Breadcrumbs :breadcrumbs="breadcrumbs"></Breadcrumbs>
        </div>
        <div class="gap-4 grid grid-cols-3">
            <div class="col-span-3">
                <Tabs :value="chartData.tab ?? 'user'" class="mt-2">
                    <TabList>
                        <Tab class="rounded-t-md w-32" value="user">User</Tab>
                        <Tab class="rounded-t-md w-32" value="statistics"
                            >Statistics</Tab
                        >
                    </TabList>
                    <TabPanels>
                        <TabPanel value="user">
                            <ProfileUserTab
                                :data="pageVariables"
                            ></ProfileUserTab>
                        </TabPanel>
                        <TabPanel value="statistics">
                            <ProfileStatisticsTab></ProfileStatisticsTab>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Tabs, TabList, Tab, TabPanels, TabPanel } from "primevue";
import ProfileUserTab from "../Components/ProfileUserTab.vue";
import ProfileStatisticsTab from "../Components/ProfileStatisticsTab.vue";
import Breadcrumbs from "../Components/Breadcrumbs.vue";
import { provide } from "vue";

const pageVariables = defineProps({
    user: Object,
    invested: Number,
    debt: Object,
    breadcrumbs: Object,
    chartData: Object
});

provide("chartData", pageVariables.chartData.data);

</script>
