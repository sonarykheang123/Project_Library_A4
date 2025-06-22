<template>
  <div class="min-h-screen bg-gray-50 p-6 max-w-5xl mx-auto">
    <!-- Title -->
    <h1 class="text-3xl font-bold text-green-700 mb-6 text-center flex items-center justify-center gap-2">
      <span class="material-icons">menu_book</span> Book Manager
    </h1>

    <!-- Search + Filter -->
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
      <input
        v-model="search"
        type="search"
        placeholder="Search by title or ISBN"
        class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
      />
      <select
        v-model="selectedCategory"
        class="w-full sm:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
      >
        <option value="">All Categories</option>
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
    </div>

    <!-- Add/Edit Button -->
    <div class="text-center mb-4">
      <button
        @click="toggleForm"
        class="px-5 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition flex items-center justify-center gap-2"
      >
        <span class="material-icons">{{ showForm ? 'cancel' : (isEditing ? 'edit' : 'add') }}</span>
        {{ showForm ? (isEditing ? 'Cancel Edit' : 'Cancel Add') : (isEditing ? 'Edit Book' : 'Add Book') }}
      </button>
    </div>

    <!-- Book Form -->
    <div v-if="showForm" class="mb-6 bg-white p-4 rounded-lg shadow">
      <form @submit.prevent="isEditing ? updateBook() : addBook()" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <input
          v-model="newBook.title"
          placeholder="Title"
          class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          required
        />
        <input
          v-model="newBook.isbn"
          placeholder="ISBN"
          class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          required
        />
        <input
          v-model.number="newBook.publishYear"
          type="number"
          placeholder="Publish Year"
          class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
        />
        <input
          v-model.number="newBook.copies"
          type="number"
          placeholder="Copies"
          class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
        />
        <input
          v-model="newBook.category"
          placeholder="Category"
          class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
        />
        <input
          v-model="newBook.image"
          placeholder="Image URL"
          class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
        />
        <button
          type="submit"
          class="sm:col-span-2 bg-green-600 text-white rounded px-4 py-2 hover:bg-green-700 transition"
        >
          {{ isEditing ? 'Update Book' : 'Add Book' }}
        </button>
      </form>
    </div>

    <!-- Book List -->
    <ul>
      <li
        v-for="book in filteredBooks"
        :key="book.id"
        class="flex items-center bg-white rounded-lg shadow p-3 mb-3 hover:shadow-md transition"
      >
        <img
          :src="book.image || 'https://via.placeholder.com/60x80?text=No+Img'"
          alt="Book cover"
          class="w-16 h-20 object-cover rounded mr-4 flex-shrink-0"
        />
        <div class="flex-grow min-w-0">
          <h2 class="font-semibold text-gray-800 truncate">{{ book.title }}</h2>
          <p class="text-sm text-gray-600 truncate">
            ISBN: {{ book.isbn }} | Year: {{ book.publishYear }} | Category: {{ book.category }} | Copies: {{ book.copies }}
          </p>
        </div>
        <div class="ml-4 flex gap-2">
          <button @click="viewDetails(book)" class="text-gray-600 hover:text-gray-800">
            <span class="material-icons">visibility</span>
          </button>
          <button @click="editBook(book)" class="text-blue-600 hover:text-blue-800">
            <span class="material-icons">edit</span>
          </button>
          <button @click="deleteBook(book.id)" class="text-red-600 hover:text-red-800">
            <span class="material-icons">delete</span>
          </button>
        </div>
      </li>
    </ul>

    <p v-if="filteredBooks.length === 0" class="text-center text-gray-500 mt-10 select-none">
      😕 No books found.
    </p>

    <!-- Details Modal -->
    <div v-if="showDetailsModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
        <button @click="closeDetails" class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
          <span class="material-icons">close</span>
        </button>
        <div class="text-center">
          <img
            :src="selectedBook.image || 'https://via.placeholder.com/100x140?text=No+Image'"
            class="w-24 h-32 object-cover rounded mx-auto mb-4"
          />
          <h2 class="text-xl font-bold mb-2">{{ selectedBook.title }}</h2>
          <p class="text-gray-600">ISBN: {{ selectedBook.isbn }}</p>
          <p class="text-gray-600">Year: {{ selectedBook.publishYear }}</p>
          <p class="text-gray-600">Category: {{ selectedBook.category }}</p>
          <p class="text-gray-600">Copies: {{ selectedBook.copies }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const search = ref('')
const selectedCategory = ref('')
const showForm = ref(false)
const isEditing = ref(false)
const editingId = ref(null)
const showDetailsModal = ref(false)
const selectedBook = ref({})

const books = ref([
  {
    id: 1,
    isbn: '12345',
    title: 'JavaScript Basics',
    publishYear: 2020,
    copies: 10,
    category: 'Programming',
    image: '',
  },
  {
    id: 2,
    isbn: '67890',
    title: 'HTML & CSS',
    publishYear: 2019,
    copies: 5,
    category: 'Web',
    image: '',
  },
  {
    id: 3,
    isbn: '23456',
    title: 'Vue 3 Guide',
    publishYear: 2022,
    copies: 8,
    category: 'Framework',
    image: '',
  },
])

const newBook = ref({
  isbn: '',
  title: '',
  publishYear: '',
  copies: '',
  category: '',
  image: '',
})

function toggleForm() {
  showForm.value = !showForm.value
  if (!showForm.value) resetForm()
}

function addBook() {
  const newId = books.value.length ? Math.max(...books.value.map(b => b.id)) + 1 : 1
  books.value.push({ id: newId, ...newBook.value })
  resetForm()
  showForm.value = false
}

function deleteBook(id) {
  if (confirm('Are you sure you want to delete this book?')) {
    books.value = books.value.filter(b => b.id !== id)
  }
}

function editBook(book) {
  showForm.value = true
  isEditing.value = true
  editingId.value = book.id
  newBook.value = { ...book }
}

function updateBook() {
  const index = books.value.findIndex(b => b.id === editingId.value)
  if (index !== -1) {
    books.value[index] = { id: editingId.value, ...newBook.value }
  }
  resetForm()
  showForm.value = false
}

function resetForm() {
  newBook.value = {
    isbn: '',
    title: '',
    publishYear: '',
    copies: '',
    category: '',
    image: '',
  }
  isEditing.value = false
  editingId.value = null
}

function viewDetails(book) {
  selectedBook.value = book
  showDetailsModal.value = true
}

function closeDetails() {
  selectedBook.value = {}
  showDetailsModal.value = false
}

const categories = computed(() =>
  [...new Set(books.value.map(book => book.category))].filter(Boolean)
)

const filteredBooks = computed(() =>
  books.value.filter(book =>
    (book.title.toLowerCase().includes(search.value.toLowerCase()) ||
      book.isbn.includes(search.value)) &&
    (selectedCategory.value === '' || book.category === selectedCategory.value)
  )
)
</script>
