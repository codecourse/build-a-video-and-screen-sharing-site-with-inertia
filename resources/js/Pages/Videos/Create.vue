<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive, computed, watch } from 'vue'

const state = reactive({
    stream: null,
    audioStream: null,
    streamActive: computed(() => state.stream?.active)
})

const player = ref(null)
const shouldCaptureAudio = ref(true)

const captureAudio = () => {
    navigator.mediaDevices.getUserMedia({
        video: false,
        audio: {
            echoCancellation: true,
            noiseSuppression: true,
            autoGainControl: true,
        }
    }).then((stream) => {
        state.audioStream = stream
    })
}

const captureWebcam = () => {
    if (shouldCaptureAudio.value === true) {
        captureAudio()
    }

    navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false
    }).then((stream) => {
        state.stream = stream
    })
}

const captureScreen = () => {
    if (shouldCaptureAudio.value === true) {
        captureAudio()
    }

    navigator.mediaDevices.getDisplayMedia({
        video: true,
        audio: false
    }).then((stream) => {
        state.stream = stream
    })
}

watch(() => state.stream, (stream) => {
    player.value.srcObject = stream
})
</script>

<template>
    <Head title="Capture" />

    <AuthenticatedLayout>
        <div class="py-12">
            {{ state }}
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div v-show="state.streamActive">
                            <video ref="player" autoplay></video>
                        </div>

                        <div class="flex items-center justify-center space-x-4" v-if="!state.streamActive">
                            <PrimaryButton v-on:click="captureWebcam">
                                Capture webcam
                            </PrimaryButton>

                            <PrimaryButton v-on:click="captureScreen">
                                Capture screen
                            </PrimaryButton>

                            <div class="space-x-2 flex items-center">
                                <Checkbox id="audio" v-model:checked="shouldCaptureAudio" />
                                <label for="audio" class="font-medium text-sm">Enable audio</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
