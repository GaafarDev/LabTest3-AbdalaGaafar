<template>
    <div class="user-list">
      <h2>User List</h2>
      <div v-if="error" class="alert alert-danger">{{ error }}</div>
      <div v-if="isLoading">Loading...</div>
      <table v-else-if="users.length > 0" class="table">
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
              <router-link :to="'/user/' + user.id" class="btn btn-sm btn-info">View</router-link>
              <router-link :to="'/user/' + user.id + '/edit'" class="btn btn-sm btn-warning">Edit</router-link>
              <button @click="handleDeleteUser(user.id)" class="btn btn-sm btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else>No users found.</div>
      <router-link to="/user/new" class="btn btn-primary">Add New User</router-link>
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
            await this.fetchUsers()  // Refresh the list after deletion
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