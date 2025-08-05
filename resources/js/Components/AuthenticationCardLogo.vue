<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from './ApplicationLogo.vue';
</script>

<template>
    <div class="flex flex-col items-center mb-6">
        <Link :href="'/'" class="flex justify-center items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-600 rounded-xl flex items-center justify-center lg:w-16 lg:h-16">
                <ApplicationLogo class="w-8 h-8 lg:w-10 lg:h-10 text-white" />
            </div>
        </Link>
        <h1 class="mt-3 text-3xl font-extrabold tracking-wide bg-gradient-to-br from-green-500 to-blue-600 text-transparent bg-clip-text drop-shadow text-center font-sans">
            LyfeStyle
        </h1>
    </div>
</template>

<style scoped>
</style>
