<template>
  <div class="min-h-screen bg-gray-100 py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
      <h1 class="text-2xl font-bold mb-6 text-center text-blue-700">Member Management</h1>

      <!-- Add Member Form -->
      <form @submit.prevent="addMember" class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <input v-model="newMember.name" placeholder="Full Name" required class="p-2 border rounded" />
        <input v-model="newMember.email" placeholder="Email" required class="p-2 border rounded" />
        <input v-model="newMember.phone" placeholder="Phone" required class="p-2 border rounded" />
        <input v-model="newMember.address" placeholder="Address" required class="p-2 border rounded" />
        <button type="submit" class="col-span-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
          Add Member
        </button>
      </form>

      <!-- Search -->
      <input
        v-model="searchQuery"
        placeholder="Search by ID or Name"
        class="w-full mb-4 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
      />

      <!-- Member Table -->
      <table class="w-full border border-gray-300 rounded text-left">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2">ID</th>
            <th class="p-2">Name</th>
            <th class="p-2">Email</th>
            <th class="p-2">Phone</th>
            <th class="p-2">Address</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="member in filteredMembers" :key="member.id" class="border-t hover:bg-gray-100">
            <template v-if="editingId === member.id">
              <td>{{ member.id }}</td>
              <td><input v-model="editMember.name" class="p-1 border rounded w-full" /></td>
              <td><input v-model="editMember.email" class="p-1 border rounded w-full" /></td>
              <td><input v-model="editMember.phone" class="p-1 border rounded w-full" /></td>
              <td><input v-model="editMember.address" class="p-1 border rounded w-full" /></td>
              <td>
                <button @click="updateMember(member.id)" class="text-green-600">Save</button>
                <button @click="cancelEdit" class="text-gray-500 ml-2">Cancel</button>
              </td>
            </template>
            <template v-else>
              <td class="p-2">{{ member.id }}</td>
              <td class="p-2">{{ member.name }}</td>
              <td class="p-2">{{ member.email }}</td>
              <td class="p-2">{{ member.phone }}</td>
              <td class="p-2">{{ member.address }}</td>
              <td class="p-2">
                <button @click="startEdit(member)" class="text-blue-600">Edit</button>
                <button @click="deleteMember(member.id)" class="text-red-600 ml-2">Delete</button>
              </td>
            </template>
          </tr>
          <tr v-if="filteredMembers.length === 0">
            <td colspan="6" class="text-center text-gray-500 p-4">No results found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const members = ref([
  { id: 1, name: 'Sok Dara', email: 'dara@example.com', phone: '012345678', address: 'Phnom Penh' },
  { id: 2, name: 'Chanthy Kim', email: 'chanthy@example.com', phone: '098765432', address: 'Siem Reap' },
  { id: 3, name: 'Sreynich Chhoeurn', email: 'nich@example.com', phone: '011122233', address: 'Phnom Penh' },
])

const newMember = ref({ name: '', email: '', phone: '', address: '' })
let nextId = members.value.length + 1

const addMember = () => {
  members.value.push({ id: nextId++, ...newMember.value })
  newMember.value = { name: '', email: '', phone: '', address: '' }
}

const searchQuery = ref('')
const filteredMembers = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return members.value.filter(
    m =>
      m.name.toLowerCase().includes(query) ||
      String(m.id).includes(query)
  )
})

const editingId = ref(null)
const editMember = ref({})

const startEdit = (member) => {
  editingId.value = member.id
  editMember.value = { ...member }
}

const cancelEdit = () => {
  editingId.value = null
  editMember.value = {}
}

const updateMember = (id) => {
  const index = members.value.findIndex(m => m.id === id)
  if (index !== -1) {
    members.value[index] = { id, ...editMember.value }
    cancelEdit()
  }
}

const deleteMember = (id) => {
  members.value = members.value.filter(m => m.id !== id)
}
</script>

<style scoped>
/* optional custom styles */
</style>
