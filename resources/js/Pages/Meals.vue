<script setup>
import MealManager from '@/Components/MealManager.vue'
</script>

<template>
  <h1>Meals Page</h1>
  <p>This is another page using the same layout.</p>
  <MealManager />
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
  layout: AppLayout,
}
</script>
