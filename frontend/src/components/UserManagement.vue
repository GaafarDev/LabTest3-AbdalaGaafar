<template>
    <div class="container mt-5">
      <div class="row">
        <!-- User Form Section -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <form @submit.prevent="submitForm">
                <div class="mb-3 row">
                  <label for="name" class="col-sm-3 col-form-label">Name :</label>
                  <div class="col-sm-9">
                    <input v-model="user.name" type="text" class="form-control" id="name">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="email" class="col-sm-3 col-form-label">Email :</label>
                  <div class="col-sm-9">
                    <input v-model="user.email" type="email" class="form-control" id="email">
                  </div>
                </div>
                <input v-model="user.id" type="hidden"> 
                <div class="mt-3">
                  <button type="submit" class="btn btn-success me-2" :disabled="!isFormValid || isLoading">
                    Save
                  </button>
                  <button type="button" class="btn btn-primary" :disabled="!isEditing || !isFormValid || isLoading" @click="handleUpdateUser">
                    Update
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
  
        <!-- User List Section -->
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title mb-3">List of Users</h5>
              <hr>
              <div v-if="users.length === 0" class="text-center">
                - No user yet -
              </div>
              <div v-else>
                <div v-for="user in users" :key="user.id" class="card mb-2 border border-primary">
                  <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                    <div class="text-center flex-grow-1">
                      <div class="fw-bold">{{ user.name }}</div>
                      <div class="text-muted small">({{ user.email }})</div>
                    </div>
                    <div class="d-flex flex-column">
                      <button @click="editUser(user)" class="btn btn-primary btn-sm mb-1">Choose</button>
                      <button @click="handleDeleteUser(user.id)" class="btn btn-danger btn-sm">Remove</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { mapState, mapActions } from 'vuex';
  
  export default {
    name: 'UserManagement',
    data() {
      return {
        user: {
          id: null,
          name: '',
          email: ''
        },
        errors: {
          name: '',
          email: ''
        },
        isEditing: false
      };
    },
    computed: {
      ...mapState(['users', 'error']),
      isLoading() {
        return this.$store.getters.isLoading;
      },
      isFormValid() {
        return !this.errors.name && !this.errors.email && this.user.name && this.user.email;
      }
    },
    methods: {
      ...mapActions(['addUser', 'updateUser', 'fetchUsers', 'deleteUser']),
      validateName() {
        this.errors.name = this.user.name.trim() ? '' : 'Name is required';
      },
      validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.user.email.trim()) {
          this.errors.email = 'Email is required';
        } else if (!emailRegex.test(this.user.email)) {
          this.errors.email = 'Invalid email format';
        } else {
          this.errors.email = '';
        }
      },
      validateForm() {
        this.validateName();
        this.validateEmail();
        return this.isFormValid;
      },
      async submitForm() {
        if (this.validateForm()) {
          try {
            console.log('Adding new user:', this.user);
            await this.$store.dispatch('addUser', this.user);
            await this.$store.dispatch('fetchUsers');
            this.resetForm();
          } catch (error) {
            console.error('Error adding user:', error);
          }
        }
      },
      async handleUpdateUser() {
        if (this.validateForm()) {
          try {
            console.log('Updating user, current user state:', this.user);
            await this.$store.dispatch('updateUser', { id: this.user.id, userData: this.user });
            await this.$store.dispatch('fetchUsers');
            this.resetForm();
          } catch (error) {
            console.error('Error updating user:', error);
          }
        }
      },
      editUser(user) {
        console.log('Editing user:', user);
        this.user = { ...user };
        this.isEditing = true;
        console.log('After setting user for edit:', this.user);
      },
      async handleDeleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
          try {
            await this.$store.dispatch('deleteUser', id);
            await this.$store.dispatch('fetchUsers');
          } catch (error) {
            console.error('Error deleting user:', error);
          }
        }
      },
      resetForm() {
        this.user = { id: null, name: '', email: '' };
        this.errors = { name: '', email: '' };
        this.isEditing = false;
      }
    },
    async created() {
      try {
        await this.$store.dispatch('fetchUsers');
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    }
  };
  </script>
  
  <style scoped>
  .card.mb-2 {
    border-radius: 10px;
    border: 2px solid #007bff;
    background-color: #f0f4ff;
  }
  
  .card-body .fw-bold {
    font-size: 1rem;
  }
  
  .card-body .text-muted {
    font-size: 0.875rem;
  }
  </style>
  