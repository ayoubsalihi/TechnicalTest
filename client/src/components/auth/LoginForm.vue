<template>
  <form class="mt-8 space-y-6" @submit.prevent="login">
    <div class="rounded-md shadow-sm -space-y-px">
      <div>
        <label for="email" class="sr-only">Email</label>
        <input 
          id="email" 
          v-model="credentials.email" 
          type="email" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Email"
        >
      </div>
      <div>
        <label for="password" class="sr-only">Mot de passe</label>
        <input 
          id="password" 
          v-model="credentials.password" 
          type="password" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
          placeholder="Mot de passe"
        >
      </div>
    </div>

    <div v-if="authStore.error" class="text-red-500 text-sm">
      {{ authStore.error }}
    </div>

    <div>
      <button 
        type="submit" 
        :disabled="authStore.isLoading"
        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        :class="{'opacity-50 cursor-not-allowed': authStore.isLoading}"
      >
        <span v-if="authStore.isLoading">Connexion en cours...</span>
        <span v-else>Se connecter</span>
      </button>
    </div>
    
    <div class="text-center">
      <router-link 
        to="/register" 
        class="text-sm text-indigo-600 hover:text-indigo-800"
      >
        Pas encore de compte? Inscrivez-vous
      </router-link>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth.store'

const authStore = useAuthStore()
const credentials = ref({ email: '', password: '' })

const login = async () => {
  // Clear previous errors
  authStore.error = null;
  
  await authStore.login(credentials.value)
  
  // DEBUG: Check if token was stored
  if (authStore.token) {
    console.log('Login successful! Token:', authStore.token);
    console.log('LocalStorage token:', localStorage.getItem('token'));
  }
}
</script>