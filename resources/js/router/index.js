import { createWebHistory, createRouter } from "vue-router";
import Home from './routes/Home.vue'
import Ganre from './routes/Ganre.vue'
import Profile from './routes/Profile.vue'
import ProfileCard from './routes/ProfileCard.vue'
import Books from './routes/Books.vue'
import Login from './routes/Login.vue'
import Search from './routes/Search.vue'
import Bookadout from './routes/Bookadout.vue'
import Favourites from './routes/Favourites.vue'
import Registration from './routes/Registration.vue'
import NotFound from './routes/NotFound.vue'
import Action from './routes/Action.vue'
import Start from '../components/Start.vue'
import User from './routes/User.vue'
import ProgressTop from './routes/ProgressTop.vue'
import ChatBook from './routes/ChatBook.vue'
import Admin from './routes/admin/Admin.vue'
import AddBooks from './routes/admin/AddBooks.vue'
import AddAction from './routes/admin/AddAction.vue'
import EditAdmin from './routes/admin/EditAdmin.vue'
import SearchEdit from './routes/admin/SearchBookAdmin.vue'
import BookAboutAdmin from './routes/admin/BookAboutAdmin.vue'
import { authCheck, authAdminCheck } from "../api-routes";
import Collections from './routes/Collections.vue'
import CheckEmail from './routes/Email.vue'
import Token from './routes/Token.vue'
import Read from './routes/Read.vue'


import Authgenreratetoken from './routes/Authgenreratetoken.vue'

const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
    },
    {
        path: '/authgenreratetoken/:id',
        name: 'Authgenreratetoken',
        component: Authgenreratetoken,
    },
    {
        path: "/",
        name: "Start",
        component: Start,
        children: [
            {
                path: "/",
                name: "Home",
                component: Home,
            },
            {
                path: "read/:id",
                name: "Read",
                component: Read,
            },
            {
                path: "Bookadout/:ganre/:id",
                name: "Bookadout",
                component: Bookadout,
            },
            {
                path: "favourites",
                name: "Favourites",
                component: Favourites,
            },
            {
                path: "checkemail",
                name: "CheckEmail",
                component: CheckEmail,

            },
            {
                path: "search",
                name: "Search",
                component: Search,
            },
            {
                path: "login",
                name: "Login",
                component: Login,
            },
            {
                path: "registration",
                name: "Registration",
                component: Registration,
            },
            {
                path: "booksganre/:ganre",
                name: "Ganre",
                component: Ganre,
            },
            {
                path: "profile",
                component: Profile,
                meta: {
                    name: 'profile'
                },
                children: [
                    {
                        path: "",
                        name: "Profile",
                        component: ProfileCard,
                        meta: {
                            name: 'profile'
                        },
                    },
                    {
                        path: "mycard",
                        name: "MyCard",
                        component: User,
                        meta: {
                            name: 'profile'
                        },
                    },
                    {
                        path: "top",
                        name: "ProgressTop",
                        component: ProgressTop,
                        meta: {
                            name: 'profile'
                        },
                    },
                    {
                        path: "collections",
                        name: "Collections",
                        component: Collections,
                        meta: {
                            name: 'profile'
                        },
                    },

                    {
                        path: "token",
                        name: "Token",
                        component: Token,
                        meta: {
                            name: 'profile'
                        },
                    },
                ]
            },
            {
                path: "action/:id",
                name: "Action",
                component: Action,
            },
            {
                path: "books",
                name: "Books",
                component: Books,
            },
            {
                path: "user/:id",
                name: "User",
                component: User,
            },
            {
                path: "chatbook/:id",
                name: "ChatBook",
                component: ChatBook,
            },
        ]
    },
    {
        path: "/admin",
        component: Admin,
        name: "Admin",
        meta: {
            name: 'admin'
        },
        children: [
            {
                path: 'addbooks',
                component: AddBooks,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'addaction',
                component: AddAction,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'editadmin',
                component: EditAdmin,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'search',
                component: SearchEdit,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'bookabout/:id',
                component: BookAboutAdmin,
                meta: {
                    name: 'admin'
                }
            },
        ]
    }

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach(async (to, from) => {
    if (to.meta.name == 'admin') {
        return await authAdminCheck().then(r => {
            if (r.status == 200) {
            } else {
                return '/'
            }
        })
    }
    if (to.meta.name == 'profile') {
        return await authCheck().then(r => {
            if (r.status == 200) {
            } else {
                return '/login'
            }
        })
    }
    if (to.fullPath == '/login' || to.fullPath == '/registration') {
        return await authCheck().then(r => {
            if (r.status == 200) {
                return '/profile'
            }
        })
    }
    window.scroll(0, 0);
})
export default router;

