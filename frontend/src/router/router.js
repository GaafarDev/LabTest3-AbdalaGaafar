import { createRouter, createWebHistory } from 'vue-router';
import UserManagement from '@/components/UserManagement.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: UserManagement
  },
  {
    path: '/users',
    name: 'UserManagement',
    component: UserManagement
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;