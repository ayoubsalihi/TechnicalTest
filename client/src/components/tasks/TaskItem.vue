<template>
  <li class="py-4">
    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-lg font-medium text-gray-900">{{ task.title }}</h3>
        <p v-if="task.description" class="text-gray-500 mt-1">{{ task.description }}</p>
        <div class="mt-2 flex items-center">
          <span 
            :class="{
              'bg-yellow-100 text-yellow-800': task.status === 'pending',
              'bg-green-100 text-green-800': task.status === 'complet'
            }"
            class="px-2 py-1 text-xs font-medium rounded-full capitalize"
          >
            {{ task.status }}
          </span>
          <span class="text-gray-400 text-sm ml-3">
            {{ formatDate(task.created_at) }}
          </span>
        </div>
      </div>
      <div class="flex space-x-2">
        <button 
          @click="$emit('edit', task)"
          class="text-indigo-600 hover:text-indigo-900"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
        </button>
        <button 
          @click="$emit('delete', task.id)"
          class="text-red-600 hover:text-red-900"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
    </div>
  </li>
</template>

<script setup>
defineProps({
  task: {
    type: Object,
    required: true
  }
})

defineEmits(['edit', 'delete'])

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}
</script>