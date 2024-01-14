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
        <div class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3 active">All recipes</div>
        <div class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3">Japanese</div>
        <div class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3">Vegetarian</div>
        <div class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3">Meat</div>
        <div class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3">Fast & Easy</div>
      </nav>
    </div>

    <div class="justify-center mt-11 block md:hidden">
      <select class="appearance-none bg-red-400 text-white outline-none border-none p-3 w-[300px] text-center" name="" id="">
        <option value="all">All Recipes</option>
        <option value="japanese">Japanese</option>
        <option value="vegetarian">Vegetarian</option>
        <option value="meat">Meat</option>
        <option value="fastandeasy">Fast & Easy</option>
      </select>
    </div>

    <!-- recipe -->
    <div class="my-20 grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-12">
      <router-link :to="{name: 'detail'}">
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg active:shadow-none transition-all duration-500">
          <img class="h-[300px] mb-4 rounded-t-lg w-full object-cover" src="https://cdn.shopify.com/s/files/1/0291/8606/4520/files/ygn-200513-7.jpg?v=1589460584" alt="product image" />
          <div class="px-5 pb-5">
            <h5 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
              Tomato Salad
            </h5>
            <p class="line-clamp-2 mt-2 text-gray-500">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione mollitia modi fugit ex sint? Veritatis dicta iste quasi sapiente, totam est a alias. Fugiat nulla illo dolorem ullam sequi laudantium.
            </p>
          </div>
        </div>
      </router-link>
    </div>
  </main>
</template>