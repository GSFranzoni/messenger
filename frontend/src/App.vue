<template>
    <div id="q-app">
        <router-view />
    </div>
</template>

<script>
import { mapState } from 'vuex';
import axios from 'axios';
import { baseApiUrl } from './global';

export default {
    computed: mapState({
        user: 'user'
    }),
    name: "App",
    created: async function() {

        try {
            let localUser = JSON.parse(localStorage.getItem('user'));

            const res = await axios.post(`${baseApiUrl}/validate`, {
                token: localUser['token']
            });

            this.$store.commit('setUser', localUser);
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
