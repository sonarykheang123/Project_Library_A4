<template>
  <div class="min-h-screen bg-gray-50">
    <h1 class="text-2xl font-bold text-center mb-6 p-5 bg-green-300 m-3">Author Page</h1>
    <div class="searchbar flex justify-end items-end">
    <input type="text" placeholder="Search authors..." class="w-80 p-2 border border-gray-300 rounded-md mb-4 m-1" />
  </div>
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <AuthorCard
          v-for="author in authors"
          :key="author.id"
          :author="author"
          @edit="handleEdit"
          @delete="handleDelete"
          @viewBooks="handleViewBooks"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import AuthorCard from '@/components/AuthorCard.vue'
import { ref } from 'vue'

const authors = ref([
  {
    id: '1',
    name: 'Jane Austen',
    avatar: null,
    bio: 'English novelist known primarily for her six major novels, which interpret, critique and comment upon the British landed gentry at the end of the 18th century.',
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
    bio: 'American author of horror, supernatural fiction, suspense, crime, science-fiction, and fantasy novels. Known as the "King of Horror".',
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
    bio: 'English writer known for her sixty-six detective novels and fourteen short story collections, particularly those revolving around fictional detectives Hercule Poirot and Miss Marple.',
    dateOfBirht: '1890-09-15',
    nationality: 'British',
    booksCount: 66,
    rating: 4.7,
    genres: ['Mystery', 'Detective Fiction', 'Crime'],
  }
])

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
