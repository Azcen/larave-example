import Vue from 'vue'
import './registerServiceWorker'
import store from './store'
import vuetify from './plugins/vuetify'
import auth from '@websanova/vue-auth/dist/v2/vue-auth.esm.js'
import driverAuthBearer from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js'
import driverHttpAxios from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js'
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js'
import Vuelidate from 'vuelidate'
import './axios'
import './progress'
import router from './router'
import App from './App.vue'

Vue.config.productionTip = false

Vue.use(Vuelidate)
Vue.use(auth, {
  plugins: {
    http: Vue.axios, // Axios
    // http: Vue.http, // Vue Resource
    router: Vue.router
  },
  drivers: {
    auth: driverAuthBearer,
    http: driverHttpAxios,
    router: driverRouterVueRouter,
    rolesVar: 'view_permissions',
    parseUserData: (user) => user
    // oauth2: {
    //     google: driverOAuth2Google,
    //     facebook: driverOAuth2Facebook,
    // }
  },
  options: {
    rolesKey: 'type',
    notFoundRedirect: { name: 'user-account' }
  }
})

export default new Vue({
  router,
  store,
  vuetify,
  render: (h) => h(App)
}).$mount('#app')
