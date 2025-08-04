<template>
  <div class="todo-list">
    <form @submit.prevent="addTask">
      <input 
        v-model="form.text" 
        placeholder="Add a new task" 
        :disabled="form.processing"
      />
      <button type="submit" :disabled="form.processing || !form.text.trim()">
        {{ form.processing ? 'Adding...' : 'Add' }}
      </button>
    </form>

    <div v-if="error" class="error-message">
      {{ error }}
    </div>

    <ul v-if="tasks.length > 0">
      <li v-for="task in tasks" :key="task.id" class="task-item">
        <label class="todo-item">
          <input 
            type="checkbox" 
            :checked="task.completed" 
            @change="toggleTask(task)"
            :disabled="task.updating"
          />
          <span :class="{ completed: task.completed }">{{ task.text }}</span>
        </label>
        <button 
          @click="deleteTask(task.id)" 
          :disabled="task.deleting"
          class="delete-btn"
        >
          {{ task.deleting ? 'Deleting...' : 'Delete' }}
        </button>
      </li>
    </ul>

    <div v-else-if="!form.processing" class="empty-state">
      No tasks yet. Add one above!
    </div>

    <div v-if="form.processing && tasks.length === 0" class="loading">
      Loading tasks...
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const tasks = ref([])
const error = ref('')

// Inertia form for adding a task
const form = useForm({
  text: '',
  daily_log_id: parseInt(new Date().toISOString().slice(0, 10).replace(/-/g, '')) // Generate today's date as YYYYMMDD
})

// Fetch tasks from the backend (GET)
async function fetchTasks() {
  error.value = ''
  form.processing = true
  try {
    const response = await fetch('/tasks', {
      headers: {
        'Accept': 'application/json'
      }
    })
    if (response.ok) {
      tasks.value = await response.json()
    } else {
      throw new Error(`Failed to fetch tasks: ${response.status}`)
    }
  } catch (err) {
    error.value = 'Failed to load tasks. Please try again.'
    console.error('Error fetching tasks:', err)
  } finally {
    form.processing = false
  }
}

onMounted(fetchTasks)

// Add a new task using Inertia form
function addTask() {
  if (!form.text.trim()) return

  form.post(route('tasks.store'), {
    preserveScroll: true,
    onSuccess: (response) => {
      fetchTasks()
      form.reset()
    },
    onError: () => {
      error.value = 'Failed to add task. Please try again.'
    }
  })
}

// Toggle task completion using Inertia
function toggleTask(task) {
  task.updating = true
  router.patch(route('tasks.update', task.id), { completed: !task.completed }, {
    preserveScroll: true,
    onSuccess: () => {
      task.completed = !task.completed
    },
    onError: () => {
      error.value = 'Failed to update task. Please try again.'
    },
    onFinish: () => {
      task.updating = false
    }
  })
}

// Delete a task using Inertia
function deleteTask(id) {
  const task = tasks.value.find(t => t.id === id)
  if (task) task.deleting = true
  router.delete(route('tasks.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
      tasks.value = tasks.value.filter(t => t.id !== id)
    },
    onError: () => {
      error.value = 'Failed to delete task. Please try again.'
      if (task) task.deleting = false
    }
  })
}
</script>

<style scoped>
.todo-list {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

form {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
  flex-wrap: wrap; /* Add this line */
}

input[type="text"] {
  flex: 1;
  padding: 10px;
  border: 2px solid #e1e5e9;
  border-radius: 6px;
  font-size: 14px;
}

input[type="text"]:focus {
  outline: none;
  border-color: #0066cc;
}

button {
  padding: 10px 16px;
  background-color: #0066cc;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.2s;
  height: 100%;
}

button:hover:not(:disabled) {
  background-color: #0052a3;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.task-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px;
  border: 1px solid #e1e5e9;
  border-radius: 6px;
  margin-bottom: 8px;
  background-color: #fff;
}

.todo-item {
  display: flex;
  align-items: center;
  flex: 1;
  cursor: pointer;
}

.todo-item input[type="checkbox"] {
  margin-right: 12px;
  transform: scale(1.2);
}

.completed {
  text-decoration: line-through;
  color: #888;
}

.delete-btn {
  background-color: #dc3545;
  padding: 6px 12px;
  font-size: 12px;
  margin-left: 12px;
}

.delete-btn:hover:not(:disabled) {
  background-color: #c82333;
}

.error-message {
  background-color: #f8d7da;
  color: #721c24;
  padding: 12px;
  border-radius: 6px;
  margin-bottom: 16px;
  border: 1px solid #f5c6cb;
}

.loading {
  text-align: center;
  color: #666;
  padding: 20px;
}

.empty-state {
  text-align: center;
  color: #666;
  padding: 40px 20px;
  font-style: italic;
}

ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
</style>