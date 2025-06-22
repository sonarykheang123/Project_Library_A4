<template>
  <div class="min-h-screen bg-gray-50 pt-20">
    <h1 class="text-2xl font-bold text-center mb-6 p-5 bg-green-300 mx-3">Author Page</h1>

    <!-- Search Bar -->
    <div class="flex justify-end px-4">
      <input
        type="text"
        v-model="searchTerm"
        placeholder="Search authors by name..."
        class="w-full max-w-md p-2 border border-gray-300 rounded-md mb-6"
      />
    </div>

    <!-- Author Cards -->
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <AuthorCard
          v-for="author in filteredAuthors"
          :key="author.id"
          :author="author"
          @edit="handleEdit"
          @delete="handleDelete"
          @viewBooks="handleViewBooks"
        />
      </div>

      <!-- Optional: No Results Message -->
      <p v-if="filteredAuthors.length === 0" class="text-center text-gray-500 mt-10">
        No authors found.
      </p>
    </div>
  </div>
</template>

<script setup>
import AuthorCard from '@/components/AuthorCard.vue'
import { ref, computed } from 'vue'

// Search term
const searchTerm = ref('')

// Author data
const authors = ref([
  {
    id: '1',
    name: 'Jane Austen',
    avatar: null,
    bio: 'English novelist known for her six major novels...',
    dateOfBirht: '1775-12-16',
    nationality: 'British',
    booksCount: 6,
    rating: 4.8,
    genres: ['Romance', 'Social Commentary', 'Classic Literature'],
  },
  {
    id: '2',
    name: 'Stephen King',
    avatar: null,
    bio: 'American author of horror, supernatural fiction...',
    dateOfBirht: '1947-09-21',
    nationality: 'American',
    booksCount: 64,
    rating: 4.6,
    genres: ['Horror', 'Supernatural', 'Thriller', 'Fantasy'],
  },
  {
    id: '3',
    name: 'Agatha Christie',
    avatar: null,
    bio: 'English writer known for her sixty-six detective novels...',
    dateOfBirht: '1890-09-15',
    nationality: 'British',
    booksCount: 66,
    rating: 4.7,
    genres: ['Mystery', 'Detective Fiction', 'Crime'],
  }
])

// Computed filtered authors
const filteredAuthors = computed(() => {
  return authors.value.filter(author =>
    author.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

// Action handlers
const handleEdit = (author) => {
  console.log('Edit author:', author)
}

const handleDelete = (authorId) => {
  console.log('Delete author:', authorId)
}

const handleViewBooks = (authorId) => {
  console.log('View books for author:', authorId)
}
</script>

<style lang="scss" scoped>
</style>
