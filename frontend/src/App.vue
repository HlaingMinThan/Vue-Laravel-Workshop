<template>
  <div>
    <h1>Categories</h1>
    <ul>
      <li v-for="category in categories" :key="category.id">
        {{category.name}}
      </li>
    </ul>
  </div>
</template>

<script>


export default {
  data(){
    return {
      categories : []
    }
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