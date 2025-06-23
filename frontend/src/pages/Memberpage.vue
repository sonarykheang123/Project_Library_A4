<template>
  <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
          <h1 class="text-2xl font-bold text-center mb-10 p-5 bg-green-300 mt-12">Member Page</h1>
    <div class="max-w-4xl mx-auto">

      <!-- Search and Add New Member -->
      <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <div class="relative flex-1">
          <input
            v-model="searchQuery"
            type="search"
            placeholder="Search by ID or Name"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
          />
        </div>
        <button
          @click="showAddForm = true"
          class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 w-full sm:w-auto flex items-center justify-center gap-2"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            aria-hidden="true"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Add New Member
        </button>
      </div>

      <!-- Member Table -->
      <div v-if="filteredMembers.length" class="bg-white shadow-sm rounded-md overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-3 text-left text-sm font-medium text-gray-700">ID</th>
              <th class="p-3 text-left text-sm font-medium text-gray-700">Name</th>
              <th class="p-3 text-left text-sm font-medium text-gray-700">Email</th>
              <th class="p-3 text-left text-sm font-medium text-gray-700">Phone</th>
              <th class="p-3 text-left text-sm font-medium text-gray-700">Address</th>
              <th class="p-3 text-left text-sm font-medium text-gray-700">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="member in filteredMembers" :key="member.id" class="hover:bg-gray-50">
              <td class="p-3 text-sm text-gray-900">{{ member.id }}</td>
              <td class="p-3 text-sm text-gray-900">{{ member.name }}</td>
              <td class="p-3 text-sm text-gray-600">{{ member.email }}</td>
              <td class="p-3 text-sm text-gray-600">{{ member.phone }}</td>
              <td class="p-3 text-sm text-gray-600">{{ member.address }}</td>
              <td class="p-3">
                <div class="flex gap-2">
                  <button
                    @click="startEdit(member)"
                    class="border border-black text-black px-3 py-1 rounded-md hover:bg-gray-100 text-sm transition"
                  >
                    Edit
                  </button>
                  <button
                    @click="deleteMember(member.id)"
                    class="border border-red-600 text-red-600 px-3 py-1 rounded-md hover:bg-red-50 text-sm transition"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p v-else-if="filteredMembers.length === 0" class="text-center text-gray-500 text-sm mt-4">No members found.</p>

      <!-- Add/Edit Form Modal -->
      <div v-if="showAddForm || editingId !== null" class="fixed inset-0 bg-gray-100 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-md">
          <h2 class="text-lg font-medium text-gray-900 mb-4">{{ editingId !== null ? 'Edit Member' : 'Add New Member' }}</h2>
          <form @submit.prevent="editingId !== null ? updateMember(editingId) : addMember()" class="space-y-4">
            <div>
              <input
                v-model="formData.name"
                placeholder="Full Name"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <input
                v-model="formData.email"
                placeholder="Email"
                required
                type="email"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <input
                v-model="formData.phone"
                placeholder="Phone"
                required
                type="tel"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <input
                v-model="formData.address"
                placeholder="Address"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div class="flex justify-end gap-3 mt-4">
              <button
                type="button"
                @click="cancelForm"
                class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md hover:bg-gray-300"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700"
              >
                {{ editingId !== null ? 'Save' : 'Add' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, computed, onMounted } from 'vue'

const members = ref([])

let nextId = members.value.length + 1
const searchQuery = ref('')
const filteredMembers = computed(() => {
  const q = searchQuery.value.toLowerCase()
  return members.value.filter(m => m.name.toLowerCase().includes(q) || String(m.id).includes(q))
})

const showAddForm = ref(false)
const editingId = ref(null)
const formData = ref({ name: '', email: '', phone: '', address: '' })

const addMember = async () => {
  try {
    const res = await axios.post('http://127.0.0.1:8000/api/members/add', newMember.value)
    members.value.push(res.data.data)
    clearForm()
  }
  catch (err) {
    console.error('Failed to add member', err)
  }
}

const clearForm = () => {
  newMember.value = { name: '', email: '', phone: '', address: '' }
}

const startEdit = (member) => {
  editingId.value = member.id
  formData.value = { ...member }
  showAddForm.value = true
}

const updateMember = async(id) => {
  try {
    const res = await axios.put(`http://127.0.0.1:8000/api/members/update/${id}`, editMember.value)
    const index = members.value.findIndex((m) => m.id === id)
    if (index !== -1) {
      members.value[index] = res.data.data 
    }
    cancelEdit()
  } catch (err) {
    console.error('Failed to update member', err)
  }
}

const deleteMember = async(id) => {
  if (!confirm('Are you sure you want to delete this member?')) return

  try {
    await axios.delete(`http://127.0.0.1:8000/api/members/delete/${id}`)
    members.value = members.value.filter(m => m.id !== id)
  } catch (err) {
    console.error('Failed to delete member', err)
    alert('Failed to delete member. Please try again.')
  }
}

const cancelForm = () => {
  showAddForm.value = false
  editingId.value = null
  formData.value = { name: '', email: '', phone: '', address: '' }
}
</script>

<style scoped>
/* Minimal custom styling */
</style>
