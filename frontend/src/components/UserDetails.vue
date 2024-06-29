<template>
    <div class="user-details">
      <h2>User Details</h2>
      <div v-if="isLoading">Loading...</div>
      <div v-else-if="error">{{ error }}</div>
      <div v-else-if="user">
        <p><strong>ID:</strong> {{ user.id }}</p>
        <p><strong>Name:</strong> {{ user.name }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
        <p><strong>Created At:</strong> {{ user.created_at }}</p>
        <p><strong>Updated At:</strong> {{ user.updated_at }}</p>
        <router-link :to="'/user/' + user.id + '/edit'" class="btn btn-warning">Edit</router-link>
        <router-link to="/users" class="btn btn-secondary">Back to List</router-link>
      </div>
      <div v-else>
        <p>User not found.</p>
      </div>
    </div>
  </template>
  
  <script>
  import { mapState, mapActions, mapGetters } from 'vuex'
  
  export default {
    name: 'UserDetails',
    computed: {
      ...mapState(['users', 'error']),
      ...mapGetters(['isLoading']),
      user() {
        return this.users.find(u => u.id === parseInt(this.$route.params.id))
      }
    },
    methods: {
      ...mapActions(['fetchUsers'])
    },
    async created() {
      if (!this.user) {
        try {
          await this.fetchUsers()
          console.log('Fetched users:', this.users)
        } catch (error) {
          console.error('Error fetching users:', error)
        }
      }
    }
  }
  </script>