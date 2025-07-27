<template>
  <div class="bg-white shadow rounded-lg">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900">Notifications</h2>
        <div class="flex space-x-2">
          <button 
            @click="notificationStore.markAllAsRead"
            :disabled="notificationStore.unreadCount === 0"
            class="text-indigo-600 hover:text-indigo-900 disabled:opacity-50"
          >
            Tout marquer comme lu
          </button>
          <button 
            @click="notificationStore.clearAll"
            class="text-red-600 hover:text-red-900"
          >
            Tout effacer
          </button>
        </div>
      </div>

      <div v-if="notificationStore.notifications.length === 0" class="text-center py-8 text-gray-500">
        Aucune notification
      </div>

      <ul v-else class="divide-y divide-gray-200">
        <li 
          v-for="notification in notificationStore.notifications" 
          :key="notification.id"
          :class="{'bg-blue-50': !notification.read}"
          class="p-4 hover:bg-gray-50 cursor-pointer"
          @click="handleNotificationClick(notification)"
        >
          <div class="flex justify-between">
            <div>
              <div class="flex items-center">
                <div 
                  v-if="!notification.read" 
                  class="h-3 w-3 bg-blue-500 rounded-full mr-2"
                ></div>
                <h3 class="font-medium text-gray-900">{{ notification.title }}</h3>
              </div>
              <p class="text-sm text-gray-600 mt-1">{{ notification.message }}</p>
              <p class="text-xs text-gray-400 mt-2">
                {{ formatDate(notification.timestamp) }}
              </p>
            </div>
            <button 
              v-if="!notification.read"
              @click.stop="notificationStore.markAsRead(notification.id)"
              class="text-indigo-600 hover:text-indigo-900"
            >
              Marquer comme lu
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { useNotificationStore } from '@/stores/notification.store'
import { useRouter } from 'vue-router'

const notificationStore = useNotificationStore()
const router = useRouter()

const formatDate = (date) => {
  return new Date(date).toLocaleString('fr-FR', {
    hour: '2-digit',
    minute: '2-digit',
    day: '2-digit',
    month: 'short'
  })
}

const handleNotificationClick = (notification) => {
  notificationStore.markAsRead(notification.id)
  
  if (notification.taskId) {
    router.push({ name: 'dashboard' })
  }
}
</script>