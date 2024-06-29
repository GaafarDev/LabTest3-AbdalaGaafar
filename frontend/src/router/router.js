import { createRouter, createWebHistory } from 'vue-router';
import UserList from '@/components/UserList.vue';
import UserForm from '@/components/UserForm.vue';
import UserDetails from '@/components/UserDetails.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: UserList
  },
  {
    path: '/users',
    name: 'UserList',
    component: UserList
  },
  {
    path: '/user/new',
    name: 'CreateUser',
    component: UserForm
  },
  {
    path: '/user/:id',
    name: 'UserDetails',
    component: UserDetails
  },
  {
    path: '/user/:id/edit',
    name: 'EditUser',
    component: UserForm
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
