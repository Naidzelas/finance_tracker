import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ZiggyVue } from "ziggy-js";
import VueToastificationPlugin from "vue-toastification";
import Layout from "./Layout/Layout.vue";
import PreAppLayout from "./Layout/PreAppLayout.vue";
import { i18n } from "./i18n";
import PrimeVue from "primevue/config";
import { primePreset } from "./vue-prime-preset";
import VChart from "vue-echarts";

createInertiaApp({
    progress: false,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        const page = pages[`./Pages/${name}.vue`];
        if (!page) {
            console.error(`Page not found: ${name}`);
            throw new Error(`Page not found: ${name}`);
        }
        if (name !== "Landing" && name !== "Error") {
            page.default.layout = page.default.layout || Layout;
        } else {
            page.default.layout = PreAppLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueToastificationPlugin, {
                transition: "Vue-Toastification__slideBlurred",
                maxToasts: 20,
                newestOnTop: true,
            })
            .use(PrimeVue, {
                theme: {
                    preset: primePreset,
                },
            })
            .use(i18n)
            .component("Icon", Icon)
            .component("v-chart", VChart)
            .mount(el);
    },
});
