import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)

const baseUrl =
  process.env.NODE_ENV === 'production'
    ? window.Laravel.baseUrl
    : 'http://laravel-example.test'

Vue.axios.defaults.baseURL = baseUrl + '/api'
