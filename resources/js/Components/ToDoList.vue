<template>
  <div class="todo-list">
    <form @submit.prevent="addTask">
      <input v-model="newTaskText" placeholder="Add a new task" />
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
import { ref, onMounted } from 'vue'

const tasks = ref([])
const newTaskText = ref('')

// Fetch the tasks when the component mounts
onMounted(async () => {
  const response = await fetch('/tasks')
  if (response.ok) {
    tasks.value = await response.json()
  }
})

async function addTask() {
  if (!newTaskText.value.trim()) return

  const response = await fetch('/tasks', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({ text: newTaskText.value })
  })

  if (response.ok) {
    const task = await response.json()
    tasks.value.push(task)
    newTaskText.value = ''
  }
}

async function toggleTask(task) {
  const response = await fetch(`/tasks/${task.id}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({ completed: !task.completed })
  })

  if (response.ok) {
    task.completed = !task.completed
  }
}

async function deleteTask(id) {
  const response = await fetch(`/tasks/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }
  })

  if (response.ok) {
    tasks.value = tasks.value.filter(task => task.id !== id)
  }
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
