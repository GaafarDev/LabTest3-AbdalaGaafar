import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router.js';
import store from './store/index.js';
import 'bootstrap/dist/css/bootstrap.css';

createApp(App).use(store).use(router).mount('#app');
