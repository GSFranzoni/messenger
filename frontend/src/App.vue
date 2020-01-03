<template>
    <div id="q-app">
        <router-view v-if="!loading" />
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import axios from "axios";
import { baseApiUrl } from "./global";
import { Loading, QSpinnerGears } from "quasar";

export default {
    data: function() {
        return {
            loading: true
        };
    },
    computed: {
        ...mapState(['user']),
        ...mapState(['users'])
    },
    name: "App",
    created: async function() {
        this.showLoading();
        try {
            let localUser = JSON.parse(localStorage.getItem("user"));
            const res = await axios.post(`${baseApiUrl}/validate`, {
                token: localUser["token"]
            });
            await this.loadUsers();
            await this.$store.commit("setUser", localUser);
        } 
        catch (e) {
            await this.$store.commit("setUser", null);
            localStorage.removeItem("user");
            this.$router.push({
                path: "auth"
            });
        }
        finally {
            this.hideLoading();
        }
    },
    methods: {
        loadUsers: async function() {
            await axios.get(`${baseApiUrl}/users`).then(response => {
                this.$store.commit("setUsers", response.data.data);
            });
        },
        hideLoading: function() {
            Loading.hide();
            this.loading = false;
        },
        showLoading: function() {
            Loading.show({
                spinner: QSpinnerGears,
                message: "Please, wait! Loading resources..."
            });
        }
    }
};
</script>
