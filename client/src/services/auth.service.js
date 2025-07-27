import api from './api'

export default {
  async register(userData) {
    const formData = new FormData()
    
    // Append all form fields
    Object.entries(userData).forEach(([key, value]) => {
      if (value !== null && value !== undefined) {
        if (key === 'image' && value instanceof File) {
          formData.append(key, value)
        } 
        // For other fields, convert to string (exemple d'image)
        else {
          formData.append(key, String(value))
        }
      }
    })
    
    const response = await api.post('/auth/register', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    
    return response.data
  },
  
  async login(credentials) {
    const response = await api.post('/auth/login', credentials)
    return response.data
  }
}