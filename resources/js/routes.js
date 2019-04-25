import Dashboard from './components/Dashboard.vue';
import Users from './components/Users.vue';
import Profile from './components/Profile.vue';
import Brand from './components/Brand.vue';

export const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/users', component: Users },
    { path: '/profile', component: Profile },
    { path: '/brands', component: Brand }
]