import Vue from "vue";
import VueRouter from "vue-router";
import Login from "@/views/Login.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
  },
  {
    path: "/admin",
    name: "Admin",
    component: function () {
      return import(/* webpackChunkName: "admin" */ "../views/Admin.vue");
    },
  },
  {
    path: "/register",
    name: "Register",
    component: function () {
      return import(/* webpackChunkName: "register" */ "../views/Register.vue");
    },
  },
  {
    path: "/test",
    name: "Test",
    component: function () {
      return import(/* webpackChunkName: "test" */ "../views/Test.vue");
    },
  },
  {
    path: "/user",
    name: "User",
    component: function () {
      return import(/* webpackChunkName: "user" */ "../views/User.vue");
    },
  },
  {
    path: "/users",
    name: "Users",
    component: function () {
      return import(/* webpackChunkName: "users" */ "../views/Users.vue");
    },
  },
];

const router = new VueRouter({
  routes,
});

export default router;
