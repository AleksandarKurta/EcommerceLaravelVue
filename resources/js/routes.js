import Dashboard from './components/Dashboard.vue';
import Users from './components/Users.vue';
import Profile from './components/Profile.vue';
import Brand from './components/Brand.vue';
import Category from './components/Category.vue';
import Product from './components/Product.vue';
import Developer from './components/Developer.vue';
import NotFound from './components/NotFound.vue';
import Welcome from './components/Welcome.vue';

export const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/users', component: Users },
    { path: '/profile', component: Profile },
    { path: '/brands', component: Brand },
    { path: '/categories', component: Category },
    { path: '/products', component: Product },
    { path: '/developer', component: Developer },
    { path: '*', component: NotFound },
    { path: '',  name: 'welcome', component: Welcome },
]