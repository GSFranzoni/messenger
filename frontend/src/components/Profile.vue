<template>
    <q-btn-dropdown v-if='user' flat label="Perfil">
        <div class="column justify-center items-center">
            <div class="column justify-center items-center q-ma-md">
                <q-avatar size='120px'>
                    <img :src="`https://api.adorable.io/avatars/120/${user.id}.png`" alt="user-avatar">
                </q-avatar>
            </div>
            <div class='column justify-center items-center q-mx-md'>
                <div class='text-primary text-h4'>{{ user.name }}</div>
                <div class='text-grey-9'>{{ user.email }}</div>
            </div>
        </div>
        <div class='row justify-center q-ma-md'>
            <q-btn outline color='red' @click='logout'>Sair</q-btn>
        </div>
    </q-btn-dropdown>
</template>

<script>
import { successMessage } from '../global';
import { mapState, mapGetters } from 'vuex';

export default {
    computed: {
        ...mapState(['user']),
        ...mapGetters(['socket'])
    },
    methods: {
        logout: function() {
            this.socket.emit('disconnectUser', this.user.id);
            localStorage.removeItem('user');
            this.$store.commit('setUser', null);
            this.$router.push({
                path: '/auth'
            });
            successMessage({ message: 'Logout efetuado com sucesso!' });
        }
    }
};
</script>

<style>
</style>