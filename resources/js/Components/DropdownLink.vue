<template>
    <Link
        :href="'javascript void(0)'"
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
    >
        <slot />
    </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
</script>
