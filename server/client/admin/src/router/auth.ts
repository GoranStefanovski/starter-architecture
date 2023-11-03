import { RouteConfig } from 'vue-router'

// Layouts
import AuthBase from '@/layouts/Auth/AuthBase.vue'

// Pages
import Login from '@/pages/Auth/Login.vue'

export const authPaths: RouteConfig =
//  AUTHENTICATION
{
  path: "/",
  component: AuthBase,
  children: [
    {
      path: "",
      name: "home",
      component: Login,
    },
    {
      path: "login",
      name: "login",
      component: Login,
    },
  ]
}