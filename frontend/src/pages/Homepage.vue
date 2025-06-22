<template>
  <div class="pt-16 min-h-screen flex flex-col justify-center items-center bg-gradient-to-tr from-green-400 to-blue-500 text-white p-6">
    <h1 class="text-5xl font-extrabold mb-6 drop-shadow-lg">Welcome to our Library</h1>
    <p class="text-lg max-w-xl text-center mb-10 drop-shadow-md">
      Manage your books, authors, and members easily with this sleek dashboard.
    </p>

    <div class="flex gap-6">
      <router-link
        to="/book"
        class="px-8 py-4 bg-white text-green-600 font-semibold rounded-lg shadow-lg hover:bg-green-100 transition"
      >
        📚 Books
      </router-link>

      <router-link
        to="/member"
        class="px-8 py-4 bg-white text-green-600 font-semibold rounded-lg shadow-lg hover:bg-green-100 transition"
      >
        👥 Members
      </router-link>
      <router-link
        to="/author"
        class="px-8 py-4 bg-white text-green-600 font-semibold rounded-lg shadow-lg hover:bg-green-100 transition"
      >
        👥 Authors
      </router-link>
    </div>
  </div>
</template>
