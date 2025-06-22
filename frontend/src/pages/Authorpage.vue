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

      <!-- No Results -->
      <p v-if="filteredAuthors.length === 0" class="text-center text-gray-500 mt-10">
        No authors found.
      </p>
    </div>
  </div>
</template>

<script setup>
import AuthorCard from '@/components/AuthorCard.vue'
import axios from 'axios'
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const authors = ref([])
const searchTerm = ref('')

// Fetch authors
onMounted(async () => {
  try {
    await axios
      .get('http://127.0.0.1:8000/api/authors')
      .then((res) => {
        authors.value = res.data.data.map((author) => ({
          ...author,
          booksCount: author.number_of_books_written,
          dateOfBirht: author.date_of_birth,
          bio: '', // Placeholder
        }))
      })
  } catch (e) {
    console.error('Failed to fetch authors', e)
  }
})

const filteredAuthors = computed(() => {
  return authors.value.filter((author) =>
    author.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

const handleEdit = async (author) => {
  const newName = prompt('Edit name:', author.name)
  if (!newName) return

  try {
    await axios.put(`http://127.0.0.1:8000/api/authors/update/${author.id}`, {
      name: newName,
      date_of_birth: author.dateOfBirht,
      nationality: author.nationality,
      number_of_books_written: author.booksCount,
    })

    const index = authors.value.findIndex(a => a.id === author.id)
    if (index !== -1) authors.value[index].name = newName
  } catch (err) {
    console.error('Failed to update author', err)
  }
}

const handleDelete = async (authorId) => {
  if (!confirm('Are you sure you want to delete this author?')) return

  try {
    await axios.delete(`http://127.0.0.1:8000/api/authors/delete/${authorId}`)
    authors.value = authors.value.filter(a => a.id !== authorId)
  } catch (err) {
    console.error('Failed to delete author', err)
  }
}

const handleViewBooks = (authorId) => {
  router.push(`/authors/${authorId}/books`)
}
</script>
