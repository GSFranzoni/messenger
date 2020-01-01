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
            <q-input outlined v-model="query" label="Buscar" style='margin: 10px;'>
                <template v-slot:append>
                    <q-icon
                        v-if="query !== ''"
                        name="close"
                        class="cursor-pointer"
                        @click='query=""'
                    />
                    <q-icon name="search" />
                </template>
            </q-input>
            <q-list>
                <q-item-label header>Usuários</q-item-label>
                <transition-group name='list-complete'>
                    <q-item
                    @click="goToChat(u)"
                    v-for="u in filtered"
                    :key="u.id"
                    clickable
                    tag="a"
                    target="_blank"
                    class="user"
                >
                    <q-item-section avatar>
                        <q-avatar size="45px">
                            <img
                                :src="`https://api.adorable.io/avatars/45/${u.id}.png`"
                                alt="user-avatar"
                            />
                        </q-avatar>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>{{ u.name }}</q-item-label>
                        <q-item-label caption>{{ u.email }}</q-item-label>
                    </q-item-section>
                    <q-avatar class="self-center" size="5px" color="green"></q-avatar>
                </q-item>
                </transition-group>
                
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
    computed: {
        ...mapState({
            user: "user"
        })
    },
    name: "MyLayout",
    data() {
        return {
            leftDrawerOpen: true,
            users: [],
            query: '',
            filtered: []
        };
    },
    methods: {
        color: function() {
            return getRandomColor();
        },
        goToChat: function(u) {
            this.$router.push({
                name: "Chat",
                params: {
                    to: u.id
                }
            });
        }
    },
    mounted: function() {
        axios.get(`${baseApiUrl}/users`).then(response => {
            this.users = response.data.data;
            this.filtered = {...this.users}
        });
    },
    filters: {
        upper: function(value) {
            return value.toUpperCase();
        }
    },
    watch: {
        query: function() {
            this.filtered = this.users.filter(
                user => {
                    return user.name.toLowerCase().indexOf(this.query.toLowerCase()) !== -1
                }
            )
        }
    }
};
</script>

<style>
.list-complete-move {
    transition: all 1s;
}
</style>
