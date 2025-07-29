<template>
    <div class="water-form">
        <h2>Water Intake Tracker</h2>
        <div class="glasses">
            <button
                v-for="n in maxGlasses"
                :key="n"
                :class="{'filled': n <= count}"
                @click="setCount(n)"
                aria-label="Glass of water"
                type="button"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path
                        d="M7 2h10l-1 16.5a3 3 0 0 1-6 0L7 2z"
                        :fill="n <= count ? '#2196f3' : 'none'"
                    />
                </svg>
            </button>
        </div>

        <p>You have drunk {{ count }} out of {{ maxGlasses }} glasses today.</p>

        <button @click="save" class="save-btn" :disabled="isSaving" type="button">
            {{ isSaving ? 'Saving...' : 'Save' }}
        </button>
        <button @click="reset" class="reset-btn" type="button">Reset</button>

        <p v-if="message" class="message">{{ message }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const maxGlasses = 8
const count = ref(0)
const isSaving = ref(false)
const message = ref('')

function setCount(n) {
    count.value = n
    message.value = ''
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
                date: new Date().toISOString().slice(0, 10) // e.g., "2025-07-22"
            })
        })

        if (!response.ok) throw new Error('Failed to save.')

        message.value = 'Water intake saved!'
    } catch (error) {
        console.log(error);
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
.glasses {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin: 1rem 0;
}
button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}
.filled svg path {
    fill: #2196f3 !important;
}
.save-btn,
.reset-btn {
    margin: 0.5rem 0.5rem 0 0.5rem;
    padding: 0.5rem 1rem;
    background: #2196f3;
    color: #fff;
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
