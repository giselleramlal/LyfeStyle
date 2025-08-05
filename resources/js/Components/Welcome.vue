<script setup>
import { router } from '@inertiajs/vue3'
import MealForm from '@/Components/MealManager.vue';
import WaterForm from '@/Components/WaterForm.vue';
import SleepForm from './SleepForm.vue';
import ToDoList from '@/Components/ToDoList.vue';
</script>

<template>
    <div>
        <!-- Header Section -->
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200 rounded-lg shadow">
            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Welcome {{ $page.props.auth.user.name }}!
            </h1>
            <p class="mt-6 text-gray-500 leading-relaxed">
                Track your daily health goals including meals, macros, sleep, and hydration. Stay consistent and level up your wellness.
            </p>
        </div>

        <!-- Meal Form Section (Full Row) -->
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 gap-6 p-6 lg:p-8">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Add Meals & Calories</h2>
                <form>
                    <MealForm />
                </form>
            </div>
        </div>

        <!-- Sleep, Water, and Tasks Section (Stack on mobile, row on large screens) -->
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-6 lg:px-8 pb-8">
            <!-- Sleep -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Log Sleep</h2>
                <form>
                    <SleepForm />
                </form>
            </div>

            <!-- Water -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Track Water Intake</h2>
                <form>
                    <WaterForm />
                </form>
            </div>

            <!-- ToDo -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Today's Tasks</h2>
                <form>
                    <ToDoList />
                </form>
            </div>
        </div>
    </div>
</template>
