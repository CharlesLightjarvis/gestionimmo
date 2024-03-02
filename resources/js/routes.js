import Accueil from './components/accueil.vue';
import Categoriebiens from './components/categorieBiens/Categoriebiens.vue';
import EditCategory from './components/categorieBiens/EditCategory.vue';
import CreateCategory from './components/categorieBiens/CreateCategory.vue';
import ShowCategory from './components/categorieBiens/ShowCategory.vue';
import Biens from './components/biens/Biens.vue';
import CreateBien from './components/biens/CreateBien.vue';
import HomeCart from './components/cart/HomeCart.vue';
import Cart from './components/cart/Cart.vue';
import Payment from './components/cart/Payment.vue'
import Login from './components/authentification/Login.vue'
import Register from './components/authentification/Register.vue'
import Dashboard from './components/admin/Dashboard.vue'



export const routes = [
    {
        name: 'accueil',
        path: '/',
        component: Accueil
    },
    {
        name: 'categorieBiens',
        path: '/categoriebiens',
        component: Categoriebiens
    },
    {
        name: 'editCategory',
        path: '/EditCategory/:id',
        component: EditCategory
    },
    {
        name: 'createCategory',
        path: '/createCategory',
        component: CreateCategory
    },
    {
        name: 'showCategory',
        path: '/ShowCategory/:id',
        component: ShowCategory
    },
    {
        name: 'biens',
        path: '/biens',
        component: Biens
    },
    {
        name: 'createBien',
        path: '/createBien',
        component: CreateBien
    },
    {
        name: 'HomeCart',
        path: '/HomeCart',
        component: HomeCart
    },
    {
        name: 'Cart',
        path: '/Cart',
        component: Cart
    },
    {
        name: 'Payment',
        path: '/Payment',
        component: Payment
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
];
