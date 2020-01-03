<template>
    <div id="q-app">
        <router-view />
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import axios from 'axios';
import { baseApiUrl } from './global';

export default {
    computed: {
        user: {
            get() {
                return this.$store.getters.user
            },
            set(user) {
                this.$store.commit('setUser', user)
            }
        }
    },
    name: "App",
    created: async function() {
        try {
            let localUser = JSON.parse(localStorage.getItem('user'));
            const res = await axios.post(`${baseApiUrl}/validate`, {
                token: localUser['token']
            });
            this.$store.commit('setUser', localUser);
            this.$store.getters.socket.emit('enter', this.$store.state.user.id);
        }
        catch(e) {
            this.user = null;
            localStorage.removeItem('user');
            this.$router.push({
                path: 'auth'
            })
        }
    }
};
</script>
