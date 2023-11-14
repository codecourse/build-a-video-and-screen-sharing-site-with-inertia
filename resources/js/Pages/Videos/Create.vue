<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive, computed, watch } from 'vue'

const state = reactive({
    stream: null,
    audioStream: null,
    recorder: null,
    blob: null,
    blobUrl: computed(() => state.blob ? URL.createObjectURL(state.blob) : null),
    streamActive: computed(() => state.stream?.active),
    isRecording: computed(() => state.recorder ? state.recorder.state === 'recording' : false),
})

const player = ref(null)
const videoPreview = ref(null)
const shouldCaptureAudio = ref(true)

const startRecording = () => {
    let chunks = []

    const stream = new MediaStream([
        ...state.stream.getTracks(),
        ...(state.audioStream ? state.audioStream.getTracks() : [])
    ])

    state.recorder = new MediaRecorder(stream)

    state.recorder.ondataavailable = event => {
        if (!event.data || event.data.size <= 0) {
            return
        }

        chunks.push(event.data)
    }

    state.recorder.onstop = () => {
        const blob = new Blob(chunks, {
            type: 'video/mp4'
        })

        state.blob = blob

        chunks = []
    }

    state.recorder.start(300)
}

const stopRecording = () => {
    state.recorder.stream.getTracks().forEach(track => track.stop())
    state.stream = null
    state.recorder = null
}

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

watch(() => state.blobUrl, (url) => {
    videoPreview.value.src = url
})
</script>

<template>
    <Head title="Capture" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-show="state.blobUrl">
                            <video controls ref="videoPreview"></video>
                        </div>

                        <div v-show="!state.blobUrl">
                            <div v-show="state.streamActive" class="space-y-6">
                                <video ref="player" autoplay></video>

                                <div class="flex justify-center">
                                    <PrimaryButton v-on:click="startRecording" v-if="!state.isRecording">
                                        Start recording
                                    </PrimaryButton>

                                    <DangerButton v-on:click="stopRecording" v-if="state.isRecording">
                                        Stop recording
                                    </DangerButton>
                                </div>
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
        </div>
    </AuthenticatedLayout>
</template>
