<template>
    <q-layout view="lHh Lpr lFf">
        <q-header elevated v-if="user">
            <q-toolbar>
                <q-btn
                    flat
                    dense
                    round
                    @click="leftDrawerOpen = !leftDrawerOpen"
                    icon="menu"
                    aria-label="Menu"
                />

                <q-toolbar-title>Guibook Messenger</q-toolbar-title>

                <div>Quasar v{{ $q.version }}</div>
            </q-toolbar>
        </q-header>

        <q-drawer
            v-if="user"
            v-model="leftDrawerOpen"
            show-if-above
            bordered
            content-class="bg-grey-2"
        >
            <q-list>
                <q-item-label header>Usuários</q-item-label>
                <q-item @click='goToChat(u)' v-for='u in users' :key='u.id' clickable tag="a" target="_blank" class='user'>
                    <q-item-section avatar>
                        <q-avatar size='45px'>
                            <img :src="`https://api.adorable.io/avatars/45/${u.id}.png`" alt="user-avatar">
                        </q-avatar>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>{{ u.name }}</q-item-label>
                        <q-item-label caption>{{ u.email }}</q-item-label>
                    </q-item-section>
                    <q-avatar class='self-center' size='5px' color="red"></q-avatar>
                </q-item>
            </q-list>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { baseApiUrl, getRandomColor } from "../global";

export default {
    computed: {...mapState({
                user: "user"
            })
    },
    name: "MyLayout",
    data() {
        return {
            leftDrawerOpen: true,
            users: []
        };
    },
    methods: {
        color: function() {
            return getRandomColor();
        },
        goToChat: function(u) {
            this.$router.push({
                name: 'Chat',
                params: {
                    'to': u.id
                }
            })
        }
    },
    mounted: function() {
        axios.get(`${baseApiUrl}/users`).then(response => {
            this.users = response.data.data;
        });
    },
    filters: {
        upper: function(value) {
            return value.toUpperCase();
        }
    }
};
</script>

<style>
    .user:hover > a {
        background-color: rgba(0, 0, 0, 0.2);
    }

    .user:active > a {
        background-color: rgba(0, 0, 0, 0.4);
    }
</style>
