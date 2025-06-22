<template>
  <router-link :to="item.path" class="flex flex-col items-center gap-2 sm:flex-row sm:items-start  bg-gray-100 p-2 rounded-lg shadow-md hover:bg-gray-200">
    <span class="material-symbols-outlined "> {{item.icon}} </span>
    <span>{{item.label}}</span>
  </router-link>
</template>

<script setup>
    defineProps(['item'])
</script>
