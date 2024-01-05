<template>
    <input
        class="block mt-1 w-full rounded-md form-input focus:border-indigo-600"
        :value="modelValue"
        @input="handleInput"
        ref="input"
    />
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";

defineProps(["modelValue"]);

const emits = defineEmits(["update:modelValue"]);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

const handleInput = (): void => {
    if (input.value) {
        emits("update:modelValue", input.value.value);
    }
};
</script>
