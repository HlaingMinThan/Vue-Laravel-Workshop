<template>
  <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
  </button>

  <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
        <li>
          <router-link :to="{name: 'home'}" class="flex items-center text-2xl font-bold p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">My Recipe</router-link>
        </li>
        <li>
          <a href="form.php" class="bg-gray-400 text-black flex items-center w-full p-2 text-base transition duration-75 rounded-lg group" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
            <img class="w-[25px]" src="https://cdn2.iconfinder.com/data/icons/picnic-outline/64/FOOD_RECIPE-recipe-ingredients-ingredient-education-recipes-orange-books-cooking-256.png" alt="">
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Recipe Form</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <div class="p-4 sm:ml-64 pt-[20px] h-[100vh]">
    <h1 class="text-3xl font-bold border-b pb-4">Recipe</h1>
    <form  @submit.prevent="createRecipe" class="max-w-[700px] mx-auto mt-[100px] shadow-md p-8 rounded-lg space-y-5">
      <div class="mb-5">
        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
        <input type="text" id="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Chicken Curry..." v-model="data.title">
        <!-- <span class="text-red-500 text-xs ml-2 tracking-wider">title is required!</span> -->
      </div>
      <div>
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="This is created..." v-model="data.description"></textarea>
        <!-- <span class="text-red-500 text-xs ml-2 tracking-wider">title is required!</span> -->
      </div>
      <div class="mb-5">
        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
        <select class="border block w-full p-2 rounded-xl border-gray-400 bg-[#F9FAFB] shadow" v-model="data.category_id">
          <option value="all" selected>All</option>
          <template v-for="category in categories" :key="category.id">
            <option :value="category.id">{{ category.name }}</option>
          </template>
      </select>
      </div>
      <input @change="getRecipeImage" type="file" class="block my-8" accept="image/png, image/jpeg" required>
      <div v-if="data.photo">
        <img class="h-[300px] w-full object-cover" :src="data.photo" alt="">
      </div>
      <button type="submit" class="block w-full hover:text-white hover:bg-red-400 transition-all duration-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center border border-red-400 text-red-400">Done</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      categories: [],
      data: {
        title: '',
        description: '',
        category_id:'all',
        photo: '',
      }
    }
  },
  methods: {
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
    getRecipeImage(e){
      let file = e.target.files[0];
      if(!file instanceof File) {
        return;
      }
      this.data.photo = file;
    },
    async createRecipe() {
      try {
        let { data: photo } = await this.$axios.post("/recipes/upload", {"photo" : this.data.photo}, {
          headers: {
            'content-type' : 'multipart/form-data'
          }
        })
        if(photo) {
          this.data.photo = photo.path;
          console.log(this.data.photo)
          if(this.$route.params?.id) {
            let res = await this.$axios.put("/recipes/" + this.$route.params?.id, this.data , {
              headers: {
                'content-type' : 'application/json'
              }
            })
          } else {
           let res = await this.$axios.post("/recipes", this.data , {
              headers: {
                'content-type' : 'application/json'
              }
          })
          }
        }
      }catch(e) {console.log(e)}
    },
    async getSingleRecipe(id) {
      try {
        let {data} = await this.$axios.get(`/recipes/${id}`);
        if(data) {
          this.data = data
        }
      } catch (e) {
        console.log(e)
      }
    }
  },

  mounted() {
    this.getCategories();
    if(this.$route.params?.id) {
      this.getSingleRecipe(this.$route.params?.id);
    }
  }
}
</script>