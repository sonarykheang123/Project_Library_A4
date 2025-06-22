<template>
  <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-6 max-w-md">
    <!-- Header: avatar + name -->
    <div class="flex items-start mb-4">
      <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center overflow-hidden mr-4">
        <img
          v-if="author.avatar"
          :src="author.avatar"
          :alt="author.name"
          class="w-full h-full object-cover"
        />
        <span v-else class="text-green-600 text-lg font-semibold">
          {{ getInitials(author.name) }}
        </span>
      </div>

      <h3 class="text-xl font-bold text-gray-900">{{ author.name }}</h3>
    </div>

    <!-- Bio -->
    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ author.bio }}</p>

    <hr class="border-gray-200 mb-4" />

    <!-- Author details -->
    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-green-500 text-base">calendar_today</span>
        <span class="text-gray-600">Born:</span>
      </div>
      <span class="text-gray-900">{{ formatDate(author.dateOfBirht) }}</span>

      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-green-500 text-base">location_on</span>
        <span class="text-gray-600">From:</span>
      </div>
      <span class="text-gray-900">{{ author.nationality }}</span>

      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-green-500 text-base">menu_book</span>
        <span class="text-gray-600">Books:</span>
      </div>
      <span class="text-gray-900">{{ author.booksCount }}</span>
    </div>

    <hr class="border-gray-200 mb-4" />

    <!-- Action buttons -->
    <div class="flex gap-2 pt-4">
      <button
        @click="$emit('viewBooks', author.id)"
        class="flex-1 flex items-center justify-center gap-1 px-3 py-2 bg-orange-50 border border-orange-200 text-green-700 rounded-md hover:bg-orange-100 transition-colors text-sm"
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

const getInitials = (name) =>
  name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)

const formatDate = (dateString) =>
  new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
</script>
