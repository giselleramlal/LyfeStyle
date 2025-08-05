<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="bg-transparent py-12">
            <div class="bg-transparent max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-transparent overflow-hidden">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
