import { createApp } from 'vue';
import App from './App.vue';
import ElementPlus from 'element-plus';
import 'element-plus/lib/theme-chalk/index.css';
import { createWebHistory, createRouter } from "vue-router";
import Countries from "./components/Countries.vue";
import Login from "./components/Login.vue";
import Home from "./components/Home.vue";
import SignUp from "./components/SignUp.vue";
import Favorites from "./components/Favorites.vue";
import Pagination from 'v-pagination-3';

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/countries",
    name: "Countries",
    component: Countries,
  },
  {
    path: "/favorites",
    name: "Favorites",
    component: Favorites,
  },
  {
    path: "/signup",
    name: "Sign Up",
    component: SignUp,
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp(App);
app.use(ElementPlus);
app.use(router);

app.component('pagination', Pagination);

app.mount('#app');
