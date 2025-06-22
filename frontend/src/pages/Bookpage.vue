<template>
  <div class="min-h-screen bg-gray-50 pt-20">
    <h1 class="text-2xl font-bold text-center mb-6 p-5 m-3">Book Page</h1>

    <!-- Search Bar -->
    <div class="flex justify-center mb-6">
      <input
        type="text"
        v-model="searchTerm"
        placeholder="Search books..."
        class="w-full max-w-md p-2 border border-gray-300 rounded-md"
      />
    </div>

    <!-- Book Cards -->
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <BookCard
          v-for="book in filteredBooks"
          :key="book.id"
          :book="book"
          @edit="handleEdit"
          @delete="handleDelete"
          @viewDetails="handleViewDetails"
        />
      </div>

      <p v-if="filteredBooks.length === 0" class="text-center text-gray-500 mt-10">
        No books found.
      </p>
    </div>
  </div>
</template>

<script setup>
import BookCard from '@/components/BookCard.vue'
import axios from 'axios'
import { ref, computed, onMounted } from 'vue'

const books = ref([])
const searchTerm = ref('')

// Fetch books from API on mount
onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/books')
    // Adjust this according to your API response structure:
    // For example, if your API returns { data: [...] } use res.data.data
    books.value = res.data.data || res.data || []
  } catch (error) {
    console.error('Failed to fetch books:', error)
  }
})

// Filter books by title
const filteredBooks = computed(() => {
  return books.value.filter(book =>
    book.title.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

const handleEdit = (book) => {
  console.log('Editing book:', book)
}

const handleDelete = (book) => {
  console.log('Deleting book:', book)
}

const handleViewDetails = (book) => {
  console.log('Viewing details for book:', book)
}
</script>

<style scoped>
/* Add your styles here */
</style>
