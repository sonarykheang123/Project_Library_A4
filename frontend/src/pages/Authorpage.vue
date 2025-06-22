<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">📚 Author Directory</h1>

      <!-- Search bar -->
      <div class="flex justify-center mb-8">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="🔍 Search authors by name..."
          class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Author cards -->
      <div v-if="filteredAuthors.length" class="grid gap-6 md:grid-cols-2">
        <div
          v-for="author in filteredAuthors"
          :key="author.id"
          class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300"
        >
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3 text-xl">
              ✍️
            </div>
            <div>
              <h2 class="text-xl font-semibold text-gray-800">{{ author.name }}</h2>
              <p class="text-sm text-gray-500">{{ author.nationality }}</p>
            </div>
          </div>

          <ul class="text-sm text-gray-700 space-y-1 pl-1">
            <li><strong>DOB:</strong> {{ author.dateOfBirth }}</li>
            <li><strong>Total Books:</strong> {{ author.numberOfBooks }}</li>
          </ul>
        </div>
      </div>

      <!-- No results -->
      <div v-else class="text-center text-gray-500 text-lg mt-10">
        🚫 No authors found.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const authors = ref([
  { id: 1, name: 'John Doe', dateOfBirth: '1980-01-01', numberOfBooks: 5, nationality: 'American' },
  { id: 2, name: 'Jane Smith', dateOfBirth: '1975-06-20', numberOfBooks: 3, nationality: 'British' },
  { id: 3, name: 'Anna Kheang', dateOfBirth: '1990-03-15', numberOfBooks: 7, nationality: 'Cambodian' },
  { id: 4, name: 'Norah Lee', dateOfBirth: '1988-08-08', numberOfBooks: 2, nationality: 'Korean' },
])

const searchQuery = ref('')

const filteredAuthors = computed(() =>
  authors.value.filter(author =>
    author.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
)
</script>
