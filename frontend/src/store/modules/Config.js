import Vue from 'vue'
import Vuex from 'vuex'
// import app from '../../main' // import the instance
import { AxiosResponse } from 'axios'

Vue.use(Vuex)

const state = {
  token: ''
}

const mutations = {
  SET_DATA(state, payload) {
    const token = document.head.querySelector('meta[name="csrf-token"]')
    console.log(token)
    if (token) {
      payload.csrfToken = token.content
    }

    Object.assign(state, { ...payload })
  }
}

const actions = {
  async loadData({ commit }) {
    let response = AxiosResponse

    const { status, data } = response

    if (status === 200 && !data.errors) {
      commit('SET_DATA', data)
    } else {
      console.log('theres n error')
    }
  }
}

const getters = {
  token: (state) => state.token
}

export default {
  state,
  mutations,
  actions,
  getters
}
