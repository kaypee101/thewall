<template>
    <div
        :class="$page.props.showingMobileMenu ? 'block' : 'hidden'"
        @click="$page.props.showingMobileMenu = false"
        class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"
    ></div>

    <div
        :class="
            $page.props.showingMobileMenu
                ? 'translate-x-0 ease-out'
                : '-translate-x-full ease-in'
        "
        class="overflow-y-auto fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0"
    >
        <div class="flex justify-center items-center mt-8">
            <div class="flex items-center">
                <span class="mx-2 text-2xl font-semibold text-white">
                    {{ page.props.appName }}
                </span>
            </div>
        </div>

        <nav class="mt-10" x-data="{ isMultiLevelMenuOpen: false }">
            <nav-link
                :href="route('dashboard')"
                :active="route().current('dashboard')"
            >
                <font-awesome-icon :icon="faTableColumns" />
                Dashboard
            </nav-link>

            <nav-link :href="route('about')" :active="route().current('about')">
                <font-awesome-icon :icon="faAddressCard" />
                About us
            </nav-link>

            <a
                class="flex items-center mt-4 py-2 px-6 text-gray-100"
                href="#"
                @click="showingTwoLevelMenu = !showingTwoLevelMenu"
            >
                <span class="mx-3">
                    <font-awesome-icon :icon="faCircleChevronDown" />
                    Two-level menu
                </span>
            </a>
            <transition
                enter-to-class="transition-all duration-300 ease-in-out"
                enter-from-class="max-h-0 opacity-25"
                leave-from-class="opacity-100 max-h-xl"
                leave-to-class="max-h-0 opacity-0"
            >
                <div v-show="showingTwoLevelMenu">
                    <ul
                        class="overflow-hidden p-2 mx-4 mt-2 space-y-2 text-sm font-medium text-white bg-gray-700 bg-opacity-50 rounded-md shadow-inner"
                        aria-label="submenu"
                    >
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('dashboard')"
                                >Child menu</Link
                            >
                        </li>
                    </ul>
                </div>
            </transition>
        </nav>
    </div>
</template>

<script setup lang="ts">
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

import {
    faTableColumns,
    faAddressCard,
    faCircleChevronDown,
} from "@fortawesome/free-solid-svg-icons";

const page = usePage();
let showingTwoLevelMenu = ref(false);
</script>

<style scoped></style>
