import { createSSRApp, h, DefineComponent } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createInertiaApp } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

import axios from "axios";
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { i18nVue } from "laravel-vue-i18n";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob<DefineComponent>("./Pages/**/*.vue")
            ),
        setup({ App, props, plugin }) {
            return createSSRApp({ render: () => h(App, props) })
                .component("font-awesome-icon", FontAwesomeIcon)
                .use(Toast, {
                    transition: "Vue-Toastification__bounce",
                    maxToasts: 3,
                    newestOnTop: true,
                    // filterBeforeCreate: (toast: any, toasts: any) => {
                    //     if (
                    //         toasts.filter((t: any) => t.type === toast.type)
                    //             .length !== 0
                    //     ) {
                    //         return false;
                    //     }
                    //     return toast;
                    // },
                })
                .use(i18nVue, {
                    fallbackLang: "en",
                    resolve: (lang: string) => {
                        const langs: any = import.meta.glob(
                            "../../lang/*.json",
                            {
                                eager: true,
                            }
                        );
                        return langs[`../../lang/${lang}.json`].default;
                    },
                })
                .use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                });
        },
    })
);
