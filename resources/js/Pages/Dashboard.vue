<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    threads: Object,
});
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>

                <ul role="list" class="divide-y divide-gray-200">
                    <Link v-for="thread in threads" :href="route('messages.index', thread.id)">
                        <li class="flex py-4">
                            <img class="h-10 w-10 rounded-full"
                                 src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                 alt="">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ thread.subject }}</p>
                                <!--                            <p class="text-sm text-gray-500">calvin.hawkins@example.com</p>-->
                            </div>
                        </li>
                    </Link>
                </ul>
                <Link :href="route('create-thread')">
                    <PrimaryButton class="mt-4">
                        Créer une discussion
                    </PrimaryButton>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
