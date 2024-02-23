<template>
    <div v-if="links.length > 3">
        <div class="mt-5 flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="px-2 py-1 mr-1 mb-1 text-sm leading-4 text-gray-400 rounded border"
                    v-html="translateLink(link.label)"
                />
                <Link
                    v-else
                    :key="key + 1"
                    class="px-2 py-1 mr-1 mb-1 text-sm leading-4 rounded border hover:bg-indigo-500 hover:text-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'text-white bg-indigo-500': link.active }"
                    :href="link.url"
                    v-html="translateLink(link.label)"
                />
            </template>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { computed } from "vue";

defineProps({
    links: {
        type: Object,
        default: () => ({}),
    },
});

const translateLink = (label: string) => {
    if (label.toLowerCase().includes("previous")) {
        return prevLink.value;
    }
    if (label.toLowerCase().includes("next")) {
        return nextLink.value;
    }

    return label;
};
const prevLink = computed(() => {
    return trans("pagination.previous");
});
const nextLink = computed(() => {
    return trans("pagination.next");
});
</script>
