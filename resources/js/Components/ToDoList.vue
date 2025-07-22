<template>
    <div class="todo-list">
        <form @submit.prevent="addTask">
            <input v-model="newTask" placeholder="Add a new task" />
            <button type="submit">Add</button>
        </form>
        <ul>
            <li v-for="(task, index) in tasks" :key="index">
                <label class="todo-item">
                    <input type="checkbox" v-model="task.completed" />
                    <span :class="{ completed: task.completed }">{{ task.text }}</span>
                </label>
                <button @click="removeTask(index)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const tasks = ref([
    { text: 'Learn Vue.js', completed: false },
    { text: 'Build a to-do list', completed: false }
])
const newTask = ref('')

function addTask() {
    if (newTask.value.trim()) {
        tasks.value.push({ text: newTask.value, completed: false })
        newTask.value = ''
    }
}

function removeTask(index) {
    tasks.value.splice(index, 1)
}
</script>

<style scoped>
.todo-list {
    max-width: 400px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
}
.todo-item {
    display: flex;
    align-items: center;
}
.todo-item input[type="checkbox"] {
    margin-right: 8px;
}
.completed {
    text-decoration: line-through;
    color: #888;
}
button {
    margin-left: 8px;
}
</style>