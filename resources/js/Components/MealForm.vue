<template>
    <form @submit.prevent="saveMeal">
        <div class="mb-4">
            <InputLabel for="mealName" value="Meal Name" />
            <TextInput
                id="mealName"
                v-model="meal.name"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
            />
        </div>
        <div class="mb-4">
            <InputLabel for="calories" value="Number of Calories" />
            <TextInput
                id="calories"
                v-model.number="meal.calories"
                type="number"
                min="0"
                class="mt-1 block w-full"
                required
            />
        </div>
        <PrimaryButton type="submit">
            Save Meal
        </PrimaryButton>
    </form>
</template>

<script setup>
import { ref } from 'vue'
import InputLabel from './InputLabel.vue'
import TextInput from './TextInput.vue'
import PrimaryButton from './PrimaryButton.vue'

const meal = ref({
    name: '',
    calories: null,
})

function saveMeal() {
    // Replace with your save logic (emit, API call, etc.)
    alert(`Meal Saved: ${meal.value.name} (${meal.value.calories} calories)`)
    meal.value = { name: '', calories: null }
}
</script>