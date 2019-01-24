import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import {routes} from './routes/router' 
import axios from 'axios'
import '../src/common/stylus/index.styl'
// import {baseUrl} from '../vue.config'

Vue.use(VueRouter)

axios.defaults.baseURL = 'https://www.atone.shop/'
axios.defaults.withCredentials = true
Vue.prototype.$axios = axios


Vue.config.productionTip = false

const router = new VueRouter({
  routes,
  base: process.env.BASE_URL,
  mode: 'history',
  linkActiveClass: 'active'
})

new Vue({
  el: "#app",
  router,
  render: h => h(App)
}).$mount('#app')
