<template>
  <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col">
    <img
      :src="book.url"
      :alt="book.title"
      class="w-full h-48 object-cover rounded-md mb-4"
    />
    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ book.title }}</h3>
    <p class="text-sm text-gray-600 mb-2">By {{ book.author }}</p>
    <p class="text-sm text-gray-500 mb-2">ISBN: {{ book.isbn }}</p>
    <p class="text-sm text-gray-500 mb-2">Published: {{ book.publication_year }}</p>
    <p class="text-sm text-gray-500 mb-2">Copies: {{ book.number_of_copies }}</p>
    <p class="text-sm text-gray-500 mb-2">Category: {{ book.categories }}</p>
    <div class="flex gap-2 mt-auto">
      <button
        @click="$emit('viewDetails', book)"
        class="flex-1 px-3 py-1 bg-blue-50 border border-blue-200 text-blue-700 rounded-md hover:bg-blue-100 transition-colors text-xs"
      >
        View Details
      </button>
      <button
        @click="$emit('edit', book)"
        class="px-3 py-1 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-xs"
      >
        Edit
      </button>
      <button
        @click="$emit('delete', book)"
        class="px-3 py-1 bg-white border border-red-200 text-red-600 rounded-md hover:bg-red-50 transition-colors text-xs"
      >
        Delete
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps(['book'])
defineEmits(['edit', 'delete', 'viewDetails'])
</script>

<style lang="scss" scoped>

</style>