<template>
    <q-layout view="lHh Lpr lFf">
        <Header @toggleMenu="toggleMenu" />
        <Menu :open="openMenu" />
        <q-page-container v-if="user!=null">
            <router-view />
        </q-page-container>
    </q-layout>
</template> 

<script>
import Profile from "../components/Profile";
import Header from "../components/Header";
import Menu from "../components/Menu";
import { mapState } from 'vuex';

export default {
    components: {
        Profile, Header, Menu
    },
    name: "MainLayout",
    computed: {
        ...mapState(['user'])
    },
    data() {
        return {
            openMenu: true
        };
    },
    methods: {
        toggleMenu: function() {
            this.openMenu = !this.openMenu;
        }   
    }
};
</script>

<style lang='scss'>
.list-complete-move {
    transition: all 1s;
}
.border {
    background-color: rgba($primary, 0.2);
    color: $primary;
}
</style>
