<template>
    <form @submit.prevent="submitForm" class="max-w-xl mx-auto p-8 bg-gray-50 rounded-lg shadow">
        <div class="mb-6">
            <label for="date" class="block font-semibold mb-2 text-gray-700">Date:</label>
            <input 
                type="date" 
                v-model="form.date" 
                id="date" 
                required 
                :max="today"
                class="w-full p-3 border-2 border-gray-200 rounded focus:border-blue-500 focus:outline-none text-base"
            />
            <span v-if="errors.date" class="block text-red-600 text-sm mt-1">{{ errors.date }}</span>
        </div>
        
        <div class="mb-6">
            <label for="sleep_time" class="block font-semibold mb-2 text-gray-700">Sleep Time:</label>
            <input 
                type="time" 
                v-model="form.sleep_time" 
                id="sleep_time" 
                required 
                class="w-full p-3 border-2 border-gray-200 rounded focus:border-blue-500 focus:outline-none text-base"
            />
            <span v-if="errors.sleep_time" class="block text-red-600 text-sm mt-1">{{ errors.sleep_time }}</span>
        </div>
        
        <div class="mb-6">
            <label for="wake_time" class="block font-semibold mb-2 text-gray-700">Wake Time:</label>
            <input 
                type="time" 
                v-model="form.wake_time" 
                id="wake_time" 
                required 
                class="w-full p-3 border-2 border-gray-200 rounded focus:border-blue-500 focus:outline-none text-base"
            />
            <span v-if="errors.wake_time" class="block text-red-600 text-sm mt-1">{{ errors.wake_time }}</span>
        </div>
        
        <div class="mb-6">
            <label for="quality" class="block font-semibold mb-2 text-gray-700">Sleep Quality (1-10):</label>
            <select v-model="form.quality" id="quality" required
                class="w-full p-3 border-2 border-gray-200 rounded focus:border-blue-500 focus:outline-none text-base">
                <option value="">Select quality</option>
                <option v-for="n in 10" :key="n" :value="n">{{ n }}</option>
            </select>
            <span v-if="errors.quality" class="block text-red-600 text-sm mt-1">{{ errors.quality }}</span>
        </div>
        
        <div class="mb-6">
            <label for="notes" class="block font-semibold mb-2 text-gray-700">Notes:</label>
            <textarea 
                v-model="form.notes" 
                id="notes" 
                placeholder="Optional notes about your sleep"
                rows="3"
                class="w-full p-3 border-2 border-gray-200 rounded focus:border-blue-500 focus:outline-none text-base"
            ></textarea>
        </div>
        
        <div class="bg-blue-50 p-4 rounded text-center mb-6 text-blue-700" v-if="calculatedDuration">
            <strong>Duration: {{ calculatedDuration }}</strong>
        </div>
        
        <button type="submit" :disabled="processing"
            class="w-full p-4 bg-blue-600 text-white rounded font-semibold text-lg transition-colors duration-300 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed">
            {{ processing ? 'Saving...' : 'Track Sleep' }}
        </button>
    </form>
</template>

<script>
import { useForm } from '@inertiajs/vue3'

export default {
    name: "SleepForm",
    props: {
        sleepLog: {
            type: Object,
            default: null
        }
    },
    setup(props) {
        const form = useForm({
            date: props.sleepLog?.date || new Date().toISOString().split('T')[0],
            sleep_time: props.sleepLog?.sleep_time || '',
            wake_time: props.sleepLog?.wake_time || '',
            quality: props.sleepLog?.quality || '',
            notes: props.sleepLog?.notes || ''
        })

        return { form }
    },
    data() {
        return {
            today: new Date().toISOString().split('T')[0]
        }
    },
    computed: {
        processing() {
            return this.form.processing
        },
        errors() {
            return this.form.errors
        },
        calculatedDuration() {
            if (!this.form.sleep_time || !this.form.wake_time || !this.form.date) {
                return null
            }
            
            // Create proper datetime strings
            const sleepDateTime = new Date(`${this.form.date}T${this.form.sleep_time}:00`)
            let wakeDateTime = new Date(`${this.form.date}T${this.form.wake_time}:00`)
            
            // If wake time is earlier than sleep time, assume it's the next day
            if (wakeDateTime <= sleepDateTime) {
                wakeDateTime.setDate(wakeDateTime.getDate() + 1)
            }
            
            const diffMs = wakeDateTime - sleepDateTime
            const hours = Math.floor(diffMs / (1000 * 60 * 60))
            const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60))
            
            return `${hours}h ${minutes}m`
        }
    },
    methods: {
        submitForm() {
            const url = this.sleepLog 
                ? route('sleep-logs.update', this.sleepLog.id)
                : route('sleep-logs.store')
                
            const method = this.sleepLog ? 'patch' : 'post'
            
            this.form[method](url, {
                onSuccess: () => {
                    if (!this.sleepLog) {
                        this.resetForm()
                    }
                    this.$emit('success')
                },
                onError: (errors) => {
                    console.error('Validation errors:', errors)
                }
            })
        },
        resetForm() {
            this.form.reset()
            this.form.date = new Date().toISOString().split('T')[0]
        }
    }
}
</script>

<style scoped>
.sleep-form {
    max-width: 500px;
    margin: 0 auto;
    padding: 2rem;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #007bff;
    outline: none;
}

.error {
    display: block;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.duration-display {
    background: #e3f2fd;
    padding: 1rem;
    border-radius: 4px;
    text-align: center;
    margin-bottom: 1.5rem;
    color: #1976d2;
}

.submit-btn {
    width: 100%;
    padding: 1rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-btn:hover:not(:disabled) {
    background: #0056b3;
}

.submit-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
}
</style>