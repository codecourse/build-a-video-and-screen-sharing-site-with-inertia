<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    video: Object
})
</script>

<template>
    <GuestLayout class="sm:max-w-3xl space-y-6">
        <video controls :src="`/${video.video_path}`" class="w-full"></video>

        <div>
            <h2 class="font-semibold text-lg">{{ video.title }}</h2>
            <p v-if="video.description">{{ video.description }}</p>
        </div>
    </GuestLayout>
</template>
