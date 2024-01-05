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

        <div class="flex items-center">
            <Dropdown>
                <template #trigger>
                    <button
                        @click="toggleDropdown"
                        class="relative block overflow-hidden"
                    >
                        {{ $page.props.auth.user.name }}
                    </button>
                </template>

                <template #content>
                    <DropdownLink :href="route('profile.edit')">
                        Profile
                    </DropdownLink>

                    <DropdownLink
                        class="w-full text-left"
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log out
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
    </header>
</template>

<script setup lang="ts">
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { ref } from "vue";

const dropdownOpen = ref(false);

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};
</script>
