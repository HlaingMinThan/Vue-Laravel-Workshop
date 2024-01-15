<template>
  <header>
    <nav class="flex justify-between items-center h-[80px] border-b xl:px-[80px] md:px-[50px] px-[20px]">
      <div>
        <router-link :to="{name: 'home'}" class="text-3xl text-green-400 font-semibold">My Recipe</router-link>
      </div>
      <div>
        <router-link :to="{name: 'form'}" class="px-3 py-3 rounded-lg bg-red-400 hover:opacity-[0.85] transition-all duration-500 text-white flex items-center gap-2">
          <i class="fa-solid fa-plus"></i>
          <div>Add Recipe</div>
        </router-link>  
      </div>
    </nav>
  </header>

  <main class="xl:px-[80px] md:px-[50px] px-[20px]">
    <h1 class="text-center mt-11 text-5xl font-bold text-gray-800 leading-tight">
      All your favorite <span class="font-bold text-red-400">recipes,</span><br>
      <span class="font-bold text-red-400">in one place</span>
    </h1>

    <div class='justify-center md:flex hidden'>
      <nav class="bg-red-400 text-white grid grid-flow-col text-center mt-14">
        <div @click="filterRecipeByCategory('all')" class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3 active">All recipes</div>
        <template v-for="category in categories" :key="category.id">
          <div @click="filterRecipeByCategory(category.name)" class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3 active">{{ category.name }}</div>
        </template>
      </nav>
    </div>

    <div class="justify-center mt-11 block md:hidden">
      <select class="appearance-none bg-red-400 text-white outline-none border-none p-3 w-[300px] text-center" name="" id="">
        <option value="all">All</option>
        <template v-for="category in categories" :key="category.id">
          <option :value="category.name">{{ category.name }}</option>
        </template>
      </select>
    </div>

    <!-- recipe -->
    <div class="my-20 grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-12">
      <template v-if="!gettingRecipes" v-for="recipe in recipes" :key="recipe.id">
        <router-link :to="{name: 'detail', params: {id: recipe.id}}">
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg active:shadow-none transition-all duration-500 max-h-[500px]">
          <img class="h-[300px] mb-4 rounded-t-lg w-full object-cover" :src="recipe.photo" alt="product image" />
          <div class="px-5 pb-5">
            <h5 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white line-clamp-1">
              {{ recipe?.title }}
            </h5>
            <p class="line-clamp-2 mt-2 text-gray-500">
              {{  recipe?.description  }}
            </p>
          </div>
        </div>
      </router-link>
      </template>
      <div v-else v-for="(_, indx) in new Array(6)" :key="indx">
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg active:shadow-none transition-all duration-500 max-h-[500px] animate-pulse">
          <div class="h-[300px] mb-4 rounded-t-lg w-full object-cover bg-slate-300" />
          <div class="px-5 pb-5">
            <div class="h-[13px] rounded-xl bg-slate-300" />
            <div class="h-[8px] rounded-xl mt-5 bg-slate-300"></div>
            <div class="h-[8px] rounded-xl w-[80%] mt-2 bg-slate-300"></div>
          </div>
        </div>
      </div>

      <div class="flex gap-[30px]">
        <template  v-for="link in links" :key="link.label">
          <button @click="getPaginatedRecipe(prev_page_url)" v-if="link.label.includes('Previous')">{{'<'}} Previous</button>
          <button @click="getPaginatedRecipe(next_page_url)" v-else-if="link.label.includes('Next')">Next {{'>'}}</button>
          <button v-else v-html="link.label" :class="link.label == current_page ? 'bg-red-400 text-white' : 'text-black'" style="padding: 10px 20px;" @click="getPaginatedRecipe(link?.url)"/>
        </template>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return{
      recipes: [],
      categories: [],
      gettingRecipes: true,
      links: [],
      active: 'bg-red-400',
      current_page: 1,
      prev_page_url: '',
      next_page_url: '',
    }
  },
  methods: {
    async getRecipes() {
      try {
        let res = await this.$axios.get('/recipes')
        if(res) {
          this.recipes = res.data.data;
          this.gettingRecipes = false;
          this.links = res.data.links;
          this.prev_page_url = res.data.prev_page_url;
          this.next_page_url = res.data.next_page_url;
        }
      }catch (e) {
        console.log(e)
      }
    },
    async getCategories() {
      try {
        let res = await this.$axios.get('/categories')
        if(res) {
          this.categories = res.data;
        }
      }catch (e) {
        console.log(e)
      }
    },
    async filterRecipeByCategory(category) {
      try {
        let { data: recipes } = await this.$axios.get('/recipes?category=' + category)
        if(recipes){
          this.recipes = recipes.data;
        }
      }catch(e) {
        console.log(e)
      }
    },
    async getPaginatedRecipe(url){
      try {
        let pageNumber = url.split('page=')[1];
        let { data: recipes } = await this.$axios.get('/recipes?page=' + pageNumber);
        this.recipes = recipes.data;      
        this.current_page = pageNumber;
      } catch(e) {
        console.log(e)
      }
    }
  },
  mounted() {
    this.getRecipes();
    this.getCategories();
  }
}
</script>