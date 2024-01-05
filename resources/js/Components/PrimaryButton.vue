<template>
    <button
        :type="buttonType"
        class="rounded-md bg-indigo-600 px-4 py-2 text-center text-sm text-white"
    >
        <slot />
    </button>
</template>

<script setup lang="ts">
import { ref } from "vue";

interface Props {
    buttonType: "submit" | "button" | "reset";
}

const props = defineProps<Props>();
const buttonType = ref(props.buttonType);
</script>
