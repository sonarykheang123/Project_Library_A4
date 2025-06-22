<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-5xl mx-auto">
      <h1 class="text-4xl font-extrabold text-green-700 mb-8 text-center">👥 Member Management</h1>

      <!-- Search bar with icon -->
      <div class="relative max-w-md mx-auto mb-8">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
          🔍
        </span>
        <input
          v-model="query"
          type="search"
          placeholder="Search by ID or name..."
          class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm transition"
        />
      </div>

      <!-- Members grid -->
      <div v-if="filteredMembers.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="member in filteredMembers"
          :key="member.id"
          class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-5 flex items-center space-x-4"
        >
          <div
            class="flex-shrink-0 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl font-bold select-none"
          >
            {{ member.fullName.charAt(0).toUpperCase() }}
          </div>
          <div class="flex flex-col flex-grow">
            <h2 class="text-lg font-semibold text-gray-800">
              {{ member.fullName }}
            </h2>
            <p class="text-sm text-gray-500 mb-1">ID: {{ member.id }}</p>
            <p class="text-sm text-gray-600">
              <span class="font-medium">Email:</span> {{ member.email }}<br />
              <span class="font-medium">Phone:</span> {{ member.phone }}<br />
              <span class="font-medium">Address:</span> {{ member.address }}
            </p>
          </div>
        </div>
      </div>

      <!-- No results message -->
      <p v-else class="text-center text-gray-500 mt-20 text-xl select-none">
        🚫 No members found.
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const query = ref('')

const members = ref([
  { id: 1, fullName: 'Alice Sok', email: 'alice@example.com', phone: '012345678', address: 'Phnom Penh' },
  { id: 2, fullName: 'Bob Vannak', email: 'bob@example.com', phone: '098765432', address: 'Siem Reap' },
  { id: 3, fullName: 'Chan Dara', email: 'dara@example.com', phone: '011223344', address: 'Battambang' },
  { id: 4, fullName: 'Dara Sophy', email: 'sophy@example.com', phone: '012334455', address: 'Kampong Cham' },
  { id: 5, fullName: 'Pich Sophea', email: 'pich@example.com', phone: '017556677', address: 'Kandal' },
])

const filteredMembers = computed(() =>
  members.value.filter(member =>
    member.fullName.toLowerCase().includes(query.value.toLowerCase()) ||
    member.id.toString().includes(query.value)
  )
)
</script>
