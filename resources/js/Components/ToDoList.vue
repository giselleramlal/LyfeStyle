<template>
    <div class="todo-list">
        <form @submit.prevent="form.post('/tasks')">
            <input v-model="form.text" placeholder="Add a new task" />
            <button type="submit">Add</button>
        </form>

        <ul>
            <li v-for="task in tasks" :key="task.id">
                <label class="todo-item">
                    <input type="checkbox" :checked="task.completed" @change="toggleTask(task)" />
                    <span :class="{ completed: task.completed }">{{ task.text }}</span>
                </label>
                <button @click="deleteTask(task.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    tasks: Array
})

const form = useForm({
    text: ''
})

function toggleTask(task) {
    router.patch(`/tasks/${task.id}`, {
        completed: !task.completed
    })
}

function deleteTask(id) {
    router.delete(`/tasks/${id}`)
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
