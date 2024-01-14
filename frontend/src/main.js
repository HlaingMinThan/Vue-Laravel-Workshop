import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import axios from 'axios';
import { createRouter, createWebHistory } from 'vue-router';
import Home from './pages/Home.vue'
import Detail from './pages/Detail.vue'
import RecipeForm from './pages/RecipeForm.vue'

axios.defaults.baseURL = "http://localhost:8000"

const routes = [
  {path: '/', component : Home, name: 'home'},
  {path: '/detail', component : Detail, name: 'detail'},
  {path: '/recipeform', component : RecipeForm, name:'form'},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
})


const app =createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app')
