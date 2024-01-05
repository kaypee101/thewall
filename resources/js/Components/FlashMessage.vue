<template>
    <div class="flex gap-4">
        <div v-if="hasAvatar" class="flex flex-col justify-center items-left">
            <img :src="props.flash.message.avatar" alt="" />
        </div>
        <div class="flex flex-col justify-center items-left">
            <p class="font-bold">
                {{ props.flash.message.subject }}
            </p>
            <p v-if="props.flash.message.details" class="text-sm">
                {{ props.flash.message.details }}
            </p>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { MessageInterface } from "@/Interface/MessageInterface.ts";

const props = defineProps({
    flash: {
        type: Object as () => MessageInterface,
        default: () => ({ message: { avatar: "", subject: "", details: "" } }),
    },
});
const hasAvatar = ref(props.flash.message.avatar !== undefined);
</script>

<style lang="scss" scoped></style>
