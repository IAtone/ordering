import Index from '../components/Index.vue'
import Details from '../components/details/Details.vue'
import Goods from '../components/details/content/goods/Goods.vue'
import Ratings from '../components/details/content/ratings/Ratings.vue'
import Seller from '../components/details/content/seller/Seller.vue'

export const routes = [
    {
        name: 'index',
        path: '/',
        component: Index
    },
    {
        name: 'details',
        path: '/details',
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
    }
]