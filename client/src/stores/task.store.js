import { defineStore } from 'pinia'
import TaskService from '@/services/task.service'

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
    currentTask: null,
    isLoading: false,
    error: null
  }),
  
  actions: {
    async fetchTasks() {
      try {
        this.isLoading = true
        const response = await TaskService.getAll()
        this.tasks = response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to fetch tasks'
      } finally {
        this.isLoading = false
      }
    },
    
    async createTask(taskData) {
      try {
        this.isLoading = true
        const response = await TaskService.create(taskData)
        this.tasks.push(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to create task'
        throw error
      } finally {
        this.isLoading = false
      }
    },
    
    async updateTask(id, taskData) {
      try {
        this.isLoading = true
        await TaskService.update(id, taskData)
        
        const index = this.tasks.findIndex(t => t.id === id)
        if (index !== -1) {
          this.tasks[index] = { ...this.tasks[index], ...taskData }
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to update task'
        throw error
      } finally {
        this.isLoading = false
      }
    },
    
    async deleteTask(id) {
      try {
        this.isLoading = true
        await TaskService.delete(id)
        this.tasks = this.tasks.filter(task => task.id !== id)
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to delete task'
        throw error
      } finally {
        this.isLoading = false
      }
    }
  }
})