<template>
  <AppLayout>
    <div class="flex flex-col h-full p-6 bg-gray-50">
      <div class="flex justify-between items-center mb-6 animate-fade-in">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
          <p class="text-gray-500 mt-1">Welcome back, {{ user.name }}! You have {{ taskStore.tasks.length }} tasks</p>
        </div>
        <div class="flex space-x-3">
          <Button variant="outline" size="sm">
            <i class="fas fa-filter mr-2"></i> Filter
          </Button>
          <Button @click="openCreateModal" size="sm">
            <i class="fas fa-plus mr-2"></i> Add a task
          </Button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 animate-slide-up" style="animation-delay: 0.1s">
        <StatCard 
          title="Total Tasks" 
          :value="taskStore.tasks.length" 
          icon="fas fa-tasks"
          color="bg-blue-100 text-blue-600"
          
        />
        <StatCard 
          title="Completed" 
          :value="completedTasks" 
          icon="fas fa-check-circle"
          color="bg-green-100 text-green-600"
          
        />
        <StatCard 
          title="In Progress" 
          :value="inProgressTasks" 
          icon="fas fa-sync-alt"
          color="bg-yellow-100 text-yellow-600"
          
        />
        <StatCard 
          title="Overdue" 
          :value="overdueTasks" 
          icon="fas fa-exclamation-circle"
          color="bg-red-100 text-red-600"
          
        />
      </div>

      <!-- Tasks Table -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 animate-slide-up" style="animation-delay: 0.2s">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-900">Recent Tasks</h2>
          <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
              v-model="searchQuery"
              placeholder="Search tasks..."
              class="pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            />
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Task
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Due Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Priority
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr 
                v-for="(task, index) in filteredTasks" 
                :key="task.id"
                class="hover:bg-gray-50 transition-colors duration-150 animate-fade-in"
                :style="`animation-delay: ${0.05 * index}s`"
              >
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                      <i class="fas fa-tasks text-blue-600"></i>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ task.title }}</div>
                      <div class="text-sm text-gray-500 truncate max-w-xs">{{ task.description }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Badge :variant="statusVariant(task.status)">
                    {{ task.status === 'complet' ? 'Completed' : 'Pending' }}
                  </Badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(task.due_date) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <span :class="priorityDotClass(task.priority)" class="h-2 w-2 rounded-full mr-2"></span>
                    <span class="text-sm text-gray-700 capitalize">{{ task.priority }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end space-x-2">
                    <Button 
                      variant="ghost" 
                      size="icon" 
                      @click="openEditModal(task)"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      <i class="fas fa-edit"></i>
                    </Button>
                    <Button 
                      variant="ghost" 
                      size="icon" 
                      @click="deleteTask(task.id)"
                      class="text-red-600 hover:text-red-900"
                    >
                      <i class="fas fa-trash"></i>
                    </Button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div v-if="filteredTasks.length === 0" class="text-center py-12 text-gray-500">
          <i class="fas fa-inbox text-3xl mb-2"></i>
          <p>No tasks found</p>
        </div>
      </div>
      <TaskFormModal
        v-if="isModalOpen"
        :task="currentTask"
        @close="isModalOpen = false"
        @submit="handleSubmit"
      />
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import TaskFormModal from '@/components/tasks/TaskForm.vue'
import { useTaskStore } from '@/stores/task.store'
import { useAuthStore } from '@/stores/auth.store'
import StatCard from '@/components/ui/StatCard.vue'
import Button from '@/components/ui/Button.vue'
import Badge from '@/components/ui/Badge.vue'

const taskStore = useTaskStore()
const authStore = useAuthStore()
const isModalOpen = ref(false)
const currentTask = ref(null)
const searchQuery = ref('')

const user = computed(() => authStore.user || { name: 'User' })

const completedTasks = computed(() => 
  taskStore.tasks.filter(t => t.status === 'complet').length
)

const inProgressTasks = computed(() => 
  taskStore.tasks.filter(t => t.status === 'pending').length
)

const overdueTasks = computed(() => 
  taskStore.tasks.filter(t => new Date(t.due_date) < new Date() && t.status !== 'complet').length
)

const filteredTasks = computed(() => {
  if (!searchQuery.value) return taskStore.tasks
  const query = searchQuery.value.toLowerCase()
  return taskStore.tasks.filter(task => 
    task.title.toLowerCase().includes(query) ||
    (task.description && task.description.toLowerCase().includes(query)))
})

onMounted(() => {
  taskStore.fetchTasks()
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
  if (confirm('Are you sure you want to delete this task?')) {
    await taskStore.deleteTask(id)
  }
}

const statusVariant = (status) => {
  return status === 'complet' ? 'success' : 'warning'
}

const priorityDotClass = (priority) => {
  return {
    high: 'bg-red-500',
    medium: 'bg-yellow-500',
    low: 'bg-green-500'
  }[priority] || 'bg-gray-400'
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

.animate-slide-up {
  animation: slideUp 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>