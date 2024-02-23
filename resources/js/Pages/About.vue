<template>
    <Head :title="pageTitle" />

    <AuthenticatedLayout>
        <template #header>{{ pageTitle }}</template>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                {{ trans("about.about_message") }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";
import { trans } from "laravel-vue-i18n";

const pageTitle = computed(() => {
    return trans("about.about");
});
</script>
