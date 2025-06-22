<template>
        <h1 class="text-2xl font-bold text-center mb-6 p-5 m-3">Book Page</h1>
        <div class="flex mb-6 wrap justify-end">
            <input type="text" placeholder="Search books..." class="w-80 p-2 border border-gray-300 rounded-md mb-4 m-1" />
            <input v-model="authorFilter" type="text" placeholder="Filter by author..." class="w-80 p-2 border border-gray-300 rounded-md mb-4 m-1" />
        </div>
        
        <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors m-1 ml-9 ">
                Add New Book
        </button>
        
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
import BookCard from '@/components/BookCard.vue';
import { ref } from 'vue';

const books = ref([
    {
        id: 1,
        title: "The Great Gatsby",
        author: "F. Scott Fitzgerald",
        description: "A classic novel set in the Roaring Twenties.",
        cover: "https://covers.openlibrary.org/b/id/7222246-L.jpg"
    },
    {
        id: 2,
        title: "To Kill a Mockingbird",
        author: "Harper Lee",
        description: "A story of racial injustice and childhood innocence.",
        cover: "https://covers.openlibrary.org/b/id/8228691-L.jpg"
    },
    {
        id: 3,
        title: "1984",
        author: "George Orwell",
        description: "A dystopian novel about totalitarianism and surveillance.",
        cover: "https://covers.openlibrary.org/b/id/7222246-L.jpg"
    }
]);

// const search = ref('');
// const authorFilter = ref('');

// const filteredBooks = computed(() => {
//     return books.value.filter(book => {
//         const matchesTitle = book.title.toLowerCase().includes(search.value.toLowerCase());
//         const matchesAuthor = book.author.toLowerCase().includes(authorFilter.value.toLowerCase());
//         return matchesTitle && matchesAuthor;
//     })
// })

const handleEdit = (book) => {
    // Handle edit logic here
    console.log("Editing book:", book);
}

const handleDelete = (book) => {
    // Handle delete logic here
    console.log("Deleting book:", book);
}

const handleViewDetails = (book) => {
    // Handle view details logic here
    console.log("Viewing details for book:", book);
}

</script>

<style lang="scss" scoped>

</style>