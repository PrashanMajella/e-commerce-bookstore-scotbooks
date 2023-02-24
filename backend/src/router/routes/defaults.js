const defaults = [
  {
    meta: { title: "Application", },
    path: "/defaults",
    name: "app.defaults",
    component: () => import("@/views/Defaults/View.vue"),
    children: [
      {
        meta: { title: "Tables", },
        path: "/defaults/tables",
        name: "app.defaults.tables",
        component: () => import("@/views/Defaults/TablesView.vue"),
      },
      {
        meta: { title: "Forms", },
        path: "/defaults/forms",
        name: "app.defaults.forms",
        component: () => import("@/views/Defaults/FormsView.vue"),
      },
      {
        meta: { title: "Profile", },
        path: "/defaults/profile",
        name: "app.defaults.profile",
        component: () => import("@/views/Defaults/ProfileView.vue"),
      },
      {
        meta: { title: "Ui", },
        path: "/defaults/ui",
        name: "app.defaults.ui",
        component: () => import("@/views/Defaults/UiView.vue"),
      },
      {
        meta: { title: "Responsive layout", },
        path: "/defaults/responsive",
        name: "app.defaults.responsive",
        component: () => import("@/views/Defaults/ResponsiveView.vue"),
      },
      {
        meta: { title: "Select style", },
        path: "/defaults/style",
        name: "app.defaults.style",
        component: () => import("@/views/Defaults/StyleView.vue"),
      },
      {
        meta: { title: "Error", },
        path: "/defaults/error",
        name: "app.defaults.error",
        component: () => import("@/views/Defaults/ErrorView.vue"),
      }
    ]
  },
];

export default defaults;

