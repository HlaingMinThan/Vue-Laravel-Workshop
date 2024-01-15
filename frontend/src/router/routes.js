import Home from '@/pages/Home.vue'
import Detail from '@/pages/Detail.vue'
import RecipeForm from '@/pages/RecipeForm.vue'

const routes = [
  {path: '/', component : Home, name: 'home'},
  {path: '/recipe/:id', component : Detail, name: 'detail'},
  {path: '/recipeform', component : RecipeForm, name:'form',
    children: [
      {
        path: '/edit/:id',
        component: RecipeForm,
        name: 'editForm'
      }
    ]
  },
];

export default routes;
