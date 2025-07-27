<template>
  <div class="min-h-screen flex flex-col">
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <!-- Logo -->
          <div class="flex items-center">
            <router-link to="/" class="text-xl font-bold text-indigo-600">TodoApp</router-link>
          </div>
          
          <!-- Navigation -->
          <nav class="flex space-x-4">
            <router-link 
              to="/" 
              class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100"
              :class="{'bg-gray-100': $route.name === 'dashboard'}"
            >
              Tâches
            </router-link>
            <router-link 
              to="/notifications" 
              class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 relative"
              :class="{'bg-gray-100': $route.name === 'notifications'}"
            >
              Notifications
              <span 
                v-if="notificationStore.unreadCount > 0" 
                class="absolute top-1 right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"
              >
                {{ notificationStore.unreadCount }}
              </span>
            </router-link>
          </nav>
          
          <!-- User Profile -->
          <div class="flex items-center">
            <div class="flex items-center mr-4">
              <!-- User Avatar with Image -->
              <div class="relative">
                <img 
                  v-if="authStore.user?.image" 
                  :src="authStore.user.image" 
                  class="w-10 h-10 rounded-full object-cover border-2 border-gray-300"
                >
                <div v-else class="bg-gray-200 border-2 border-dashed rounded-full w-10 h-10"></div>
              </div>
              <span class="ml-3 text-sm font-medium">{{ authStore.user?.name }}</span>
            </div>
            <button 
              @click="authStore.logout" 
              class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-md text-sm font-medium transition-colors"
            >
              Déconnexion
            </button>
          </div>
        </div>
      </div>
    </header>

    <main class="flex-grow">
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth.store'
import { useNotificationStore } from '@/stores/notification.store'

const authStore = useAuthStore()
const notificationStore = useNotificationStore()
</script>