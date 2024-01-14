import Home from '@/pages/Home.vue'
import Detail from '@/pages/Detail.vue'
import RecipeForm from '@/pages/RecipeForm.vue'

const routes = [
  {path: '/', component : Home, name: 'home'},
  {path: '/detail', component : Detail, name: 'detail'},
  {path: '/recipeform', component : RecipeForm, name:'form'},
];

export default routes;
