<template>
    <div class="meal-manager">
        <!-- Form -->
        <form @submit.prevent="saveMeal" class="mb-6">
            <div class="mb-4">
                <InputLabel for="type" value="Meal Type" />
                <select id="type" v-model="meal.type" class="mt-1 block w-full border rounded p-2" required>
                    <option value="" disabled>Select a meal type</option>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                    <option value="snack">Snack</option>
                </select>
            </div>

            <div class="mb-4">
                <InputLabel for="description" value="Meal Description" />
                <TextInput id="description" v-model="meal.description" type="text" class="mt-1 block w-full" required />
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <InputLabel for="calories" value="Calories" />
                    <TextInput id="calories" v-model.number="meal.calories" type="number" min="0" class="mt-1 block w-full" required />
                </div>
                <div>
                    <InputLabel for="protein" value="Protein (g)" />
                    <TextInput id="protein" v-model.number="meal.protein" type="number" min="0" class="mt-1 block w-full" />
                </div>
                <div>
                    <InputLabel for="carbs" value="Carbs (g)" />
                    <TextInput id="carbs" v-model.number="meal.carbs" type="number" min="0" class="mt-1 block w-full" />
                </div>
                <div>
                    <InputLabel for="fat" value="Fat (g)" />
                    <TextInput id="fat" v-model.number="meal.fat" type="number" min="0" class="mt-1 block w-full" />
                </div>
            </div>

            <PrimaryButton type="submit" class="mt-4">
                {{ meal.id ? 'Update Meal' : 'Add Meal' }}
            </PrimaryButton>
        </form>

        <!-- Meal List -->
        <div v-if="meals.length" class="meal-list">
            <h2 class="text-lg font-semibold mb-2">Your Meals</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-2 py-1 text-left">Type</th>
                            <th class="px-2 py-1 text-left">Description</th>
                            <th class="px-2 py-1">Calories</th>
                            <th class="px-2 py-1">Protein</th>
                            <th class="px-2 py-1">Carbs</th>
                            <th class="px-2 py-1">Fat</th>
                            <th class="px-2 py-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="m in meals" :key="m.id" class="border-t">
                            <td class="px-2 py-1">{{ m.type }}</td>
                            <td class="px-2 py-1">{{ m.description }}</td>
                            <td class="px-2 py-1 text-center">{{ m.calories }}</td>
                            <td class="px-2 py-1 text-center">{{ m.protein }}</td>
                            <td class="px-2 py-1 text-center">{{ m.carbs }}</td>
                            <td class="px-2 py-1 text-center">{{ m.fat }}</td>
                            <td class="px-2 py-1 text-center">
                                <button @click="editMeal(m)" class="text-blue-600 mr-2">Edit</button>
                                <button @click="deleteMeal(m.id)" class="text-red-600">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import InputLabel from './InputLabel.vue'
import TextInput from './TextInput.vue'
import PrimaryButton from './PrimaryButton.vue'

const meals = ref([])

// Generate today's date as YYYYMMDD
const todayId = parseInt(new Date().toISOString().slice(0, 10).replace(/-/g, ''))

const meal = ref({
    id: null,
    daily_log_id: 1,
    type: '',
    description: '',
    calories: null,
    protein: null,
    carbs: null,
    fat: null,
})

async function fetchMeals() {
    const response = await fetch('/api/meals')
    if (response.ok) {
        meals.value = await response.json()
    }
}

function editMeal(mealItem) {
    meal.value = { ...mealItem }
}

async function saveMeal() {
    const method = meal.value.id ? 'PUT' : 'POST'
    const url = meal.value.id ? `/api/meals/${meal.value.id}` : `/api/meals`

    await fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(meal.value)
    })

    await fetchMeals()
    meal.value = {
        id: null,
        daily_log_id: 1,
        type: '',
        description: '',
        calories: null,
        protein: null,
        carbs: null,
        fat: null
    }
}

async function deleteMeal(id) {
    await fetch(`/api/meals/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
        },
    })

    await fetchMeals()
}

onMounted(fetchMeals)
</script>

<style scoped>
.meal-manager {
    max-width: 900px;
    margin: 0 auto;
    padding: 1rem;
    overflow: auto;
}
table th,
table td {
    border: 1px solid #ccc;
}
</style>
