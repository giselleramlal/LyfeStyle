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
        <button @click="reset" class="reset-btn" type="button">Reset</button>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const maxGlasses = 8
const count = ref(0)

function setCount(n) {
    count.value = n
}

function reset() {
    count.value = 0
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
.reset-btn {
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    background: #2196f3;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>