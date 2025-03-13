import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import Layout from "./Layout/Layout.vue";
import PreAppLayout from "./Layout/PreAppLayout.vue";
import { Icon } from "@iconify/vue";
import { ZiggyVue } from "ziggy-js";
import VueToastificationPlugin from "vue-toastification";
import { createI18n } from "vue-i18n";
import lt from "../../lang/lt.json";
import en from "../../lang/en.json";

const messages = {
    lt: { ...lt },
    en: { ...en },
};

const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem("locale") || "en",
    fallbackLocale: "en",
    messages,
});

createInertiaApp({
    progress: false,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        if (name != "Landing") {
            page.default.layout = page.default.layout || Layout;
        } else {
            page.default.layout = PreAppLayout;
        }
        return pages[`./Pages/${name}.vue`];
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
            .use(i18n)
            .component("Icon", Icon)
            .mount(el);
    },
});

export { i18n };
