<template>
  <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-6 max-w-md">
    <!-- Header with Avatar and Basic Info -->
    <div class="flex items-start justify-between mb-4">
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center overflow-hidden">
          <img 
            v-if="author.avatar" 
            :src="author.avatar" 
            :alt="author.name"
            class="w-full h-full object-cover"
          />
          <span v-else class="text-orange-600 text-lg font-semibold">
            {{ getInitials(author.name) }}
          </span>
        </div>
        <div class="flex-1">
          <h3 class="text-xl font-bold text-gray-900">{{ author.name }}</h3>
          <div class="flex items-center gap-1 mt-1">
            <span 
              v-for="star in 5" 
              :key="star"
              class="material-symbols-outlined text-sm"
              :class="star <= Math.floor(author.rating) ? 'text-yellow-400' : 'text-gray-300'"
            >
              star
            </span>
            <span class="text-sm text-gray-600 ml-2">({{ author.rating.toFixed(1) }})</span>
          </div>
        </div>
      </div>
      
    </div>

    <!-- Bio -->
    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ author.bio }}</p>

    <!-- Divider -->
    <hr class="border-gray-200 mb-4">

    <!-- Author Details -->
    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-orange-500 text-base">calendar_today</span>
        <span class="text-gray-600">Born:</span>
      </div>
      <span class="text-gray-900">{{ formatDate(author.dateOfBirht) }}</span>

      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-orange-500 text-base">location_on</span>
        <span class="text-gray-600">From:</span>
      </div>
      <span class="text-gray-900">{{ author.nationality }}</span>

      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-orange-500 text-base">menu_book</span>
        <span class="text-gray-600">Books:</span>
      </div>
      <span class="text-gray-900">{{ author.booksCount }}</span>
    </div>

    <!-- Genres -->
    <div v-if="author.genres && author.genres.length > 0" class="mb-4">
      <h4 class="text-sm font-medium text-gray-700 mb-2">Genres</h4>
      <div class="flex flex-wrap gap-1">
        <span 
          v-for="genre in author.genres" 
          :key="genre"
          class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs border"
        >
          {{ genre }}
        </span>
      </div>
    </div>
    

    <!-- Divider -->
    <hr class="border-gray-200 mb-4">
    

    <!-- Action Buttons -->
    <div class="flex gap-2 pt-4">
      <button 
        @click="$emit('viewBooks', author.id)"
        class="flex-1 flex items-center justify-center gap-1 px-3 py-2 bg-orange-50 border border-orange-200 text-orange-700 rounded-md hover:bg-orange-100 transition-colors text-sm"
      >
        <span class="material-symbols-outlined text-base">menu_book</span>
        View Books
      </button>

      <button 
        @click="$emit('edit', author)"
        class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-sm"
      >
        Edit
      </button>

      <button 
        @click="$emit('delete', author.id)"
        class="px-3 py-2 bg-white border border-red-200 text-red-600 rounded-md hover:bg-red-50 transition-colors text-sm"
      >
        Delete
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

defineProps(['author'])
defineEmits(['edit', 'delete', 'viewBooks'])

const getInitials = (name) => {
  return name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>
