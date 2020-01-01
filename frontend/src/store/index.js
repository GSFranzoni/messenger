import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default function () {
  const Store = new Vuex.Store({
    state: {
      user: null
    },
    mutations: {
      setUser: function (state, user) {
        state.user = user;
        if (user) {
          axios.defaults.headers.common['Authorization'] = `${user.token}`;
        }
      }
    },
    modules: {

    },
    strict: process.env.DEV
  })

  return Store
}
