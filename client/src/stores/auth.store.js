import { defineStore } from 'pinia'
import router from '@/router'
import authService from '@/services/auth.service'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    isLoading: false,
    error: null
  }),
  actions: {
    async login(credentials) {
      this.isLoading = true;
  this.error = null;
  
  try {
    const response = await authService.login(credentials);
    
    // HANDLE DIFFERENT RESPONSE FORMATS
    const token = response.token || response.data?.token;
    const user = response.user || response.data?.user;
    
    if (!token) {
      throw new Error('Token not received in response');
    }
    
    this.token = token;
    this.user = user;
    localStorage.setItem('token', token);
    
    router.push({ name: 'dashboard' });
      } catch (error) {
        console.error('Login error:', error);
        this.error = error.response?.data?.error || 'Authentication failed';
      } finally {
        this.isLoading = false;
      }
    },
    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem('token');
      router.push({ name: 'login' });
    },
    initialize() {
      this.token = localStorage.getItem('token');
    }
  }
})