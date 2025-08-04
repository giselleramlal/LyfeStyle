<template>
  <div class="water-form">
    <h2>Water Intake Tracker</h2>

    <div class="glass-display">
      <img
        :src="waterGlass"
        alt="Water Glass"
        class="water-glass"
      />
    </div>

    <div class="counter-controls">
      <button type="button" @click="decrement" :disabled="count <= 0">-</button>
      <span class="count">{{ count }}</span>
      <button type="button" @click="increment" :disabled="count >= maxGlasses">+</button>
    </div>

    <p>You have drunk {{ count }} out of {{ maxGlasses }} glasses today.</p>

    <div class="actions">
      <button type="button" @click="save" class="save-btn" :disabled="form.processing">
        {{ form.processing ? 'Saving...' : 'Save' }}
      </button>
      <button type="button" @click="reset" class="reset-btn">Reset</button>
    </div>

    <p v-if="message" class="message">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import waterGlass from '../../icons/water-glass.png'

const maxGlasses = 8
const count = ref(0)
const waterIntakeId = ref(null)
const message = ref('')
const editing = ref(false)

const form = useForm({
    glasses: 0,
    date: new Date().toISOString().split('T')[0],
})

function increment() {
    if (count.value < maxGlasses) {
        count.value++
        form.glasses = count.value
        message.value = ''
    }
}

function decrement() {
    if (count.value > 0) {
        count.value--
        form.glasses = count.value
        message.value = ''
    }
}

function reset() {
    count.value = 0
    form.glasses = 0
    message.value = ''
}

function save() {
    message.value = ''
    form.date = new Date().toISOString().split('T')[0]
    form.glasses = count.value

    const url = waterIntakeId.value
        ? route('water-intake.update', waterIntakeId.value)
        : route('water-intake.store')

    const method = waterIntakeId.value ? 'put' : 'post'

    form[method](url, {
        onSuccess: (data) => {
            message.value = 'Water intake saved successfully!'
            if (data && data.id) waterIntakeId.value = data.id
        },
        onError: () => {
            message.value = 'Error saving water intake.'
        }
    })
}

async function fetchTodaysWaterIntake() {
    // try {
    //     const today = new Date().toISOString().split('T')[0]
    //     const response = await fetch(`/api/water-intake/today?date=${today}`, {
    //         headers: { 'Accept': 'application/json' }
    //     })

    //     if (response.ok) {
    //         const data = await response.json()
    //         if (data.water_intake) {
    //             count.value = data.water_intake.glasses
    //             form.glasses = data.water_intake.glasses
    //             waterIntakeId.value = data.water_intake.id
    //         }
    //     }
    // } catch (error) {
    //     console.error('Error fetching water intake:', error)
    // }
}

onMounted(fetchTodaysWaterIntake)
</script>

<style scoped>
.water-form {
    max-width: 400px;
    margin: 2rem auto;
    text-align: center;
}

.glass-display {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
    margin: 1rem 0;
}

.water-glass {
    width: 40px;
    height: 40px;
    object-fit: contain;
}

.counter-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.counter-controls button {
    background: #2196f3;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    border-radius: 4px;
    cursor: pointer;
}

.counter-controls button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.count {
    font-size: 1.5rem;
    font-weight: bold;
}

.actions {
    margin-top: 1rem;
}

.save-btn,
.reset-btn {
    margin: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: #2196f3;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.save-btn[disabled] {
    opacity: 0.6;
    cursor: not-allowed;
}

.reset-btn {
    background: #dc3545;
}

.message {
    margin-top: 1rem;
    color: #4caf50;
}
</style>