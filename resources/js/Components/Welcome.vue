<script setup>
import { router } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import MacrosPieChart from '@/Components/MacrosPieChart.vue';
import MealForm from '@/Components/MealManager.vue';
import WaterForm from '@/Components/WaterForm.vue';
import SleepForm from './SleepForm.vue';
import ToDoList from '@/Components/ToDoList.vue';

// These are placeholders – replace with your actual chart or form components

//console.log(router.get('/daily-logs'));

</script>



<template>
    <div>
        <!-- Header Section -->
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200"> 

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Welcome {{ $page.props.auth.user.name }}!
            </h1>

            <p class="mt-6 text-gray-500 leading-relaxed">
                Track your daily health goals including meals, macros, sleep, and hydration. Stay consistent and level up your wellness.
            </p>
        </div>

        <!-- Dashboard Cards -->
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6 lg:p-8">

            <!-- Macros Pie Chart -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Macronutrient Breakdown</h2>
                <div class="h-48 flex items-center justify-center">
                    <MacrosPieChart />
                </div>
            </div>

            <!-- Add Meal Section -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Add Meals & Calories</h2>
                <form>
                    <MealForm />
                </form>
            </div>

            <!-- Add Sleep Section -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Log Sleep</h2>
                <form>
                    <!-- Replace with actual form components -->
                    <SleepForm />
                </form>
            </div>

            <!-- Add Water Intake Section -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Track Water Intake</h2>
                <form>
                    <!-- Replace with actual form components -->
                    <WaterForm />
                </form>
            </div>

            <!-- Add ToDo Section -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Today's Tasks</h2>
                <form>
                    <ToDoList />
                </form>
            </div>
        </div>
    </div>
</template>
