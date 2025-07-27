import { defineStore } from 'pinia'
import echo from '@/services/echo'
import { useAuthStore } from '@/stores/auth.store'

export const useNotificationStore = defineStore('notification', {
  state: () => ({
    notifications: [],
    unreadCount: 0
  }),
  
  actions: {
    initWebSocket() {
      const authStore = useAuthStore()
      if (!authStore.user) return
      
      echo.private(`user.${authStore.user.id}`)
        .listen('TaskCreated', (e) => {
          this.addNotification({
            id: Date.now(),
            type: 'success',
            title: 'Nouvelle tâche créée',
            message: e.message,
            taskId: e.task_id,
            read: false,
            timestamp: new Date()
          })
        })
    },
    
    addNotification(notification) {
      this.notifications.unshift(notification)
      this.unreadCount++
    },
    
    markAsRead(id) {
      const notification = this.notifications.find(n => n.id === id)
      if (notification && !notification.read) {
        notification.read = true
        this.unreadCount--
      }
    },
    
    markAllAsRead() {
      this.notifications.forEach(n => {
        if (!n.read) {
          n.read = true
          this.unreadCount--
        }
      })
    },
    
    clearAll() {
      this.notifications = []
      this.unreadCount = 0
    }
  }
})