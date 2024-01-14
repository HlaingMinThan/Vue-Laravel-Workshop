<template>
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
</template>

<script>
import RecipeForm from './pages/RecipeForm.vue'

export default {
  data(){
    return {
      categories : []
    }
  },
  components: {
    RecipeForm
  },
  methods : {
    async getCategories() {
        let res = await  this.$axios.get('/api/categories');
        this.categories = res.data;
        console.log();
    }
  },  
  mounted() {
    this.getCategories()
  }
}
</script>

<style>

</style>