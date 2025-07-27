<template>
  <form class="mt-8 space-y-6" @submit.prevent="register" enctype="multipart/form-data">
    <div class="rounded-md shadow-sm -space-y-px">
      <!-- full_name Field -->
      <div>
        <label for="full_name" class="sr-only">Nom complet</label>
        <input 
          id="full_name" 
          v-model="userData.full_name" 
          type="text" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Nom complet"
        >
      </div>
      
      <!-- Email Field -->
      <div>
        <label for="email" class="sr-only">Email</label>
        <input 
          id="email" 
          v-model="userData.email" 
          type="email" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Email"
        >
      </div>
      
      <!-- Password Field -->
      <div>
        <label for="password" class="sr-only">Mot de passe</label>
        <input 
          id="password" 
          v-model="userData.password" 
          type="password" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Mot de passe"
        >
      </div>
      
      <!-- Confirm Password Field -->
      <div>
        <label for="password_confirmation" class="sr-only">Confirmer le mot de passe</label>
        <input 
          id="password_confirmation" 
          v-model="userData.password_confirmation" 
          type="password" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Confirmer le mot de passe"
        >
      </div>
      
      <!-- Phone Field -->
      <div>
        <label for="phone" class="sr-only">Téléphone</label>
        <input 
          id="phone_number" 
          v-model="userData.phone_number" 
          type="text" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Téléphone"
        >
      </div>
      
      <!-- Address Field -->
      <div>
        <label for="address" class="sr-only">Adresse</label>
        <input 
          id="address" 
          v-model="userData.address" 
          type="text" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Adresse"
        >
      </div>
      
      <!-- Image Upload Field -->
      <div class="pt-3 pb-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
        <div class="flex items-center">
          <div class="mr-4">
            <img 
              v-if="previewImage" 
              :src="previewImage" 
              class="w-16 h-16 rounded-full object-cover border-2 border-gray-300"
            >
            <div v-else class="bg-gray-200 border-2 border-dashed rounded-full w-16 h-16"></div>
          </div>
          <div class="flex-1">
            <input 
              type="file" 
              ref="fileInput"
              accept="image/*"
              @change="handleImageUpload"
              class="hidden"
            >
            <button 
              type="button"
              @click="$refs.fileInput.click()"
              class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200 transition-colors"
            >
              Choisir une image
            </button>
            <p v-if="userData.image" class="text-xs text-gray-500 mt-1 truncate">
              {{ userData.image.name }}
            </p>
            <p v-else class="text-xs text-gray-500 mt-1">JPG, PNG (max 2MB)</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Error Message -->
    <div v-if="authStore.error" class="text-red-500 text-sm">
      {{ authStore.error }}
    </div>

    <!-- Submit Button -->
    <div>
      <button 
        type="submit" 
        :disabled="authStore.isLoading"
        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        :class="{'opacity-50 cursor-not-allowed': authStore.isLoading}"
      >
        <span v-if="authStore.isLoading">Inscription en cours...</span>
        <span v-else>S'inscrire</span>
      </button>
    </div>
    
    <!-- Login Link -->
    <div class="text-center">
      <router-link 
        to="/login" 
        class="text-sm text-indigo-600 hover:text-indigo-800"
      >
        Déjà un compte? Connectez-vous
      </router-link>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth.store'

const authStore = useAuthStore()
const fileInput = ref(null)
const previewImage = ref(null)

const userData = ref({
  full_name: '',
  email: '',
  password: '',
  password_confirmation: '',
  phone_number: '',
  address: '',
  image: null
})

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  
  if (file) {
    // Validate file type
    if (!file.type.match('image.*')) {
      authStore.error = 'Veuillez sélectionner une image valide (JPG, PNG)'
      return
    }
    
    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
      authStore.error = 'La taille de l\'image ne doit pas dépasser 2MB'
      return
    }
    
    userData.value.image = file
    authStore.error = null
    
    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      previewImage.value = e.target.result
    }
    reader.readAsDataURL(file)
  } else {
    userData.value.image = null
    previewImage.value = null
  }
}

const register = async () => {
  await authStore.register(userData.value)
}
</script>