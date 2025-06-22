import { createRouter, createWebHistory } from 'vue-router';
import Homepage from '@/pages/Homepage.vue';
import Bookpage from '@/pages/Bookpage.vue';
import Authorpage from '@/pages/Authorpage.vue';
import Memberpage from '@/pages/Memberpage.vue';

const routes = [
    {
        path : "/",
        name : "Home",
        component: Homepage
    },
    {
        path : "/books",
        name : "Book",
        component: Bookpage
    },
    {
        path : "/author",
        name : "Author",
        component: Authorpage
    },
    {
        path : "/members",
        name : "Member",
        component: Memberpage
    }

]


const router = createRouter({
    'history': createWebHistory(),
    routes
})

export default router;