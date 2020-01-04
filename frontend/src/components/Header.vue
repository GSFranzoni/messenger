<template>
    <q-header elevated>
        <q-toolbar>
            <q-btn flat dense round @click="toggleMenu" icon="menu" aria-label="Menu" />
            <q-toolbar-title>Guibook Messenger</q-toolbar-title>
            <Profile />
        </q-toolbar>
    </q-header>
</template>

<script>
import Profile from './Profile';
import { mapState } from 'vuex';

export default {
    components: {
        Profile
    },
    methods: {
        toggleMenu: function() {
            this.$store.commit('setOpenMenu', !this.$store.getters.openMenu);
        }
    }
};
</script>

<style>
</style>