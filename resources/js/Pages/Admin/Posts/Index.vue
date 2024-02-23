<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { onMounted } from "vue";

import { MessageInterface } from "@/Interface/MessageInterface.ts";
import { useFlashMessage } from "@/Interface/FlashMessageInterface.ts";
import { watch } from "vue";

const props = defineProps({
    auth: {
        type: Object,
        default: () => ({}),
    },
    flash: {
        type: Object as () => MessageInterface,
        default: () => ({
            message: { avatar: "", subject: "", details: "" },
        }),
    },
    title: {
        type: String,
        default: () => "",
    },
    posts: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({});

const { showFlashMessage } = useFlashMessage();
onMounted(() => {
    if (props.flash.message?.id) {
        showFlashMessage(props.flash);
    }
});

watch(
    () => props.flash.message?.id,
    () => {
        showFlashMessage(props.flash);
    }
);

function destroy(id: number) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.posts.destroy", id));
    }
}
</script>

<style scoped></style>

<template>
    <Head :title="props.title" />
    <AuthenticatedLayout :auth="props.auth">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ props.title + " Index" }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-2">
                            <Link :href="route('admin.posts.create')">
                                <PrimaryButton :buttonType="'button'">
                                    {{ "Add " + props.title }}
                                </PrimaryButton>
                            </Link>
                        </div>
                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg"
                        >
                            <table
                                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="post in posts.data"
                                        :key="post.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                        >
                                            {{ post.id }}
                                        </th>
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                        >
                                            {{ post.title }}
                                        </th>

                                        <td class="px-6 py-4">
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.posts.edit',
                                                        post.id
                                                    )
                                                "
                                                class="px-4 py-2 text-white bg-blue-600 rounded-lg"
                                                >Edit</Link
                                            >
                                        </td>
                                        <td class="px-6 py-4">
                                            <PrimaryButton
                                                :buttonType="'button'"
                                                class="bg-red-700"
                                                @click="destroy(post.id)"
                                            >
                                                Delete
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="props.posts.meta.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
