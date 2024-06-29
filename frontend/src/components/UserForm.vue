<template>
    <div class="user-form">
      <h2>{{ isEditing ? 'Edit User' : 'Create User' }}</h2>
      <div v-if="error" class="alert alert-danger">{{ error }}</div>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="name">Name:</label>
          <input v-model="user.name" type="text" class="form-control" id="name" @blur="validateName">
          <small class="text-danger" v-if="errors.name">{{ errors.name }}</small>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input v-model="user.email" type="email" class="form-control" id="email" @blur="validateEmail">
          <small class="text-danger" v-if="errors.email">{{ errors.email }}</small>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="!isFormValid || isLoading">
          {{ isEditing ? 'Update' : 'Create' }}
        </button>
      </form>
    </div>
  </template>
  
  <script>
  import { mapActions, mapState, mapGetters } from 'vuex'
  
  export default {
    name: 'UserForm',
    data() {
      return {
        user: {
          name: '',
          email: ''
        },
        errors: {
          name: '',
          email: ''
        },
        isEditing: false
      }
    },
    computed: {
      ...mapState(['error']),
      ...mapGetters(['isLoading']),
      isFormValid() {
        return !this.errors.name && !this.errors.email && this.user.name && this.user.email
      }
    },
    methods: {
      ...mapActions(['addUser', 'updateUser', 'fetchUsers']),
      validateName() {
        this.errors.name = this.user.name.trim() ? '' : 'Name is required'
      },
      validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        if (!this.user.email.trim()) {
          this.errors.email = 'Email is required'
        } else if (!emailRegex.test(this.user.email)) {
          this.errors.email = 'Invalid email format'
        } else {
          this.errors.email = ''
        }
      },
      validateForm() {
        this.validateName()
        this.validateEmail()
        return this.isFormValid
      },
      async submitForm() {
        if (this.validateForm()) {
          try {
            if (this.isEditing) {
              await this.updateUser({ id: this.$route.params.id, userData: this.user })
            } else {
              const result = await this.addUser(this.user)
              console.log('User added:', result)
            }
            await this.fetchUsers()  // Fetch updated user list
            this.$router.push('/users')
          } catch (error) {
            console.error('Error submitting form:', error)
          }
        }
      }
    },
    async created() {
      if (this.$route.params.id) {
        this.isEditing = true
        try {
          await this.fetchUsers()
          const user = this.$store.state.users.find(u => u.id === parseInt(this.$route.params.id))
          if (user) {
            this.user = { ...user }
          }
        } catch (error) {
          console.error('Error fetching user:', error)
        }
      }
    }
  }
  </script>