import { createStore } from 'vuex';
import axios from '../axios';

export default createStore({
  state: {
    users: [],
    error: null,
    loading: false
  },
  mutations: {
    SET_USERS(state, users) {
      state.users = users;
    },
    ADD_USER(state, user) {
      state.users.push(user);
    },
    UPDATE_USER(state, updatedUser) {
      const index = state.users.findIndex(user => user.id === updatedUser.id);
      if (index !== -1) {
        state.users.splice(index, 1, updatedUser);
      }
    },
    DELETE_USER(state, userId) {
      state.users = state.users.filter(user => user.id !== userId);
    },
    SET_ERROR(state, error) {
      state.error = error;
    },
    SET_LOADING(state, isLoading) {
      state.loading = isLoading;
    }
  },
  actions: {
    async fetchUsers({ commit }) {
      commit('SET_LOADING', true);
      try {
        const response = await axios.get('/users');
        console.log('Fetched users:', response.data);
        commit('SET_USERS', response.data);
        commit('SET_ERROR', null);
      } catch (error) {
        commit('SET_ERROR', 'Failed to fetch users');
        commit('SET_USERS', []);
      } finally {
        commit('SET_LOADING', false);
      }
    },
    async addUser({ commit }, userData) {
      commit('SET_LOADING', true);
      try {
        const response = await axios.post('/users', userData);
        commit('ADD_USER', response.data);
        commit('SET_ERROR', null);
        return response.data;
      } catch (error) {
        commit('SET_ERROR', 'Failed to add user');
        throw error;
      } finally {
        commit('SET_LOADING', false);
      }
    },
    async updateUser({ commit }, { id, userData }) {
      commit('SET_LOADING', true);
      try {
        console.log('Updating user in store:', { id, userData }); 
        if (!id) {
          throw new Error('User ID is undefined');
        }
        const response = await axios.put(`/users/${id}`, userData);
        commit('UPDATE_USER', response.data);
        commit('SET_ERROR', null);
        return response.data;
      } catch (error) {
        commit('SET_ERROR', 'Failed to update user');
        console.error('Error updating user:', error);
        console.error('Error details:', error.response?.data);
        throw error;
      } finally {
        commit('SET_LOADING', false);
      }
    },
    async deleteUser({ commit }, id) {
      commit('SET_LOADING', true);
      try {
        await axios.delete(`/users/${id}`);
        commit('DELETE_USER', id);
        commit('SET_ERROR', null);
      } catch (error) {
        commit('SET_ERROR', 'Failed to delete user');
        throw error;
      } finally {
        commit('SET_LOADING', false);
      }
    }
  },
  getters: {
    getError: state => state.error,
    isLoading: state => state.loading
  }
});
