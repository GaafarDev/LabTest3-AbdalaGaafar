<template>
  <div class="container mt-5">
    <h2 class="mb-4">User Details</h2>
    <div v-if="isLoading" class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div v-else-if="error" class="alert alert-danger">{{ error }}</div>
    <div v-else-if="user">
      <div class="card">
        <div class="card-body">
          <p><strong>ID:</strong> {{ user.id }}</p>
          <p><strong>Name:</strong> {{ user.name }}</p>
          <p><strong>Email:</strong> {{ user.email }}</p>
          <p><strong>Created At:</strong> {{ user.created_at }}</p>
          <p><strong>Updated At:</strong> {{ user.updated_at }}</p>
        </div>
      </div>
      <div class="mt-3">
        <router-link :to="'/user/' + user.id + '/edit'" class="btn btn-warning me-2">Edit</router-link>
        <router-link to="/users" class="btn btn-secondary">Back to List</router-link>
      </div>
    </div>
    <div v-else>
      <p class="alert alert-warning">User not found.</p>
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
