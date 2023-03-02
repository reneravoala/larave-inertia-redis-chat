<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import {Link} from '@inertiajs/vue3';
import Discussion from '@/Pages/Messages/Discussion.vue'

defineProps({
    threads: Object,
    thread: Object,
    messages: Object,
    other: Object,
    user: Object,
});


</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Discussions
                </h2>
            </div>
        </template>

        <div class="flex">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <ul>
                            <li v-for="thread in threads" key="thread.id" class="p-2">
                                <Link :href="route('messages.index', thread.id)">{{ thread.subject }}</Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <Discussion :thread="thread" :messages="messages" :other="other" :user="user"></Discussion>
        </div>
        <Link :href="route('create-thread')">Créer une discussion</Link>
    </AuthenticatedLayout>
</template>
