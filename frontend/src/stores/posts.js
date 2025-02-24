import { defineStore } from 'pinia'
import axios from 'axios'

export const usePostStore = defineStore('posts', {
  state: () => ({
    posts: [],
    statuses: [],
    loading: false,
    error: null,
    initialized: false
  }),

  getters: {
    getPostById: (state) => (id) => {
      return state.posts.find(post => post.id === id)
    },
    hasError: (state) => !!state.error,
    isLoading: (state) => state.loading,
    isInitialized: (state) => {
      console.log('Checking initialization:', {
        initialized: state.initialized,
        statusesLength: state.statuses.length
      })
      return state.initialized && state.statuses.length > 0
    }
  },

  actions: {
    setLoading(value) {
      this.loading = value
    },

    setError(error) {
      this.error = error
      // Auto-clear error after 5 seconds
      setTimeout(() => {
        this.error = null
      }, 5000)
    },

    clearError() {
      this.error = null
    },

    async initialize() {
      console.log('Starting initialization')
      if (this.initialized) {
        console.log('Already initialized')
        return
      }
      
      this.setLoading(true)
      try {
        const [posts, statuses] = await Promise.all([
          this.fetchPosts(),
          this.fetchStatuses()
        ])
        console.log('Initialization complete:', {
          postsCount: posts.length,
          statusesCount: statuses.length
        })
        this.initialized = true
      } catch (error) {
        console.error('Error initializing store:', error)
        this.setError('Error al inicializar la aplicación')
        throw error
      } finally {
        this.setLoading(false)
      }
    },

    async fetchPosts(searchQuery = '') {
      this.clearError()
      try {
        let url = '/posts'
        if (searchQuery) {
          url += `?search=${encodeURIComponent(searchQuery)}`
        }
        console.log('Fetching posts with URL:', url)
        
        const response = await axios.get(url)
        console.log('API Response:', response.data)
        
        this.posts = Array.isArray(response.data) ? response.data : []
        
        this.posts = this.posts.map(post => ({
          ...post,
          status: {
            id: post.status_id,
            name: post.status
          }
        }))
        
        console.log('Posts after update:', this.posts)
        return this.posts
      } catch (error) {
        this.setError('Error al cargar los posts')
        console.error('Error fetching posts:', error)
        throw error
      } finally {
        this.setLoading(false)
      }
    },

    async fetchStatuses() {
      this.setLoading(true)
      try {
        const response = await axios.get('statuses')
        console.log('Statuses response:', response.data)
        this.statuses = response.data || []
        console.log('Updated statuses in store:', this.statuses)
        return this.statuses
      } catch (error) {
        console.error('Error fetching statuses:', error)

        this.statuses = [{
          id: 1,
          name: 'Draft'
        }, {
          id: 2,
          name: 'Published'
        }, {
          id: 3,
          name: 'Protected'
        }]
        return this.statuses
      } finally {
        this.setLoading(false)
      }
    },

    async createPost(post) {
      this.loading = true
      this.error = null
      try {
        const postData = {
          ...post,
          user_id: 1
        }
        console.log('Creating post with data:', postData)
        const response = await axios.post('/posts', postData)
        this.posts.push(response.data)
        this.loading = false
        return response.data
      } catch (error) {
        console.error('Error creating post:', error)
        this.error = 'Error al crear el post'
        this.loading = false
        throw error
      }
    },

    async updatePost(post) {
      this.setLoading(true)
      this.setError(null)
      try {

        const status_id = parseInt(post.status_id)
        if (isNaN(status_id)) {
          throw new Error('status_id inválido')
        }

        const postData = {
          id: post.id,
          title: post.title,
          summary: post.summary || '',
          content: post.content || '',
          user_id: 1,
          status_id: status_id
        }

        console.log('Updating post with data:', postData)
        const response = await axios.put(`/posts/${post.id}`, postData)
        console.log('Update response:', response.data)

        const updatedPost = {
          ...response.data,
          status: {
            id: response.data.status_id,
            name: response.data.status
          }
        }

        const index = this.posts.findIndex(p => p.id === post.id)
        if (index !== -1) {
          this.posts[index] = updatedPost
        }

        this.setLoading(false)
        return updatedPost
      } catch (error) {
        console.error('Error updating post:', error)
        this.setError('Error al actualizar el post')
        this.setLoading(false)
        throw error
      }
    },

    async deletePost(postId) {
      this.setLoading(true)
      this.setError(null)
      try {
        await axios.delete(`/posts/${postId}`)
        this.posts = this.posts.filter(post => post.id !== postId)
      } catch (error) {
        this.setError('Error al eliminar el post')
        console.error('Error deleting post:', error)
        throw error
      } finally {
        this.setLoading(false)
      }
    },

    async downloadPostPdf(postId) {
      this.setLoading(true)
      this.setError(null)
      try {
        const response = await axios.get(`/posts/${postId}/pdf`, {
          responseType: 'blob'
        })
        const url = window.URL.createObjectURL(new Blob([response.data]))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', `post-${postId}.pdf`)
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
      } catch (error) {
        this.setError('Error al descargar el PDF')
        console.error('Error downloading PDF:', error)
        throw error
      } finally {
        this.setLoading(false)
      }
    }
  }
})
