import Index from '../components/Index.vue'
import Mine from '../components/Mine.vue'
import Main from '../components/Main.vue'
import Details from '../components/details/Details.vue'
import Goods from '../components/details/content/goods/Goods.vue'
import Ratings from '../components/details/content/ratings/Ratings.vue'
import Seller from '../components/details/content/seller/Seller.vue'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'
import Outer from '../components/Outer.vue'

export const routes = [
    {
        name: 'index',
        path: '/',
        component: Index,
        redirect: '/',
        children: [
            {
                name: 'main',
                path: '/',
                component: Main
            },
            {
                name: 'mine',
                path: '/mine',
                component: Mine
            }
        ]
    },
    {
        name: 'details',
        path: '/details/:id',
        component: Details,
        redirect: '/details/goods',
        children: [
            {
                name: 'foods',
                path: '/details/goods',
                component: Goods
            },
            {
                name: 'ratings',
                path: '/details/ratings',
                component: Ratings
            },
            {
                name: 'seller',
                path: '/details/seller',
                component: Seller
            }
        ]
    },
    {
        name: 'outer',
        component: Outer,
        path: '/outer'
    },
    {
        name: 'register',
        component: Register,
        path: '/register'
    },
    {
        name: 'login',
        component: Login,
        path: '/login'
    }
]