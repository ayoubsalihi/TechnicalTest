<template>
  <div class="bg-white shadow rounded-lg">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 mb-4">Liste des tâches</h2>
      
      <div class="flex justify-between items-center mb-4">
        <input
          v-model="searchQuery"
          placeholder="Rechercher des tâches..."
          class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
        />
        <button 
          @click="openCreateModal"
          class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Nouvelle Tâche
        </button>
      </div>

      <div v-if="taskStore.isLoading" class="text-center py-8">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500 mx-auto"></div>
      </div>

      <div v-else-if="taskStore.error" class="text-red-500 text-center py-4">
        {{ taskStore.error }}
      </div>

      <div v-else-if="filteredTasks.length === 0" class="text-center py-8 text-gray-500">
        Aucune tâche trouvée
      </div>

      <ul v-else class="divide-y divide-gray-200">
        <TaskItem
          v-for="task in filteredTasks"
          :key="task.id"
          :task="task"
          @edit="openEditModal(task)"
          @delete="deleteTask(task.id)"
        />
      </ul>
    </div>

    <TaskFormModal
      v-if="isModalOpen"
      :task="currentTask"
      @close="isModalOpen = false"
      @submit="handleSubmit"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import TaskItem from '@/components/tasks/TaskItem.vue'
import TaskFormModal from '@/components/tasks/TaskForm.vue'
import { useTaskStore } from '@/stores/task.store'

const taskStore = useTaskStore()
const isModalOpen = ref(false)
const currentTask = ref(null)
const searchQuery = ref('')

const filteredTasks = computed(() => {
  if (!searchQuery.value) return taskStore.tasks
  const query = searchQuery.value.toLowerCase()
  return taskStore.tasks.filter(task => 
    task.title.toLowerCase().includes(query) ||
    (task.description && task.description.toLowerCase().includes(query))
  )
})

const openCreateModal = () => {
  currentTask.value = null
  isModalOpen.value = true
}

const openEditModal = (task) => {
  currentTask.value = { ...task }
  isModalOpen.value = true
}

const handleSubmit = async (taskData) => {
  if (taskData.id) {
    await taskStore.updateTask(taskData.id, taskData)
  } else {
    await taskStore.createTask(taskData)
  }
  isModalOpen.value = false
}

const deleteTask = async (id) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
    await taskStore.deleteTask(id)
  }
}

onMounted(() => {
  taskStore.fetchTasks()
})
</script>