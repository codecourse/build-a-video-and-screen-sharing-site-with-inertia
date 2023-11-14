<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    videos: Array
})
</script>

<template>
    <Head title="Videos" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-3">
                <template v-if="videos.length">
                    <Link :href="route('videos.show', video)" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg" v-for="video in videos" :key="video.id">
                        <div class="p-6 text-gray-900 flex items-start space-x-6">
                            <div>
                                <div class="h-24 w-32 bg-black bg-cover rounded-lg" :style="`background-image: url(${video.still_path})`"></div>
                            </div>
                            <div>
                                <h2 class="font-semibold text-lg">{{ video.title }}</h2>
                                <p>{{ video.description ?? 'No description' }}</p>
                                <p class="text-gray-600 text-sm mt-6">
                                    Recorded on {{ video.created_at }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </template>
                <template v-else>
                    <div class="text-center font-medium">
                        Nothing here. <Link :href="route('videos.create')" class="text-indigo-500">Ready to capture your first video</Link>?
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
