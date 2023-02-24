import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import defaults from "./routes/defaults";
import NotFoundView from "../views/NotFoundView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "root",
      redirect: { name: "app" },
    },
    {
      path: "/app",
      name: "app",
      meta: { requiresAuth: true },
      redirect: { name: "app.dashboard" },
      children: [
        {
          meta: { title: "Dashboard", },
          path: "/dashboard",
          name: "app.dashboard",
          component: () => import("@/views/HomeView.vue"),
        },
        {
          meta: { title: "Products", },
          path: "/products",
          name: "app.products",
          component: () => import("@/views/Products/View.vue"),
        },
        {
          meta: { title: "Add new Product", },
          path: "/products/create",
          name: "app.products.create",
          component: () => import("@/views/Products/ItemView.vue"),
        },
        {
          meta: { title: "Update Product", },
          path: "/products/:id",
          name: "app.products.view",
          component: () => import("@/views/Products/ItemView.vue")
        },
        {
          meta: { title: "Users", },
          path: "/users",
          name: "app.users",
          component: () => import("@/views/Users/View.vue"),
        },
        {
          meta: { title: "View User", },
          path: "/users/:id",
          name: "app.users.view",
          component: () => import("@/views/Users/ItemView.vue")
        },
        {
          meta: { title: "Customers", },
          path: "/customers",
          name: "app.customers",
          component: () => import("@/views/Customers/View.vue"),
        },
        {
          meta: { title: "View Customer", },
          path: "/customers/:id",
          name: "app.customers.view",
          component: () => import("@/views/Customers/ItemView.vue"),
        },
        {
          meta: { title: "Orders", },
          path: "/orders",
          name: "app.orders",
          component: () => import("@/views/Orders/View.vue"),
        },
        {
          meta: { title: "View Order", },
          path: "/orders/:id",
          name: "app.orders.view",
          component: () => import("@/views/Orders/ItemView.vue"),
        },
        {
          meta: { title: "Contact Messages", },
          path: "/contact-messages",
          name: "app.contact.messages",
          component: () => import("@/views/Contact/Messages/View.vue"),
        },
        {
          meta: { title: "View Contact Message", },
          path: "/contact-messages/:id",
          name: "app.contact.messages.view",
          component: () => import("@/views/Contact/Messages/ItemView.vue"),
        },
        {
          meta: { title: "Reports", },
          path: "/reports",
          name: "app.reports",
          component: () => import("@/views/Reports/View.vue"),
          children: [
            {
              meta: { title: "Orders Report", },
              path: "/reports/orders/:date?",
              name: "app.reports.orders",
              component: () => import("@/views/Reports/OrdersView.vue"),
            },
            {
              meta: { title: "Customers Report", },
              path: "/reports/customers/:date?",
              name: "app.reports.customers",
              component: () => import("@/views/Reports/CustomersView.vue"),
            }
          ]
        },
        ...defaults,
      ],
    },
    {
      path: "/auth",
      name: "auth",
      meta: { isGuest: true },
      redirect: { name: "auth.login" },
      children: [
        {
          meta: { title: "Login", },
          path: "/login",
          name: "auth.login",
          component: () => import("@/views/LoginView.vue"),
        },
      ]
    },
    { path: "/:pathMatch(.*)*", name: "NotFound", component: NotFoundView },
  ]
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  if (to.meta.requiresAuth && !authStore.user.token) {
    next({ name: 'auth' });
  } else if (to.meta.isGuest && authStore.user.token) {
    next({ name:'app' });
  } else {
    next();
  }
});

export default router;
