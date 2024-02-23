<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { computed } from "vue";

const props = defineProps({
    auth: {
        type: Object,
        default: () => ({}),
    },
    title: {
        type: String,
        default: () => "",
    },
    videoPatterns: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({
    title: "",
});
const submit = () => {
    form.post(route("admin.posts.store"));
};
const pageTitle = computed(() => {
    return trans("post.create, :title", {
        title: props.title,
    });
});
</script>

<template>
    <Head :title="pageTitle" />

    <AuthenticatedLayout :auth="props.auth">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ pageTitle }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mt-3">
                                <InputLabel for="title" value="Title" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                    autocomplete="postname"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.title"
                                />
                            </div>
                            <PrimaryButton
                                :buttonType="'submit'"
                                class="mt-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                {{ trans("post.submit") }}
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
