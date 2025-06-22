<template>
  <div class="pt-24 min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <!-- Title -->
      <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">
        📚 Author Directory
      </h1>

      <!-- Search bar -->
      <div class="flex justify-center mb-8">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="🔍 Search authors by name..."
          class="w-full max-w-md px-5 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all"
        />
      </div>

      <!-- Author cards -->
      <div v-if="filteredAuthors.length" class="grid gap-6 sm:grid-cols-2">
        <div
          v-for="author in filteredAuthors"
          :key="author.id"
          class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition duration-300"
        >
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-green-100 text-green-600 rounded-full p-3 text-xl">
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
import axios from "axios";
import { onMounted, ref, computed } from "vue";

const authors = ref([]);
const searchQuery = ref("");

// Fetch authors from API
onMounted(async () => {
  try {
    await axios
      .get("http://192.168.108.97:8000/api/authors")
      .then((res) => {
        authors.value = res.data;
      });
  } catch (e) {
    console.log("Axios fetching data error...");
  }
});

// Filtered authors based on search query
const filteredAuthors = computed(() =>
  authors.value.filter((author) =>
    author.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
);
</script>
