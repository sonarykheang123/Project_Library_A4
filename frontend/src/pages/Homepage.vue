<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-orange-400 to-orange-600 text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to Library Management</h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90">Manage your books, authors, and members efficiently</p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto relative">
          <div class="flex items-center bg-white rounded-lg shadow-lg overflow-hidden">
            <span class="material-symbols-outlined text-gray-400 pl-4">search</span>
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Search books, authors, or members..."
              class="flex-1 px-4 py-4 text-gray-700 focus:outline-none"
              @keyup.enter="handleSearch"
            >
            <button 
              @click="handleSearch"
              class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-4 transition-colors"
            >
              Search
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12">
      <div class="container mx-auto px-4 ">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 ml-70">
          <div 
            v-for="stat in stats" 
            :key="stat.label"
            class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow"
          >
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full"
                 :class="stat.bgColor">
              <span class="material-symbols-outlined text-2xl" :class="stat.textColor">
                {{ stat.icon }}
              </span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ stat.count }}</h3>
            <p class="text-gray-600">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <router-link 
            v-for="action in quickActions" 
            :key="action.title"
            :to="action.path"
            class="group bg-gray-50 rounded-lg p-8 text-center hover:bg-orange-50 hover:shadow-lg transition-all duration-200"
          >
            <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 rounded-full bg-orange-100 group-hover:bg-orange-200 transition-colors">
              <span class="material-symbols-outlined text-3xl text-orange-600">
                {{ action.icon }}
              </span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ action.title }}</h3>
            <p class="text-gray-600">{{ action.description }}</p>
          </router-link>
        </div>
      </div>
    </section>

    <!-- Recent Activity -->
    <section class="py-12">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Recent Activity</h2>
        <div class="max-w-4xl mx-auto">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div 
              v-for="activity in recentActivities" 
              :key="activity.id"
              class="flex items-center p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors"
            >
              <div class="flex items-center justify-center w-12 h-12 rounded-full mr-4"
                   :class="activity.bgColor">
                <span class="material-symbols-outlined text-lg" :class="activity.textColor">
                  {{ activity.icon }}
                </span>
              </div>
              <div class="flex-1">
                <p class="text-gray-900 font-medium">{{ activity.title }}</p>
                <p class="text-gray-600 text-sm">{{ activity.description }}</p>
              </div>
              <div class="text-gray-500 text-sm">
                {{ activity.time }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 bg-gray-100">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">System Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="feature in features" 
            :key="feature.title"
            class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow"
          >
            <div class="flex items-center mb-4">
              <span class="material-symbols-outlined text-2xl text-orange-500 mr-3">
                {{ feature.icon }}
              </span>
              <h3 class="text-xl font-semibold text-gray-900">{{ feature.title }}</h3>
            </div>
            <p class="text-gray-600">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const searchQuery = ref('')

const stats = ref([
  {
    label: 'Total Books',
    count: '1,234',
    icon: 'menu_book',
    bgColor: 'bg-blue-100',
    textColor: 'text-blue-600'
  },
  {
    label: 'Authors',
    count: '456',
    icon: 'person',
    bgColor: 'bg-green-100',
    textColor: 'text-green-600'
  },
  {
    label: 'Members',
    count: '789',
    icon: 'group',
    bgColor: 'bg-purple-100',
    textColor: 'text-purple-600'
  },
])

const quickActions = ref([
  {
    title: 'Manage Books',
    description: 'Add, edit, or remove books from your library collection',
    icon: 'menu_book',
    path: '/book'
  },
  {
    title: 'Manage Authors',
    description: 'View and manage author information and profiles',
    icon: 'person',
    path: '/author'
  },
  {
    title: 'Manage Members',
    description: 'Handle member registrations and account management',
    icon: 'group',
    path: '/member'
  }
])

const recentActivities = ref([
  {
    id: 1,
    title: 'New book added',
    description: '"The Great Gatsby" by F. Scott Fitzgerald',
    time: '2 hours ago',
    icon: 'add_circle',
    bgColor: 'bg-green-100',
    textColor: 'text-green-600'
  },
  {
    id: 2,
    title: 'Member registered',
    description: 'John Doe joined the library',
    time: '4 hours ago',
    icon: 'person_add',
    bgColor: 'bg-blue-100',
    textColor: 'text-blue-600'
  },
  {
    id: 3,
    title: 'Book returned',
    description: '"To Kill a Mockingbird" returned by Jane Smith',
    time: '6 hours ago',
    icon: 'assignment_return',
    bgColor: 'bg-orange-100',
    textColor: 'text-orange-600'
  },
  {
    id: 4,
    title: 'Author updated',
    description: 'Stephen King profile information updated',
    time: '1 day ago',
    icon: 'edit',
    bgColor: 'bg-purple-100',
    textColor: 'text-purple-600'
  }
])

const features = ref([
  {
    title: 'Book Management',
    description: 'Comprehensive book catalog with search, filter, and categorization features',
    icon: 'library_books'
  },
  {
    title: 'Author Profiles',
    description: 'Detailed author information with biography, nationality, and book count',
    icon: 'account_circle'
  },
  {
    title: 'Member System',
    description: 'Complete member management with registration and account tracking',
    icon: 'badge'
  },
  {
    title: 'Search & Filter',
    description: 'Advanced search capabilities across books, authors, and members',
    icon: 'search'
  },
  {
    title: 'Reports',
    description: 'Generate detailed reports on library usage and statistics',
    icon: 'assessment'
  },
  {
    title: 'Easy Navigation',
    description: 'Intuitive interface design for efficient library management',
    icon: 'navigation'
  }
])

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    console.log('Searching for:', searchQuery.value)
    // Implement search functionality
  }
}
</script>

<style lang="scss" scoped>
</style>
