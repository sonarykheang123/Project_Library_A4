<template>
  <nav class="h-16 flex w-10/12 m-auto  items-center justify-between">
    <div class="logo flex justify-center items-center gap-2">
      <img src="../assets/images/logo.jpg" alt="Library Logo" class="h-4/12 w-7/12 rounded-full">
      <h2 class="text-3xl font-bold bg-gradient-to-r from-red-500 via-yellow-500 to-blue-500 text-transparent bg-clip-text">Library</h2>
    </div>
    <div id="nav-item" class="flex items-center gap-12 ml-100">
      <navigation-item 
      v-for="item in navItems" 
      :key="item.label" 
      :item="item"
      :to="item.path"
      >
      </navigation-item>
    </div>
  </nav>
</template>

<script setup>
    import NavigationItem from "./NavigationItem.vue";
    import { ref } from 'vue';
    const navItems = ref([
        {label: "Home", path: "/", icon: "home"},
        {label: "Book", path: "/book", icon: "menu_book"},
        {label: "Author", path: "/author", icon: "person"},
        {label: "Member", path: "/member", icon: "group"},
    ])
</script>