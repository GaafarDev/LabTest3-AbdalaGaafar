<template>
  <div class="container mt-5">
    <h2 class="mb-4">User List</h2>
    <div v-if="error" class="alert alert-danger">{{ error }}</div>
    <div v-if="isLoading" class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div v-else>
      <table v-if="users.length > 0" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>
              <router-link :to="'/user/' + user.id" class="btn btn-sm btn-info me-2">View</router-link>
              <router-link :to="'/user/' + user.id + '/edit'" class="btn btn-sm btn-warning me-2">Edit</router-link>
              <button @click="handleDeleteUser(user.id)" class="btn btn-sm btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else class="alert alert-warning">No users found.</div>
      <router-link to="/user/new" class="btn btn-primary mt-3">Add New User</router-link>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex'

export default {
  name: 'UserList',
  computed: {
    ...mapState(['users', 'error']),
    ...mapGetters(['isLoading'])
  },
  methods: {
    ...mapActions(['fetchUsers', 'deleteUser']),
    async handleDeleteUser(id) {
      if (confirm('Are you sure you want to delete this user?')) {
        try {
          await this.deleteUser(id)
          await this.fetchUsers()
        } catch (error) {
          console.error('Error deleting user:', error)
        }
      }
    }
  },
  async created() {
    try {
      await this.fetchUsers()
      console.log('Users in component:', this.users)
    } catch (error) {
      console.error('Error fetching users in component:', error)
    }
  }
}
</script>
