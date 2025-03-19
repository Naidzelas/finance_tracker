import { definePreset } from "@primeuix/themes";
import Aura from "@primeuix/themes/aura";

const primePreset = definePreset(Aura, {
    semantic: {
        primary: {
            950: "{slate.950}",
            // Undecided yet
        },
        secondary: {
            // Undecided yet
        },
    },
    components: {
        tabs: {
            tabFontWeight: "400",
            tabPadding: "5px",
            tabBorder: "rounded",
            colorScheme: {
                light: {
                    activeBarBackground: "black",
                    tabText: "black",
                    tabColor: "black",
                    tabActiveColor: "black",
                    tabActiveBackground: "white",
                    tabHoverBackground: "{slate.200}",
                    tabpanelBackground: "#F4F4F4",
                    tablistBackground: "#F4F4F4",
                    tabActiveBorderColor: "black",
                    tabHoverBorderColor: "black",
                },
                dark: {
                    tabText: "{third.activeBackground}",
                    tabHoverText: "{primary.50}",
                },
            },
        },
    },
});

export { primePreset };
