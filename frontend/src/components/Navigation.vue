<template>
  <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md h-16 flex items-center justify-between px-8">
    <!-- Logo or Home -->
    <div class="text-lg font-bold text-green-600 flex items-center gap-2">
      <span class="material-icons">local_library</span> Library 
    </div>

    <!-- Navigation Items -->
    <div class="flex gap-10 items-center mr-20">
      <RouterLink
        v-for="item in navItems"
        :key="item.label"
        :to="item.path"
        class="flex items-center gap-1 text-gray-700 hover:text-green-600 transition-colors duration-200 font-medium"
        :class="{'text-green-600 font-semibold': isActive(item.path)}"
      >
        <span class="material-icons">{{ item.icon }}</span>
        {{ item.label }}
      </RouterLink>
    </div>
  </nav>
</template>

<script setup>
import { useRoute } from 'vue-router';
import { ref } from 'vue';

const navItems = ref([
  { label: "Home", path: "/", icon: "home" },
  { label: "Book", path: "/book", icon: "menu_book" },
  { label: "Author", path: "/author", icon: "person" },
  { label: "Member", path: "/member", icon: "group" },
]);

const route = useRoute();
const isActive = (path) => route.path === path;
</script>

<style>
@import url('https://fonts.googleapis.com/icon?family=Material+Icons');
</style>

