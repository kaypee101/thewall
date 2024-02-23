<template>
    <header
        class="flex items-center justify-between border-b-4 border-indigo-600 bg-white px-6 py-4"
    >
        <div class="flex items-center">
            <button
                @click="
                    $page.props.showingMobileMenu =
                        !$page.props.showingMobileMenu
                "
                class="text-gray-500 focus:outline-none lg:hidden"
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M4 6H20M4 12H20M4 18H11"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <Dropdown>
                <template #trigger>
                    <button class="relative block overflow-hidden">
                        {{ $page.props.auth.user.name }}
                    </button>
                </template>

                <template #content>
                    <DropdownLink
                        :href="route('profile.edit')"
                        class="w-full text-left"
                    >
                        Profile
                    </DropdownLink>

                    <DropdownLink
                        :href="route('logout')"
                        class="w-full text-left"
                        method="post"
                        as="button"
                    >
                        Log out
                    </DropdownLink>
                </template>
            </Dropdown>
            <Dropdown>
                <template #trigger>
                    <button class="relative block overflow-hidden">
                        Locale
                    </button>
                </template>

                <template #content>
                    <DropdownLink
                        :href="'#'"
                        class="w-full text-left"
                        @click="toggleLocale('en')"
                        as="button"
                    >
                        EN
                    </DropdownLink>

                    <DropdownLink
                        :href="'#'"
                        class="w-full text-left"
                        @click="toggleLocale('ja')"
                        as="button"
                    >
                        JA
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
    </header>
</template>

<script setup lang="ts">
import { createApp } from "vue";
import { i18nVue } from "laravel-vue-i18n";
import axios from "axios";

import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const app = createApp({});

const toggleLocale = async (locale: string) => {
    await axios
        .post(route("locale"), { locale: locale })
        .then((response) => {
            app.use(i18nVue, {
                lang: response.data.props.locale,
            });
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
