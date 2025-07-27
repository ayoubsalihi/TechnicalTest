<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
          {{ task ? 'Modifier la tâche' : 'Nouvelle tâche' }}
        </h3>
        
        <form @submit.prevent="submit">
          <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input 
              id="title" 
              v-model="formData.title" 
              type="text" 
              required 
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
          </div>
          
          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea 
              id="description" 
              v-model="formData.description" 
              rows="3"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            ></textarea>
          </div>
          
          <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
            <select 
              id="status" 
              v-model="formData.status" 
              required
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
            >
              <option value="pending">En attente</option>
              <option value="complet">Terminé</option>
            </select>
          </div>
          
          <div class="flex justify-end space-x-3">
            <button 
              type="button" 
              @click="$emit('close')"
              class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
            >
              Annuler
            </button>
            <button 
              type="submit" 
              class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
            >
              {{ task ? 'Mettre à jour' : 'Créer' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  task: Object
})

const emit = defineEmits(['submit', 'close'])

const formData = ref({
  title: '',
  description: '',
  status: 'pending'
})

watch(() => props.task, (newTask) => {
  if (newTask) {
    formData.value = { ...newTask }
  } else {
    formData.value = {
      title: '',
      description: '',
      status: 'pending'
    }
  }
}, { immediate: true })

const submit = () => {
  emit('submit', formData.value)
}
</script>