import { definePreset } from "@primeuix/themes";
import Aura from "@primeuix/themes/aura";

const primePreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: "{orange.50}",
            100: "{orange.100}",
            200: "{orange.200}",
            300: "{orange.300}",
            400: "{orange.400}",
            500: "{orange.500}",
            600: "{orange.600}",
            700: "{orange.700}",
            800: "{orange.800}",
            900: "{orange.900}",
        },
        secondary: {
            // Undecided yet
        },
    },
    components: {
        drawer:{
            background: "#F4F0EF",
            borderColor: "#F4F0EF"
        },
        // tabs: {
        //     tabFontWeight: "400",
        //     tabPadding: "5px",
        //     tabBorder: "rounded",
        //     colorScheme: {
        //         light: {
        //             activeBarBackground: "black",
        //             tabText: "black",
        //             tabColor: "black",
        //             tabActiveColor: "black",
        //             tabActiveBackground: "white",
        //             tabHoverBackground: "{slate.200}",
        //             tabpanelBackground: "#F4F4F4",
        //             tablistBackground: "#F4F4F4",
        //             tabActiveBorderColor: "black",
        //             tabHoverBorderColor: "black",
        //         },
        //         dark: {
        //             tabText: "{third.activeBackground}",
        //             tabHoverText: "{primary.50}",
        //         },
        //     },
        // },
        // breadcrumb: {
        //     colorScheme:{
        //         background: "{gray.200}"
        //     }
        // },
    },
});

export { primePreset };
