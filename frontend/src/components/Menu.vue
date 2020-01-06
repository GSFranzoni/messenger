<template>
    <q-drawer
        v-if="user!=null"
        v-model="openMenu"
        show-if-above
        bordered
        content-class="bg-grey-2"
    >
        <q-input outlined v-model="query" label="Buscar" style="margin: 10px;">
            <template v-slot:append>
                <q-icon v-if="query !== ''" name="close" class="cursor-pointer" @click="query = ''" />
                <q-icon name="search" />
            </template>
        </q-input>
        <q-list>
            <q-item-label header>
                <strong>Usuários</strong>
            </q-item-label>
            <transition-group name="list-complete">
                <q-item
                    @click="goToChat(u)"
                    v-for="u in filtered"
                    :key="u.id"
                    clickable
                    tag="a"
                    target="_blank"
                    class="user"
                    :class="{border: user.id === u.id}"
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
                    <q-avatar class="self-center" size="5px" :color="u.online? 'green': 'red'"></q-avatar>
                </q-item>
            </transition-group>
        </q-list>
    </q-drawer>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import axios from "axios";
import { baseApiUrl } from "../global";

export default {
    data: function() {
        return {
            query: '',
            filtered: []
        }
    },
    computed: {
        ...mapState(['user']),
        ...mapState(['users']),
        openMenu: {
            get() {
                return this.$store.getters.openMenu;
            },
            set(value) {
                this.$store.commit('setOpenMenu', value);
            }
        }
    },
    methods: {
        filterUsers: function() {
            this.filtered = this.users.filter(
                user => {
                    return user.name.toLowerCase().indexOf(this.query.toLowerCase()) !== -1
                }
            ).sort((a, b) => {
                try { 
                    return (a.id === this.user.id? -1: (b.id === this.user.id? 1: (a.online? -1: (b.online? 1: 0)))); 
                } 
                catch { 
                    return 0;
                }
            })
        },
        loadSocketEvents: function() {
            this.$store.getters.socket.on("onlineUsers", values => {
                for (let i = 0; i < this.users.length; i++) {
                    this.users[i]["online"] = values.map(value => parseInt(value.user)).indexOf(parseInt(this.users[i].id)) > -1;
                }
                this.filterUsers();
            });
            this.$store.getters.socket.emit("enter", this.$store.state.user.id);
        },
        goToChat: function(u) {
            this.$router.push({
                name: "Chat",
                params: {
                    to: u.id
                }
            });
        },
    },
    mounted: function() {
        this.loadSocketEvents();
        this.filtered = this.users;
    },
    filters: {
        upper: function(value) {
            return value.toUpperCase();
        }
    },
    watch: {
        query: function() {
            this.filterUsers();
        }
    }
};
</script>

<style lang="scss">
.list-complete-move {
    transition: all 1s;
}
.border {
    background-color: rgba($primary, .2);
    color: $primary;
}
</style>