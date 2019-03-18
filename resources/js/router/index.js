import "babel-polyfill";
import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";

Vue.use(VueRouter);

import Signin from "../pages/auths/Signin";
import Signup from "../pages/auths/Signup";
import EmailVerification from "../pages/auths/EmailVerification";
import NotFound from "../pages/NotFound";
import EntryList from "../pages/EntryList";
import EntryAdd from "../pages/EntryAdd";
import EntryEdit from "../pages/EntryEdit";
import Entry from "../pages/Entry";

const routes = [
    {
        path: "/",
        name: "home",
        redirect: "/entries",
        meta: { requiresAuth: false }
    },
    {
        path: "/entries",
        name: "entry-list",
        meta: { requiresAuth: false },
        component: EntryList
    },
    {
        path: "/entries/:page",
        name: "entry-list-page",
        component: EntryList,
        meta: { requiresAuth: false }
    },
    {
        path: "/entry/add",
        name: "entry-add",
        meta: { requiresAuth: true },
        component: EntryAdd
    },
    {
        path: "/entry/edit/:id",
        name: "entry-edit",
        meta: { requiresAuth: true },
        component: EntryEdit
    },
    {
        path: "/entry/:id",
        name: "entry",
        component: Entry,
        meta: { requiresAuth: false }
    },
    {
        path: "/signout",
        name: "signout",
        meta: { signoutAuth: true }
    },
    {
        path: "/signin",
        name: "signin",
        meta: { requiresAuth: false },
        component: Signin
    },
    {
        path: "/signup",
        name: "signup",
        meta: { requiresAuth: false },
        component: Signup
    },
    {
        path: "/email/verification",
        name: "email-verification",
        meta: { requiresAuth: true },
        component: EmailVerification
    },
    {
        path: "*",
        name: "notFound",
        meta: { requiresAuth: false },
        component: NotFound
    }
];

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: "history"
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters["layout/refresh"]) {
            let token = localStorage.getItem("token");
            if (token) {
                store.commit("layout/setLoadingApp", true);
                store
                    .dispatch("auth/getAuthUser")
                    .then(res => {
                        store.commit("layout/setLoadingApp", false);
                        next();
                    })
                    .catch(err => {
                        store.commit("layout/setLoadingApp", false);
                        next({
                            path: "/signin"
                        });
                    });
            }
        } else {
            if (!store.getters["auth/isLogged"]) {
                next({
                    path: "/signin"
                });
            } else {
                next();
            }
        }
    } else if (to.matched.some(record => record.meta.signoutAuth)) {
        store
            .dispatch("auth/signout")
            .then(res => {
                next(false);
            })
            .catch(err => {
                next();
            });
    } else {
        if (!store.getters["layout/refresh"]) {
            let token = localStorage.getItem("token");
            if (token) {
                store.commit("layout/setLoadingApp", true);
                store
                    .dispatch("auth/getAuthUser")
                    .then(res => {
                        store.commit("layout/setLoadingApp", false);
                        next();
                    })
                    .catch(err => {
                        store.commit("layout/setLoadingApp", false);
                        next({
                            path: "/signin"
                        });
                    });
            } else {
                next();
            }
        } else {
            next();
        }
    }
});

export default router;
