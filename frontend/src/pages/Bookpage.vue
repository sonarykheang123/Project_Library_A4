<template>
        <h1 class="text-2xl font-bold text-center mb-6 p-5 m-3 mt-20">Book Page</h1>
        <div class="flex mb-6 wrap justify-end gap-4">
            <input type="text" placeholder="Search books..." class="rounded-md border border-gray-300 px-4 py-1.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-300" />
            <input v-model="authorFilter" type="text" placeholder="Filter by author..." class="rounded-md border border-gray-300 px-4 py-1.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-300" />
        </div>
        
        <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors m-1 ml-9 "
        @click="showAddForm = true"
        >
                Add New Book
        </button>

        <!-- Add Book Form Modal -->
  <div v-if="showAddForm" class="fixed inset-0 bg-gray-100 bg-opacity-30 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Add New Book</h2>
      <form @submit.prevent="addBook" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-3">
          <label class="block mb-1 font-medium">Title</label>
          <input v-model="newBook.title" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Author</label>
          <input v-model="newBook.author" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">IsBn</label>
          <input v-model="newBook.isbn" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Publish Year</label>
          <input v-model="newBook.publicyear" type="number" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Number Copies</label>
          <input v-model="newBook.numbercopy" type="number" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Categories</label>
          <input v-model="newBook.category" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">URL Image</label>
          <input v-model="newBook.urlimg" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="flex gap-3 justify-end">
          <button type="button" @click="showAddForm = false" class="px-6 py-1 rounded bg-gray-200 hover:bg-gray-300 mt-6 mb-3">Cancel</button>
          <button type="submit" class="px-6 py-1 rounded bg-green-500 text-white hover:bg-green-600 mt-6 mb-3">Add</button>
        </div>
      </form>
    </div>
  </div>
        
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <BookCard
                    v-for="book in books"
                    :key="book.id"
                    :book="book"
                    @edit="handleEdit"
                    @delete="handleDelete"
                    @viewDetails="handleViewDetails"
                />
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

const showAddForm = ref(false);
const newBook = ref({
  title: "",
  author: "",
  isbn: "",
  publicyear: "",
numbercopy: "",
category: "",
    urlimg: "",
});

function addBook() {
  books.value.push({
    id: Date.now(),
    title: newBook.value.title,
    author: "Unknown", // You can add an author field to the form if needed
    description: `EBN: ${newBook.value.ebn}, Year: ${newBook.value.publicyear}`,
    cover: "https://via.placeholder.com/150x200?text=No+Cover"
  });
  newBook.value = { title: "", ebn: "", publicyear: "" };
  showAddForm.value = false;
}
const authorFilter = ref("");
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
