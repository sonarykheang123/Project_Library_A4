<template>
        <h1 class="text-2xl font-bold text-center mb-6 p-5 m-3 mt-20">Book Page</h1>
        <div class="flex mb-6 wrap justify-end gap-4">
            <input type="text" placeholder="Search books..." class="rounded-md border border-gray-300 px-4 py-1.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-300" />
            <input v-model="authorFilter" type="text" placeholder="Filter by book name..." class="rounded-md border border-gray-300 px-4 py-1.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-300" />
        </div>
        
        <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors m-1 ml-9 "
        @click="showAddForm = true"
        >
                Add New Book
        </button>

        <!-- Add Book Form Modal -->
 <!-- ...existing code... -->
  <div v-if="showAddForm" class="fixed inset-0 bg-gray-100 bg-opacity-30 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">
        {{ isViewMode ? 'Book Details' : isEditMode ? 'Edit Book' : 'Add New Book' }}
      </h2>
      <form @submit.prevent="addBook" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-3">
          <label class="block mb-1 font-medium">Title</label>
          <input v-model="newBook.title" :readonly="isViewMode" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">IsBn</label>
          <input v-model="newBook.isbn" :readonly="isViewMode" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Publish Year</label>
          <input v-model="newBook.publication_year" :readonly="isViewMode" type="number" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Number Copies</label>
          <input v-model="newBook.number_of_copies" :readonly="isViewMode" type="number" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">Categories</label>
          <input v-model="newBook.categories" :readonly="isViewMode" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 font-medium">URL Image</label>
          <input v-model="newBook.url" :readonly="isViewMode" type="text" class="w-full border rounded px-3 py-1.5" required />
        </div>
        <div class="flex gap-3 justify-end md:col-span-2">
          <button type="button" @click="resetForm" class="px-6 py-1 rounded bg-gray-200 hover:bg-gray-300 mt-6 mb-3">Close</button>
          <button v-if="!isViewMode" type="submit" class="px-6 py-1 rounded bg-green-500 text-white hover:bg-green-600 mt-6 mb-3">
            {{ isEditMode ? 'Update' : 'Add' }}
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- ...existing code... -->
        
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
const showAddForm = ref(false)
const isEditMode = ref(false)
const isViewMode = ref(false)
const selectedBookId = ref(null)

const newBook = ref({
  title: "",
  isbn: "",
  publication_year: "",
  number_of_copies: "",
  categories: "",
  url: "",
})


const fetchBooks = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/books')
    books.value = res.data.data
  } catch (error) {
    console.error('Failed to fetch books:', error)
  }
}

onMounted(fetchBooks)

// Filter books by title
const filteredBooks = computed(() => {
  return books.value.filter(book =>
    book.title.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

const addBook = async () => {
  try{
      if (isEditMode.value && selectedBookId.value !== null) {
      await axios.put(`http://127.0.0.1:8000/api/books/update/${selectedBookId.value}`, newBook.value)
      await fetchBooks()

    } else {
      await axios.post('http://127.0.0.1:8000/api/books/add', newBook.value)
      await fetchBooks()
    }
    resetForm()

  } catch (err) {
    // console.log('Failed to add/edit book:', err);
    if (err.response?.status === 500 && err.response?.data?.message?.includes('Duplicate entry')) {
      alert("A book with this ISBN already exists. Please use a unique ISBN.");
    } else {
      console.log("Failed to add/edit book:", err);
      alert("An error occurred. Please try again.");
    }
  }

}

const handleEdit = async (book) => {
  try {
    const res = await axios.get(`http://127.0.0.1:8000/api/books/${book.id}`)
    Object.assign(newBook.value, res.data.data)
    selectedBookId.value = book.id
    isEditMode.value = true
    isViewMode.value = false
    showAddForm.value = true
  } catch (error) {
    console.error("Failed to load book for editing:", error)
  }
}

const handleViewDetails = async (book) => {
  console.log("handleViewDetails called with book:", book);
  if (!book?.id) {
    console.error("Missing book id:", book);
    return;
  }
  try {
    const res = await axios.get(`http://127.0.0.1:8000/api/books/${book.id}`);
    const data = res.data.data;
    
    alert(
      `Book Details:\n` +
      `Title: ${data.title}\n` +
      `ISBN: ${data.isbn}\n` +
      `Published Year: ${data.publication_year}\n` +
      `Number of Copies: ${data.number_of_copies}\n` +
      `Category: ${data.categories}`
    );
    
  } catch (error) {
    console.error("Failed to fetch book details:", error);
  }
};


const handleDelete = async (book) => {
  try {
    const confirmDelete = confirm(`Are you sure you want to delete "${book.title}"?`)
    if (confirmDelete) {
      await axios.delete(`http://127.0.0.1:8000/api/books/delete/${book.id}`)
      books.value = books.value.filter(b => b.id !== book.id)
    }
  } catch (err) {
    console.error('Failed to delete book:', err)
  }
}

function resetForm() {
  newBook.value = {
    title: "",
    isbn: "",
    publication_year: "",
    number_of_copies: "",
    categories: "",
    url: "",
  }
  showAddForm.value = false
  isEditMode.value = false
  isViewMode.value = false
  selectedBookId.value = null
}
</script>

<style scoped>
/* Add your styles here */
</style>