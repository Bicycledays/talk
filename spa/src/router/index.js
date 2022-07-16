import { createRouter, createWebHistory } from "vue-router";
import Users from "../components/Users";
import Profile from "../components/Profile";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/users",
      name: "users",
      component: Users,
    },
    // {
    //   path: "/talks",
    //   name: "talks",
    //   component: Talks,
    // },
    {
      path: "/profile",
      name: "profile",
      component: Profile,
    },
  ],
});

export default router;
