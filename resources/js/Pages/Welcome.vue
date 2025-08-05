<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    appName: {
        type: String,
        default: 'LifeStyle',
    },
    appVersion: {
        type: String,
        default: '1.0.0',
    },
});
</script>

<template>
    <Head title="Welcome to LifeStyle" />
    <div class="bg-gradient-to-br from-green-50 via-white to-blue-50 text-gray-800 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-white">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-green-500 selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-600 rounded-xl flex items-center justify-center lg:w-16 lg:h-16">
                                <ApplicationLogo class="w-8 h-8 lg:w-10 lg:h-10 text-white" />
                            </div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent lg:text-3xl">
                                {{ appName }}
                            </h1>
                        </div>
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-lg px-4 py-2 text-gray-700 ring-1 ring-transparent transition hover:text-gray-900 hover:bg-white/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800/50 dark:focus-visible:ring-green-400"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-lg px-4 py-2 text-gray-700 ring-1 ring-transparent transition hover:text-gray-900 hover:bg-white/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800/50 dark:focus-visible:ring-green-400"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="ml-2 rounded-lg px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 text-white transition hover:from-green-600 hover:to-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 shadow-lg"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <!-- Hero Section -->
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6 lg:text-6xl">
                            Transform Your Daily Habits
                        </h2>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                            Take control of your wellness journey with our unified platform. Track meals, hydration, sleep, workouts, and daily goals all in one simple dashboard.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link 
                                v-if="canRegister" 
                                :href="route('register')"
                                class="px-8 py-3 bg-gradient-to-r from-green-500 to-blue-600 text-white rounded-lg font-semibold transition hover:from-green-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            >
                                Start Your Journey
                            </Link>
                            <button class="px-8 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold transition hover:bg-gray-50 dark:hover:bg-gray-800">
                                See How It Works
                            </button>
                        </div>
                    </div>

                    <!-- Features Grid -->
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8 mb-16">
                        <div class="flex flex-col items-start rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg ring-1 ring-gray-200/50 transition duration-300 hover:shadow-xl hover:ring-gray-300/50 dark:bg-gray-800/80 dark:ring-gray-700/50 dark:hover:ring-gray-600/50">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-red-500 mb-4">
                                <svg class="size-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Nutrition Tracking</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Log your meals and monitor your daily nutrition intake. Keep track of what you eat and stay accountable to your dietary goals.
                            </p>
                        </div>

                        <div class="flex flex-col items-start rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg ring-1 ring-gray-200/50 transition duration-300 hover:shadow-xl hover:ring-gray-300/50 dark:bg-gray-800/80 dark:ring-gray-700/50 dark:hover:ring-gray-600/50">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 mb-4">
                                <svg class="size-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Hydration Monitor</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Track your daily water intake and stay properly hydrated. Set reminders and monitor your hydration patterns over time.
                            </p>
                        </div>

                        <div class="flex flex-col items-start rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg ring-1 ring-gray-200/50 transition duration-300 hover:shadow-xl hover:ring-gray-300/50 dark:bg-gray-800/80 dark:ring-gray-700/50 dark:hover:ring-gray-600/50">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 mb-4">
                                <svg class="size-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Sleep Tracking</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Monitor your sleep patterns and quality. Log bedtime, wake time, and sleep quality to optimize your rest and recovery.
                            </p>
                        </div>

                        <div class="flex flex-col items-start rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg ring-1 ring-gray-200/50 transition duration-300 hover:shadow-xl hover:ring-gray-300/50 dark:bg-gray-800/80 dark:ring-gray-700/50 dark:hover:ring-gray-600/50">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-green-400 to-emerald-500 mb-4">
                                <svg class="size-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Workout Logger</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Record your workouts and fitness activities. Track progress, set fitness goals, and maintain consistency in your exercise routine.
                            </p>
                        </div>

                        <div class="flex flex-col items-start rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg ring-1 ring-gray-200/50 transition duration-300 hover:shadow-xl hover:ring-gray-300/50 dark:bg-gray-800/80 dark:ring-gray-700/50 dark:hover:ring-gray-600/50">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-pink-400 to-rose-500 mb-4">
                                <svg class="size-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Habit & Task Manager</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Build healthy habits and manage daily tasks. Set goals, track streaks, and create routines that stick for long-term success.
                            </p>
                        </div>

                        <div class="flex flex-col items-start rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg ring-1 ring-gray-200/50 transition duration-300 hover:shadow-xl hover:ring-gray-300/50 dark:bg-gray-800/80 dark:ring-gray-700/50 dark:hover:ring-gray-600/50">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 mb-4">
                                <svg class="size-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Unified Dashboard</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                View all your wellness data in one centralized location. Get insights, track progress, and stay motivated with comprehensive analytics.
                            </p>
                        </div>
                    </div>

                    <!-- Problem/Solution Section -->
                    <div class="mb-16">
                        <div class="rounded-xl bg-gradient-to-r from-green-500/10 to-blue-500/10 p-8 backdrop-blur-sm">
                            <div class="text-center mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                    Struggling to Maintain Healthy Habits?
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6">
                                    In today's fast-paced world, many people find it challenging to consistently track their wellness activities. Juggling multiple apps and notebooks makes it nearly impossible to see the big picture of your health journey.
                                </p>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-8 items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Why Choose LifeStyle?</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">One platform for all your wellness needs</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">Simple, intuitive interface</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">Comprehensive progress tracking</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">Goal setting and achievement tracking</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-green-400 to-blue-500 rounded-full mb-4">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Everything you need in one beautiful dashboard
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-gray-500 dark:text-gray-400">
                    {{ appName }} v{{ appVersion }} - Your Personal Wellness Companion
                </footer>
            </div>
        </div>
    </div>
</template>