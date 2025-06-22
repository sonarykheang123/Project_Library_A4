<template>
  <div class="pt-24 min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <h1 class="text-4xl font-extrabold text-green-700 mb-8 text-center">
        👥 Member Management
      </h1>

      <!-- Search -->
      <div class="relative max-w-md mx-auto mb-10">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg">🔍</span>
        <input
          v-model="query"
          type="search"
          placeholder="Search by ID or name..."
          class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm transition-all"
        />
      </div>

      <!-- Member Cards -->
      <div v-if="filteredMembers.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="member in filteredMembers"
          :key="member.id"
          class="bg-white p-5 rounded-2xl shadow-md hover:shadow-xl transition flex items-start gap-4"
        >
          <!-- Avatar Initial -->
          <div
            class="flex-shrink-0 w-14 h-14 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl font-bold"
          >
            {{ member.fullName.charAt(0).toUpperCase() }}
          </div>

          <!-- Info -->
          <div class="flex flex-col">
            <h2 class="text-lg font-semibold text-gray-800">
              {{ member.fullName }}
            </h2>
            <p class="text-sm text-gray-500">ID: {{ member.id }}</p>
            <div class="mt-1 text-sm text-gray-700 space-y-0.5">
              <p><strong>Email:</strong> {{ member.email }}</p>
              <p><strong>Phone:</strong> {{ member.phone }}</p>
              <p><strong>Address:</strong> {{ member.address }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- No Results -->
      <p v-else class="text-center text-gray-500 mt-20 text-xl">
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
