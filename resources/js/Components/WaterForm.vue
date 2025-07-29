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
            <button @click="decrement" :disabled="count <= 0">-</button>
            <span class="count">{{ count }}</span>
            <button @click="increment" :disabled="count >= maxGlasses">+</button>
        </div>

        <p>You have drunk {{ count }} out of {{ maxGlasses }} glasses today.</p>

        <div class="actions">
            <button @click="save" class="save-btn" :disabled="isSaving">
                {{ isSaving ? 'Saving...' : 'Save' }}
            </button>
            <button @click="reset" class="reset-btn" type="button">Reset</button>
        </div>

        <p v-if="message" class="message">{{ message }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import waterGlass from '../../icons/water-glass.png'

const maxGlasses = 8
const count = ref(0)
const isSaving = ref(false)
const message = ref('')

function increment() {
    if (count.value < maxGlasses) {
        count.value++
        message.value = ''
    }
}

function decrement() {
    if (count.value > 0) {
        count.value--
        message.value = ''
    }
}

function reset() {
    count.value = 0
    message.value = ''
}

async function save() {
    isSaving.value = true
    message.value = ''

    try {
        const response = await fetch('/water-intake', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                glasses: count.value,
                date: new Date().toISOString().slice(0, 10)
            })
        })

        if (!response.ok) throw new Error('Failed to save.')

        message.value = 'Water intake saved!'
    } catch (error) {
        console.log(error)
        message.value = 'Error saving water intake.'
    } finally {
        isSaving.value = false
    }
}
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

.message {
    margin-top: 1rem;
    color: #4caf50;
}
</style>
