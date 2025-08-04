<template>
    <div class="meal-manager">
        <!-- Form -->
        <form @submit.prevent="saveMeal" class="mb-6">
            <div class="mb-4">
                <InputLabel for="type" value="Meal Type" />
                <select id="type" v-model="form.type" class="mt-1 block w-full border rounded p-2" required>
                    <option value="" disabled>Select a meal type</option>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                    <option value="snack">Snack</option>
                </select>
                <span v-if="form.errors.type" class="text-red-500 text-sm">{{ form.errors.type }}</span>
            </div>

            <div class="mb-4">
                <InputLabel for="description" value="Meal Description" />
                <TextInput 
                    id="description" 
                    v-model="form.description" 
                    type="text" 
                    class="mt-1 block w-full" 
                    placeholder="e.g., Grilled chicken with rice"
                    required 
                />
                <span v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <InputLabel for="calories" value="Calories" />
                    <TextInput 
                        id="calories" 
                        v-model.number="form.calories" 
                        type="number" 
                        min="0" 
                        max="9999"
                        step="0.1"
                        class="mt-1 block w-full" 
                        required 
                    />
                    <span v-if="form.errors.calories" class="text-red-500 text-sm">{{ form.errors.calories }}</span>
                </div>
                <div>
                    <InputLabel for="protein" value="Protein (g)" />
                    <TextInput 
                        id="protein" 
                        v-model.number="form.protein" 
                        type="number" 
                        min="0" 
                        max="999"
                        step="0.1"
                        class="mt-1 block w-full" 
                        placeholder="Optional"
                    />
                    <span v-if="form.errors.protein" class="text-red-500 text-sm">{{ form.errors.protein }}</span>
                </div>
                <div>
                    <InputLabel for="carbs" value="Carbs (g)" />
                    <TextInput 
                        id="carbs" 
                        v-model.number="form.carbs" 
                        type="number" 
                        min="0" 
                        max="999"
                        step="0.1"
                        class="mt-1 block w-full" 
                        placeholder="Optional"
                    />
                    <span v-if="form.errors.carbs" class="text-red-500 text-sm">{{ form.errors.carbs }}</span>
                </div>
                <div>
                    <InputLabel for="fat" value="Fat (g)" />
                    <TextInput 
                        id="fat" 
                        v-model.number="form.fat" 
                        type="number" 
                        min="0" 
                        max="999"
                        step="0.1"
                        class="mt-1 block w-full" 
                        placeholder="Optional"
                    />
                    <span v-if="form.errors.fat" class="text-red-500 text-sm">{{ form.errors.fat }}</span>
                </div>
            </div>

            <!-- Nutrition Summary -->
            <div v-if="showNutritionSummary" class="mt-4 p-4 bg-green-50 border border-green-200 rounded">
                <h3 class="font-semibold text-green-800 mb-2">Nutrition Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Calories:</span> {{ form.calories || 0 }}
                    </div>
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Protein:</span> {{ form.protein || 0 }}g
                    </div>
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Carbs:</span> {{ form.carbs || 0 }}g
                    </div>
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Fat:</span> {{ form.fat || 0 }}g
                    </div>
                </div>
            </div>

            <PrimaryButton type="submit" class="mt-4" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : (editingMeal ? 'Update Meal' : 'Add Meal') }}
            </PrimaryButton>
            
            <button 
                v-if="editingMeal" 
                type="button" 
                @click="cancelEdit" 
                class="ml-2 mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
            >
                Cancel
            </button>
        </form>

        <!-- Success/Error Messages -->
        <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ $page.props.flash.success }}
        </div>
        
        <div v-if="$page.props.flash?.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ $page.props.flash.error }}
        </div>

        <!-- Meal List -->
        <div v-if="meals.length" class="meal-list">
            <h2 class="text-lg font-semibold mb-4">Your Meals</h2>
            
            <!-- Daily Totals -->
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
                <h3 class="font-semibold text-blue-800 mb-2">Daily Totals</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Total Calories:</span> {{ dailyTotals.calories }}
                    </div>
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Total Protein:</span> {{ dailyTotals.protein }}g
                    </div>
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Total Carbs:</span> {{ dailyTotals.carbs }}g
                    </div>
                    <div class="bg-white p-2 rounded border">
                        <span class="font-medium">Total Fat:</span> {{ dailyTotals.fat }}g
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left border">Type</th>
                            <th class="px-3 py-2 text-left border">Description</th>
                            <th class="px-3 py-2 text-center border">Calories</th>
                            <th class="px-3 py-2 text-center border">Protein</th>
                            <th class="px-3 py-2 text-center border">Carbs</th>
                            <th class="px-3 py-2 text-center border">Fat</th>
                            <th class="px-3 py-2 text-center border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="meal in meals" :key="meal.id" class="border-t hover:bg-gray-50">
                            <td class="px-3 py-2 border capitalize">{{ meal.type }}</td>
                            <td class="px-3 py-2 border">{{ meal.description }}</td>
                            <td class="px-3 py-2 text-center border">{{ meal.calories || 0 }}</td>
                            <td class="px-3 py-2 text-center border">{{ meal.protein || 0 }}</td>
                            <td class="px-3 py-2 text-center border">{{ meal.carbs || 0 }}</td>
                            <td class="px-3 py-2 text-center border">{{ meal.fat || 0 }}</td>
                            <td class="px-3 py-2 text-center border">
                                <button 
                                    @click="editMeal(meal)" 
                                    class="text-blue-600 hover:text-blue-800 mr-2 px-2 py-1 text-sm"
                                    type="button"
                                >
                                    Edit
                                </button>
                                <button 
                                    @click="deleteMeal(meal)" 
                                    class="text-red-600 hover:text-red-800 px-2 py-1 text-sm"
                                    type="button"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div v-else class="text-center py-8 text-gray-500">
            <p>No meals added yet. Add your first meal above!</p>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import InputLabel from './InputLabel.vue'
import TextInput from './TextInput.vue'
import PrimaryButton from './PrimaryButton.vue'

// Props
const props = defineProps({
    initialMeals: {
        type: Array,
        default: () => []
    }
})

// State
const editingMeal = ref(null)
const meals = ref([...props.initialMeals])

// Fetch meals function
async function fetchMeals() {
    try {
        const response = await fetch('/api/meals', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        if (response.ok) {
            meals.value = await response.json()
        }
    } catch (error) {
        console.error('Error fetching meals:', error)
    }
}

// Load meals on mount
onMounted(() => {
    if (props.initialMeals.length === 0) {
        fetchMeals()
    }
})

// Form
const form = useForm({
    type: '',
    description: '',
    calories: '',
    protein: '',
    carbs: '',
    fat: '',
    daily_log_id: parseInt(new Date().toISOString().slice(0, 10).replace(/-/g, '')) // Generate today's date as YYYYMMDD
})

// Computed
const showNutritionSummary = computed(() => {
    return form.calories || form.protein || form.carbs || form.fat
})

const dailyTotals = computed(() => {
    return meals.value.reduce((totals, meal) => {
        totals.calories += parseFloat(meal.calories) || 0
        totals.protein += parseFloat(meal.protein) || 0
        totals.carbs += parseFloat(meal.carbs) || 0
        totals.fat += parseFloat(meal.fat) || 0
        return totals
    }, { calories: 0, protein: 0, carbs: 0, fat: 0 })
})

// Methods
function saveMeal() {
    const url = editingMeal.value 
        ? route('meals.update', editingMeal.value.id)
        : route('meals.store')
        
    const method = editingMeal.value ? 'patch' : 'post'
    
    form[method](url, {
        onSuccess: () => {
            resetForm()
        },
        onError: (errors) => {
            console.error('Validation errors:', errors)
        }
    })

    fetchMeals()
}

function editMeal(meal) {
    editingMeal.value = meal
    form.type = meal.type
    form.description = meal.description
    form.calories = meal.calories
    form.protein = meal.protein
    form.carbs = meal.carbs
    form.fat = meal.fat
    form.daily_log_id = meal.daily_log_id

    fetchMeals()
}

function cancelEdit() {
    editingMeal.value = null
    resetForm()
}

function deleteMeal(meal) {
    if (confirm(`Are you sure you want to delete "${meal.description}"?`)) {
        router.delete(route('meals.destroy', meal.id))
    }
    fetchMeals()
}

function resetForm() {
    editingMeal.value = null
    form.reset()
    // Reset daily_log_id to today's date
    form.daily_log_id = parseInt(new Date().toISOString().slice(0, 10).replace(/-/g, ''))
}
</script>

<style scoped>
.meal-manager {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1rem;
}

table {
    border-collapse: collapse;
}

table th,
table td {
    border: 1px solid #d1d5db;
}

.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}
</style>