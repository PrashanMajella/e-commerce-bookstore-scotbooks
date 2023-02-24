import {
  mdiAccountCircle,
  mdiMonitor,
  mdiDotsGrid,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiReact,
  mdiOrderBoolAscendingVariant,
  mdiAccountGroup,
  mdiAccountBox,
  mdiForum,
} from "@mdi/js";
export default [
  {
    to: { name: "app.dashboard" },
    icon: mdiMonitor,
    label: "Dashboard",
  },
  {
    to: { name: "app.products" },
    icon: mdiDotsGrid,
    label: "Products",
  },
  {
    to: { name: "app.orders" },
    icon: mdiOrderBoolAscendingVariant,
    label: "Orders",
  },
  {
    to: { name: "app.users" },
    icon: mdiAccountGroup,
    label: "Users",
  },
  {
    label: "Contact",
    icon: mdiAccountBox,
    menu: [
      {
        to: { name: "app.contact.messages" },
        icon: mdiForum,
        label: "Messages",
      },
    ]
  },
  {
    label: "Application",
    icon: mdiViewList,
    menu: [
      {
        to: { name: "app.defaults.tables" },
        label: "Tables",
        icon: mdiTable,
      },
      {
        to: { name: "app.defaults.forms" },
        label: "Forms",
        icon: mdiSquareEditOutline,
      },
      {
        to: { name: "app.defaults.ui" },
        label: "UI",
        icon: mdiTelevisionGuide,
      },
      {
        to: { name: "app.defaults.responsive" },
        label: "Responsive",
        icon: mdiResponsive,
      },
      {
        to: { name: "app.defaults.style" },
        label: "Styles",
        icon: mdiPalette,
      },
      {
        to: { name: "app.defaults.profile" },
        label: "Profile",
        icon: mdiAccountCircle,
      },
      {
        to: { name: "app.defaults.error" },
        label: "Error",
        icon: mdiAlertCircle,
      },
    ],
  },
  {
    href: "https://github.com/",
    label: "GitHub",
    icon: mdiGithub,
    target: "_blank",
  },

];
