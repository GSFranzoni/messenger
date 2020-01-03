import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default function () {
    const Store = new Vuex.Store({
        state: {
            user: null,
            users: [],
            io: require("socket.io-client")
        },
        mutations: {
            setUser: function (state, user) {
                state.user = user;
                if (user) {
                    axios.defaults.headers.common['Authorization'] = `${user.token}`;
                }
            },
            setUsers: function(state, users) {
                state.users = users;
            }
        },
        getters: {
            user: function(state) {
                return state.user;
            },
            users: function(state) {
                return state.users;
            },
            socket: function(state) {
                return state.io("http://localhost:3000");
            }
        },
        modules: {

        },
        strict: process.env.DEV
    })

    return Store
}
