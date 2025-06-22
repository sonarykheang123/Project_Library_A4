<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-8">
      <!-- Header -->
      <h1 class="text-3xl font-semibold text-blue-800 text-center mb-8">Member Management</h1>

      <!-- Add Member Form -->
      <form @submit.prevent="addMember" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <input v-model="newMember.name" placeholder="Full Name" required class="p-3 border border-gray-300 rounded-lg" />
        <input v-model="newMember.email" placeholder="Email" required class="p-3 border border-gray-300 rounded-lg" />
        <input v-model="newMember.phone" placeholder="Phone" required class="p-3 border border-gray-300 rounded-lg" />
        <input v-model="newMember.address" placeholder="Address" required class="p-3 border border-gray-300 rounded-lg" />

        <!-- Buttons aligned to right -->
        <div class="md:col-span-2 flex justify-end gap-3">
          <button type="button"
                  @click="clearForm"
                  class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition text-sm">
            Cancel
          </button>
          <button type="submit"
                  class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
            Add
          </button>
        </div>
      </form>

      <!-- Search -->
      <div class="mb-6 flex gap-3 items-center">
        <input v-model="searchQuery"
               placeholder="Search by ID or Name"
               class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" />
        <button @click="searchAction"
                class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-md text-sm">
          🔍 Search
        </button>
      </div>

      <!-- Member Table -->
      <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-gray-700 table-fixed">
          <thead class="bg-blue-100 sticky top-0 z-10">
            <tr>
              <th class="w-1/12 p-4 text-left text-sm font-semibold text-blue-700">ID</th>
              <th class="w-3/12 p-4 text-left text-sm font-semibold text-blue-700">Name</th>
              <th class="w-3/12 p-4 text-left text-sm font-semibold text-blue-700">Email</th>
              <th class="w-2/12 p-4 text-left text-sm font-semibold text-blue-700">Phone</th>
              <th class="w-2/12 p-4 text-left text-sm font-semibold text-blue-700">Address</th>
              <th class="w-1/12 p-4 text-left text-sm font-semibold text-blue-700">Actions</th>
            </tr>
          </thead>
        </table>

        <div class="max-h-60 overflow-y-auto">
          <table class="min-w-full divide-y divide-gray-200 text-gray-700 table-fixed">
            <tbody class="divide-y divide-gray-200">
              <tr
                v-for="member in filteredMembers"
                :key="member.id"
                :class="[
                  editingId === member.id ? 'bg-yellow-50' : '',
                  'hover:bg-blue-50 transition',
                ]"
              >
                <template v-if="editingId === member.id">
                  <td class="w-1/12 p-4 whitespace-nowrap text-sm">{{ member.id }}</td>
                  <td class="w-3/12 p-4 whitespace-nowrap"><input v-model="editMember.name" class="w-full p-2 border rounded-lg" /></td>
                  <td class="w-3/12 p-4 whitespace-nowrap"><input v-model="editMember.email" class="w-full p-2 border rounded-lg" /></td>
                  <td class="w-2/12 p-4 whitespace-nowrap"><input v-model="editMember.phone" class="w-full p-2 border rounded-lg" /></td>
                  <td class="w-2/12 p-4 whitespace-nowrap"><input v-model="editMember.address" class="w-full p-2 border rounded-lg" /></td>
                  <td class="w-1/12 p-4 whitespace-nowrap flex gap-2">
                    <button @click="updateMember(member.id)"
                            class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 transition">
                      Save
                    </button>
                    <button @click="cancelEdit"
                            class="bg-gray-300 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-400 transition">
                      Cancel
                    </button>
                  </td>
                </template>
                <template v-else>
                  <td class="w-1/12 p-4 whitespace-nowrap text-sm">{{ member.id }}</td>
                  <td class="w-3/12 p-4 whitespace-nowrap text-sm">{{ member.name }}</td>
                  <td class="w-3/12 p-4 whitespace-nowrap text-sm">{{ member.email }}</td>
                  <td class="w-2/12 p-4 whitespace-nowrap text-sm">{{ member.phone }}</td>
                  <td class="w-2/12 p-4 whitespace-nowrap text-sm">{{ member.address }}</td>
                  <td class="w-1/12 p-4 whitespace-nowrap flex gap-2">
                    <button @click="startEdit(member)"
                            class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition">
                      Edit
                    </button>
                    <button @click="deleteMember(member.id)"
                            class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition">
                      Delete
                    </button>
                  </td>
                </template>
              </tr>
              <tr v-if="filteredMembers.length === 0">
                <td colspan="6" class="text-center text-gray-500 p-6 text-sm">No members found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, computed, onMounted } from 'vue'

const members = ref([])

const newMember = ref({ name: '', email: '', phone: '', address: '' })
const nextId = ref(members.value.length + 1)

onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/members')
    console.log('API Response:', res.data)
    if (Array.isArray(res.data.data)) {
      members.value = res.data.data
      nextId.value = Math.max(...members.value.map(m => m.id)) + 1
    } else {
      console.warn('Unexpected API response format:', res.data)
      members.value = []
      nextId.value = 1
    }
  } catch (e) {
    console.error('Failed to fetch members', e)
    members.value = []
    nextId.value = 1
  }
})

const searchQuery = ref('')
const filteredMembers = computed(() => {
  const q = searchQuery.value.toLowerCase()
  return members.value.filter(
    m => m.name.toLowerCase().includes(q) || String(m.id).includes(q)
  )
})

const editingId = ref(null)
const editMember = ref({})

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
  editMember.value = { ...member }
}

const cancelEdit = () => {
  editingId.value = null
  editMember.value = {}
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

const searchAction = () => {
  alert('Search triggered! (Optional)')
}
</script>

<style scoped>
/* Tailwind manages styling */
</style>
