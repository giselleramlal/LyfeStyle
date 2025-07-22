<template>
    <form @submit.prevent="submitForm" class="sleep-form">
        <div>
            <label for="date">Date:</label>
            <input type="date" v-model="sleep.date" id="date" required />
        </div>
        <div>
            <label for="start">Sleep Start:</label>
            <input type="time" v-model="sleep.start" id="start" required />
        </div>
        <div>
            <label for="end">Sleep End:</label>
            <input type="time" v-model="sleep.end" id="end" required />
        </div>
        <div>
            <label for="notes">Notes:</label>
            <textarea v-model="sleep.notes" id="notes" placeholder="Optional"></textarea>
        </div>
        <button type="submit">Track Sleep</button>
    </form>
</template>

<script>
export default {
    name: "SleepForm",
    data() {
        return {
            sleep: {
                date: "",
                start: "",
                end: "",
                notes: ""
            }
        };
    },
    methods: {
        submitForm() {
            // Emit the sleep data to parent or handle API call here
            this.$emit('submit', { ...this.sleep });
            // Reset form
            this.sleep = { date: "", start: "", end: "", notes: "" };
        }
    }
};
</script>

<style scoped>
.sleep-form {
    max-width: 400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.sleep-form label {
    font-weight: bold;
}
.sleep-form input,
.sleep-form textarea {
    width: 100%;
    padding: 0.5rem;
    box-sizing: border-box;
}
</style>